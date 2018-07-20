<?php

namespace App\Http\Controllers;

use App\Company;

use App\ExpenseInvoice;
use Illuminate\Http\Request;

class ExpenseInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = ExpenseInvoice::all();
        foreach($invoices as &$inv) {
            $inv->company_name = ExpenseInvoice::find($inv->id)->company->name;
        }
        return view('expenses.index',compact('invoices'));
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
        $companies = Company::where('id','!=',$mycompany->id)->get(['id','name']);
        $coys = ['Please select'];
        foreach($companies as $co) {
        	$coys[$co->id] = $co->name;
        }
        return view('expenses.add',compact('coys'));
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
        ]);

        $invoice_details = ExpenseInvoice::create([
            "invoice_no" => $request->invoice_no,
            "company_id" => $request->company_id,
            "invoice_date" => $request->invoice_date,
            "amount" => $request->amount,
            "user_id" => $user_id
        ]);

        return redirect('expenses-invoice');        
    }
   public function edit($id)
    {
        $inv = ExpenseInvoice::find($id);
        $user = auth()->user('id');
        $mycompany = $user->company()->first(); //For now a user can only be linked to one company (one-to-many)
        $companies = Company::where('id','!=',$mycompany->id)->get(['id','name']);
        $coys = ['Please select'];
        foreach($companies as $co) {
            $coys[$co->id] = $co->name;
        }
        return view('expenses.edit',compact('inv','coys'));
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
            "invoice_no" => 'required',
            'company_id' => 'required|gt:0',
            'invoice_date' => 'required|date',
        ]);
        $invoice_details = ExpenseInvoice::find($id);
        $invoice_details->invoice_no = $request->invoice_no;
        $invoice_details->company_id = $request->company_id;
        $invoice_details->invoice_date = $request->invoice_date;
        $invoice_details->amount = $request->amount;
        $invoice_details->user_id = $user_id;
        $invoice_details->save();

        return redirect()->action('ExpenseInvoiceController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SalesInvoice  $salesInvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inv = ExpenseInvoice::find($id);
        $inv->delete();
        \Session::flash('status','Delete successful!');
        return redirect()->action('ExpenseInvoiceController@index');
    }
}
