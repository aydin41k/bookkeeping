<?php

namespace App\Http\Controllers;

use App\Company;
use App\SalesInvoice;
use App\SalesInvoiceItem;
use Illuminate\Http\Request;

class SalesInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = SalesInvoice::orderBy('invoice_date','desc')->get();
        foreach($invoices as &$inv) {
            $inv->company_name = SalesInvoice::find($inv->id)->company->name;
            $inv->status = ($inv->status) ? 'Sent':'Draft';
        }
        return view('sales.index',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user('id');
        $mycompany = $user->company()->first(); //For now a user can only be linked to one company (one-to-many)
        $companies = Company::where('id','!=',$mycompany->id)->orderBy('name','asc')->get(['id','name']);
        $coys = ['Please select'];
        foreach($companies as $co) {
            $coys[$co->id] = $co->name;
        }
        $items = (new SalesItemController)->fetch();
        $item_options = [0=>'Select item'];
        foreach( $items as $item ) {
            $item_options[$item['id']] = $item['name'];
        }
        return view('sales.add',compact('coys','items','item_options'));
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
            'company_id' => 'required|gt:0',
            'invoice_date' => 'date',
            'item' => 'required',
            'qty' => 'required',
            'price' => 'required'
        ]);
        $new_invoice = SalesInvoice::create([
            "company_id" => $request->company_id,
            "invoice_date" => $request->invoice_date,
            "amount" => $request->amount,
            "delivery_date" => $request->delivery_date,
            "delivered_by" => $request->delivered_by,
            "status" => ($request->status == NULL) ? 1: $request->status,
            "user_id" => $user_id
        ]);
        foreach ($request->item as $key => $item) {
            $new_item = SalesInvoiceItem::create([
                "sales_invoice_id" => $new_invoice->id,
                "sales_item_id" => $item,
                "qty" => $request->qty[$key],
                "price" => $request->price[$key]
            ]);
        }
        return redirect()->action('SalesInvoiceController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SalesInvoice  $salesInvoice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $inv = SalesInvoice::find($id);
        $inv->company_name = $inv->company->name;
        $inv->status = ($inv->status) ? 'Final':'Draft';
        return view('sales.view',compact('inv'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SalesInvoice  $salesInvoice
     * @return \Illuminate\Http\Response
     */
    public function edit(SalesInvoice $salesInvoice)
    {
        $user = auth()->user('id');
        $mycompany = $user->company()->first(); //For now a user can only be linked to one company (one-to-many)
        $companies = Company::where('id','!=',$mycompany->id)->get(['id','name']);
        $coys = ['Please select'];
        foreach($companies as $co) {
            $coys[$co->id] = $co->name;
        }
        $items = (new SalesItemController)->fetch();        
        $item_options = [0=>'Select item'];
        foreach( $items as $item ) {
            $item_options[$item['id']] = $item['name'];
        }
        return view('sales.edit',compact('coys','items','item_options'))->with('inv',$salesInvoice);
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
        $salesInvoice = SalesInvoice::find($id);
        $salesInvoice->company_id = $request->company_id;
        $salesInvoice->invoice_date = $request->invoice_date;
        $salesInvoice->amount = $request->amount;
        $salesInvoice->delivery_date = $request->delivery_date;
        $salesInvoice->delivered_by = $request->delivered_by;
        $salesInvoice->status = ($request->status) ? 0:1;
        $salesInvoice->user_id = $user_id;
        $salesInvoice->save();

        // Delete all the items and re-add them - they don't have timestamps so doesn't matter
        $salesInvoice->items()->delete();
        foreach ($request->item as $key => $item) {
            $new_item = SalesInvoiceItem::create([
                "sales_invoice_id" => $salesInvoice->id,
                "sales_item_id" => $item,
                "qty" => $request->qty[$key],
                "price" => $request->price[$key]
            ]);
        }
        //echo $request->status;
        //echo '<pre>',print_r($salesInvoice),'</pre>';
        //return;
        return redirect()->action('SalesInvoiceController@show',$salesInvoice->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SalesInvoice  $salesInvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalesInvoice $salesInvoice)
    {
        $salesInvoice->delete();
        \Session::flash('status','Delete successful!');
        return redirect()->action('SalesInvoiceController@index');
    }
    public function print($id)
    {
        $user = auth()->user('id');
        $mycompany = $user->company()->first();

        $inv = SalesInvoice::find($id);
        $inv->company_name = $inv->company->name;
        $inv->status = ($inv->status) ? 'Final':'Draft';
        return view('sales.print',compact('mycompany','inv'));
    }
}
