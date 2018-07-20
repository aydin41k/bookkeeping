<?php

namespace App\Http\Controllers;

use App\PurchaseInvoice;
use App\PurchaseInvoiceItem;
use App\Company;
use Illuminate\Http\Request;

class PurchaseInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = PurchaseInvoice::orderBy('invoice_date','desc')->get();
        foreach($invoices as &$inv) {
            $inv->company_name = PurchaseInvoice::find($inv->id)->company->name;
        }
        return view('purchases.index',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();
        $mycompany = $user->company()->first(); //For now a user can only be linked to one company (one-to-many)
        $companies = Company::where('id','!=',$mycompany->id)->get(['id','name']);
        $coys = ['Please select'];
        foreach($companies as $co) {
            $coys[$co->id] = $co->name;
        }
        $items = (new PurchaseItemController)->fetch();
        return view('purchases.add',compact('coys','items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = auth()->user()->id;
        // Validation
        $request->validate([
            "invoice_no" => 'required',
            'company_id' => 'required|gt:0',
            'invoice_date' => 'required|date',
            'qty' => 'required',
            'price' => 'required',
            'item' => 'required'
        ]);

        // Map two arrays to multiply corresponding elements, then sum the result array
        $amount = array_sum(array_map(function($x,$y) { return $x*$y; },$request->price,$request->qty));
        $new_invoice = PurchaseInvoice::create([
            "invoice_no" => $request->invoice_no,
            "company_id" => $request->company_id,
            "invoice_date" => $request->invoice_date,
            "amount" => $request->amount,
            "delivery_date" => $request->delivery_date,
            "delivered_by" => $request->delivered_by,
            "user_id" => $user_id
        ]);
        foreach ($request->item as $key => $item) {
            $new_item = PurchaseInvoiceItem::create([
                "invoice_id" => $new_invoice->id,
                "item_id" => $item,
                "qty" => $request->qty[$key],
                "price" => $request->price[$key]
            ]);
        }
        return redirect()->action('PurchaseInvoiceController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PurchaseInvoice  $purchaseInvoice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PurchaseInvoice  $purchaseInvoice
     * @return \Illuminate\Http\Response
     */
   public function edit($id)
    {
        $inv = PurchaseInvoice::find($id);
        $user = auth()->user('id');
        $mycompany = $user->company()->first(); //For now a user can only be linked to one company (one-to-many)
        $companies = Company::where('id','!=',$mycompany->id)->get(['id','name']);
        $coys = ['Please select'];
        foreach($companies as $co) {
            $coys[$co->id] = $co->name;
        }
        $items = (new PurchaseItemController)->fetch();        
        return view('purchases.edit',compact('inv','coys','items'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SalesInvoice  $salesInvoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $user_id = auth()->user()->id;
        // Validation
        $request->validate([
            'company_id' => 'required|gt:0',
            'invoice_date' => 'date',
            'item' => 'required',
            'qty' => 'required',
            'price' => 'required'
        ]);
        // Map two arrays to multiply corresponding elements, then sum the result array
        $amount = array_sum(array_map(function($x,$y) { return $x*$y; },$request->price,$request->qty));
        $purchaseInvoice = PurchaseInvoice::find($id);
        $purchaseInvoice->company_id = $request->company_id;
        $purchaseInvoice->invoice_date = $request->invoice_date;
        $purchaseInvoice->amount = $amount;
        $purchaseInvoice->delivery_date = $request->delivery_date;
        $purchaseInvoice->delivered_by = $request->delivered_by;
        $purchaseInvoice->user_id = $user_id;
        $purchaseInvoice->save();

        // Delete all the items and re-add them - they don't have timestamps so doesn't matter
        $purchaseInvoice->items()->delete();
        foreach ($request->item as $key => $item) {
            $new_item = PurchaseInvoiceItem::create([
                "invoice_id" => $id,
                "item_id" => $item,
                "qty" => $request->qty[$key],
                "price" => $request->price[$key]
            ]);
        }
        //echo $request->status;
        //echo '<pre>',print_r($salesInvoice),'</pre>';
        //return;
        return redirect()->action('PurchaseInvoiceController@index',$purchaseInvoice->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SalesInvoice  $salesInvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $purchaseInvoice = PurchaseInvoice::find($id);
        $purchaseInvoice->delete();
        \Session::flash('status','Delete successful!');
        return redirect()->action('PurchaseInvoiceController@index');
    }
}
