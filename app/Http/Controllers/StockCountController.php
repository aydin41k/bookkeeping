<?php

namespace App\Http\Controllers;

use App\StockCount;
use Illuminate\Http\Request;
use App\Http\Controller\AccountingController;

use Carbon\Carbon;

class StockCountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stock_list = StockCount::where('date','>',Carbon::now()->subMonths(3))->get();  
        return view('accounting.liststock',compact('stock_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('accounting.addstock');
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

        $sc = StockCount::create([
            "date" => $request->date,
            "amount" => $request->amount,
            "counted_by" => $request->counted_by,
        ]);

        return redirect()->action('AccountingController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StockCount  $stockCount
     * @return \Illuminate\Http\Response
     */
    public function show(StockCount $stockCount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StockCount  $stockCount
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = StockCount::find($id);
        return view('accounting.editstock')->with('item',$item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StockCount  $stockCount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            "date" => 'required|date',
            'amount' => 'required',
        ]);
        $item = StockCount::find($id);
        $item->date = $request->date;
        $item->amount = $request->amount;
        $item->counted_by = $request->counted_by;
        $item->save();

        return redirect()->action('StockCountController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StockCount  $stockCount
     * @return \Illuminate\Http\Response
     */
    public function destroy(StockCount $stockCount)
    {
        //
    }
}
