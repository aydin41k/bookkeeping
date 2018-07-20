<?php

namespace App\Http\Controllers;

use App\PurchaseItem;
use Illuminate\Http\Request;

class PurchaseItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $items = PurchaseItem::all();
        return view('purchases.item',compact('user_id','items'));
    }

    public function fetch()
    {
        return PurchaseItem::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('purchases.additem');
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

        $invoice_details = PurchaseItem::create([
            "name" => $request->name,
            "default_price" => $request->default_price
        ]);

        return redirect()->action('PurchaseItemController@index');        
    }
    public function edit($id)
    {
        $user_id = auth()->user()->id;
        $item = PurchaseItem::find($id);
        return view('purchases.edititem',compact('user_id','item'));
    }
    public function update(Request $request,$id)
    {
        $user_id = auth()->user()->id;
        // Validation
        $request->validate([
            'name' => 'required'
        ]);

        $item = PurchaseItem::find($id);
        $item->name = $request->name;
        $item->default_price = $request->default_price;
        $item->save();
        \Session::flash('status','Edit successful!');        
        return redirect()->action('PurchaseItemController@index');        
    }

    public function destroy($id)
    {
        $item = PurchaseItem::find($id);
        $item->delete();
        \Session::flash('status','Delete successful!');
        return redirect()->action('PurchaseItemController@index');
    }
}
