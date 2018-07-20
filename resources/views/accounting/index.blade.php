@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Stock</div>
                <div class="card-body">
                    <div>Last stock count: {{ number_format($last_stock_count->amount, 2, '.', ',') }}</div>
                    <div>Counted on: {{ Carbon\Carbon::parse($last_stock_count->date)->format('d.m.Y') }}</div>
                    <div><a href="{{ action('StockCountController@create') }}">Add Stock Count</a></div>
                    <div><a href="{{ action('StockCountController@index') }}">View Stock History</a></div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">Cash in hand/Bank balance</div>
                <div class="card-body">
                    <div>Last cash+bank balance: {{ number_format($last_cash_count->amount, 2, '.', ',') }}</div>
                    <div>Counted on: {{ Carbon\Carbon::parse($last_cash_count->date)->format('d.m.Y') }}</div>
                    <div><a href="{{ action('CashBalanceController@create') }}">Add Cash/Bank Balance</a></div>
                    <div><a href="{{ action('CashBalanceController@index') }}">View Cash Balance History</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection