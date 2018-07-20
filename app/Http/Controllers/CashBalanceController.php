<?php

namespace App\Http\Controllers;

use App\CashBalance;
use Illuminate\Http\Request;
use App\Http\Controller\AccountingController;

use Carbon\Carbon;

class CashBalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cash_balance_list = CashBalance::where('date','>',Carbon::now()->subMonths(3))->get();  
        return view('accounting.listcash',compact('cash_balance_list'));        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('accounting.addcashbalance');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'amount' => 'required|numeric',
        ]);

        $sc = CashBalance::create([
            "date" => $request->date,
            "amount" => $request->amount,
            "counted_by" => $request->counted_by,
        ]);

        return redirect()->action('AccountingController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CashBalance  $cashBalance
     * @return \Illuminate\Http\Response
     */
    public function show(CashBalance $cashBalance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CashBalance  $cashBalance
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = CashBalance::find($id);
        return view('accounting.editcashbalance')->with('item',$item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CashBalance  $cashBalance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            "date" => 'required|date',
            'amount' => 'required',
        ]);
        $item = CashBalance::find($id);
        $item->date = $request->date;
        $item->amount = $request->amount;
        $item->counted_by = $request->counted_by;
        $item->save();

        return redirect()->action('CashBalanceController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CashBalance  $cashBalance
     * @return \Illuminate\Http\Response
     */
    public function destroy(CashBalance $cashBalance)
    {
        //
    }
}
