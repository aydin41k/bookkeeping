<?php

namespace App\Http\Controllers;

use App\SalesItem;
use Illuminate\Http\Request;

class SalesItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $items = SalesItem::all();
        return view('sales.item',compact('user_id','items'));
    }

    public function fetch()
    {
    	return SalesItem::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sales.additem');
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
            'name' => 'required'
        ]);

        $request->multiplier = ($request->multiplier) ?: 1;

        $invoice_details = SalesItem::create([
            "name" => $request->name,
            "multiplier" => $request->multiplier,
            "default_price" => $request->default_price
        ]);

        return redirect()->action('SalesItemController@index');        
    }

    public function edit($id)
    {
        $item = SalesItem::find($id);
        return view('sales.edititem')->with('item',$item);
    }
    public function update(Request $request,$id)
    {
        $user_id = auth()->user()->id;
        // Validation
        $request->validate([
            'name' => 'required'
        ]);
        
        $request->multiplier = ($request->multiplier) ?: 1;

        $item = SalesItem::find($id);
        $item->name = $request->name;
        $item->multiplier = $request->multiplier;
        $item->default_price = $request->default_price;
        $item->save();
        \Session::flash('status','Edit successful!');        
        return redirect()->action('SalesItemController@index');        
    }

    public function destroy($id)
    {
        $item = SalesItem::find($id);
        $item->delete();
        \Session::flash('status','Delete successful!');
        return redirect()->action('SalesItemController@index');
    }
}
