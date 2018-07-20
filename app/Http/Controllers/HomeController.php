<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\SalesInvoice;
use App\SalesPayment;
use App\SalesItem;
use App\PurchaseInvoice;
use App\PurchasePayment;
use App\PurchaseItem;
use App\ExpenseInvoice;
use App\ExpensePayment;
use App\StockCount;
use App\CashBalance;

use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user('id');
        $mycompany = $user->company()->first(); //For now a user can only be linked to one company (one-to-many)
        // If no mycompany->id, give it a value of 0 so that $companies does not break
        if( empty($mycompany) ) $mycompany = Company::find(0);
        $invoices = SalesInvoice::orderBy('invoice_date','desc')->limit(20)->get();
        foreach($invoices as &$inv) {
            $inv->company_name = SalesInvoice::find($inv->id)->company->name;
            $inv->status = ($inv->status) ? 'Sent':'Draft';
        }
        $from = Carbon::now()->startOfWeek();
        $to = Carbon::now()->endOfWeek();
        $dates = ['from'=>$from,'to'=>$to];
        $data = new \stdClass();
        $data->sales = SalesInvoice::whereBetween('invoice_date',[$from,$to])->sum('amount');
        $data->purchases = PurchaseInvoice::whereBetween('invoice_date',[$from,$to])->sum('amount');
        $data->expenses = ExpenseInvoice::whereBetween('invoice_date',[$from,$to])->sum('amount');;
        $data->grossprofit = $data->sales - $data->purchases - $data->expenses;
        $data->stock = StockCount::select('amount')->whereBetween('date',[$from,$to])->orderBy('date','desc')->first();
        $data->cash = CashBalance::select('amount')->whereBetween('date',[$from,$to])->orderBy('date','desc')->first();
        return view('home',compact('user','mycompany','invoices','data'));
    }
}
