<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SalesInvoice;
use App\PurchaseInvoice;
use App\ExpenseInvoice;
use App\StockCount;
use App\CashBalance;
use Carbon\Carbon;

class PLController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pl.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $request->validate([
            "from" => 'required|date',
            "to" => 'required|date'
        ]);
        $from = $request->from;
        $to = $request->to;
        $dates = ['from'=>$from,'to'=>$to];
        $data = new \stdClass();
        $data->sales = SalesInvoice::whereBetween('invoice_date',[$from,$to])->sum('amount');
        $data->purchases = PurchaseInvoice::whereBetween('invoice_date',[$from,$to])->sum('amount');
        $data->expenses = ExpenseInvoice::whereBetween('invoice_date',[$from,$to])->sum('amount');;
        $data->grossprofit = $data->sales - $data->purchases - $data->expenses;
        $data->stock = StockCount::select('amount')->whereBetween('date',[$from,$to])->orderBy('date','desc')->first();
        $data->cash = CashBalance::select('amount')->whereBetween('date',[$from,$to])->orderBy('date','desc')->first();
        return view('pl.pl',compact('dates','data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
