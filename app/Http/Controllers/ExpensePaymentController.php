<?php

namespace App\Http\Controllers;

use App\ExpensePayment;
use App\Company;
use App\Http\Controllers\PaymentMethodController;
use Illuminate\Http\Request;

class ExpensePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = ExpensePayment::all();
        foreach($payments as &$pmt) {
            $pmt->company_name = ExpensePayment::find($pmt->id)->company->name;
        }
        if( $payments ) {
	        $pmt_methods = (new PaymentMethodController)->getList();
	        foreach($payments as &$pmt) {
	        	$pmt->payment_method = $pmt_methods[$pmt->payment_method];
	        }
	    }
        return view('expenses.pmt',compact('payments'));
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
        $pmt_methods = (new PaymentMethodController)->getList();
        $pmt_methods[0] = 'Please select';
        return view('expenses.addpmt',compact('coys','pmt_methods'));
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
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'payment_method' => 'required|gt:0'
        ]);

        $payment_details = ExpensePayment::create([
            "company_id" => $request->company_id,
            "date" => $request->date,
            "amount" => $request->amount,
            "payment_method" => $request->payment_method,
            "notes" => $request->notes,
            "user_id" => $user_id
        ]);

        return redirect()->action('ExpensePaymentController@index');        
    }
    public function edit($id)
    {
        $pmt = ExpensePayment::find($id);
        $user = auth()->user('id');
        $mycompany = $user->company()->first(); //For now a user can only be linked to one company (one-to-many)
        $companies = Company::where('id','!=',$mycompany->id)->get(['id','name']);
        $coys = ['Please select'];
        foreach($companies as $co) {
            $coys[$co->id] = $co->name;
        }
        $pmt_methods = (new PaymentMethodController)->getList();
        $pmt_methods[0] = 'Please select';
        return view('expenses.editpmt',compact('pmt','coys','pmt_methods'));
    }

    public function update(Request $request, $id)
    {
        $user_id = auth()->user()->id;
        // Validation
        $request->validate([
            'company_id' => 'required|gt:0',
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'payment_method' => 'required|gt:0'
        ]);
        $payment_details = ExpensePayment::find($id);
        $payment_details->company_id = $request->company_id;
        $payment_details->date = $request->date;
        $payment_details->amount = $request->amount;
        $payment_details->payment_method = $request->payment_method;
        $payment_details->notes = $request->notes;
        $payment_details->user_id = $user_id;
        $payment_details->save();

        \Session::flash('status','Edit successful!');        
        return redirect()->action('ExpensePaymentController@index');        
    }

    public function destroy($id)
    {
        $pmt = ExpensePayment::find($id);
        $pmt->delete();
        \Session::flash('status','Delete successful!');
        return redirect()->action('ExpensePaymentController@index');
    }
}
