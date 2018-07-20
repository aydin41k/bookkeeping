<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StockCount;
use App\CashBalance;

class AccountingController extends Controller
{
    public function index()
    {
    	$last_stock_count = StockCount::orderBy('date','desc')->first();
    	$last_cash_count = CashBalance::orderBy('date','desc')->first();
    	return view('accounting.index',compact('last_stock_count','last_cash_count'));
    }
}
