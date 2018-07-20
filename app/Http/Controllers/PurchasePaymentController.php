<?php

namespace App\Http\Controllers;

use App\Company;
use App\PurchasePayment;
use Illuminate\Http\Request;

class PurchasePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = PurchasePayment::all();
        $methods = ['','Cash','Cheque','Bank transfer'];        
        foreach($payments as &$pmt) {
            $pmt->company_name = PurchasePayment::find($pmt->id)->company->name;
            $pmt->payment_method = $methods[$pmt->payment_method];
        }
        return view('purchases.pmt',compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();
        return view('purchases.addpmt')->with('user',$user);
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
            'payment_method' => 'required'
        ]);

        $payment_details = PurchasePayment::create([
            "company_id" => $request->company_id,
            "date" => $request->date,
            "amount" => $request->amount,
            "payment_method" => $request->payment_method,
            "notes" => $request->notes,
            "user_id" => $user_id
        ]);

        return redirect()->action('PurchasePaymentController@index');        
    }
    public function edit($id)
    {
        $pmt = PurchasePayment::find($id);
        $user = auth()->user('id');
        $mycompany = $user->company()->first(); //For now a user can only be linked to one company (one-to-many)
        $companies = Company::where('id','!=',$mycompany->id)->get(['id','name']);
        $coys = ['Please select'];
        foreach($companies as $co) {
            $coys[$co->id] = $co->name;
        }
        return view('purchases.editpmt',compact('pmt','coys'));
    }

    public function update(Request $request, $id)
    {
        $user_id = auth()->user()->id;
        // Validation
        $request->validate([
            'company_id' => 'required|gt:0',
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'payment_method' => 'required'
        ]);

        $payment_details = PurchasePayment::find($id);
        $payment_details->company_id = $request->company_id;
        $payment_details->date = $request->date;
        $payment_details->amount = $request->amount;
        $payment_details->payment_method = $request->payment_method;
        $payment_details->notes = $request->notes;
        $payment_details->user_id = $user_id;
        $payment_details->save();

        \Session::flash('status','Edit successful!');        
        return redirect()->action('PurchasePaymentController@index');        
    }

    public function destroy($id)
    {
        $pmt = PurchasePayment::find($id);
        $pmt->delete();
        \Session::flash('status','Delete successful!');
        return redirect()->action('PurchasePaymentController@index');
    }
}
