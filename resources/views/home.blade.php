@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
    	<div class="col-md-3">
    		<h3>Menu</h3>
    		<div class="card">
    			<div class="card-header">In-House</div>
    			<div class="card-body">
    				<ul class="sidebar">
    					<li><a href="">Home</a></li>
    					<li><a href="{{ action('CompanyController@mycompany') }}">My Company</a></li>
    					<li><a href="{{ action('CompanyController@index') }}">Other Companies</a></li>
    				</ul>
    			</div>
    		</div>
    		<br>
    		<div class="card">
    			<div class="card-header">Reports</div>
    			<div class="card-body">
    				<ul class="sidebar">
    					<li><a href="/pl">Profit and Loss</a></li>
    					<li><a href="{{ action('CompanyController@collection_balances') }}">Collection balances</a></li>
                        <li><a href="{{ action('CompanyController@payment_balances') }}">Payment balances</a></li>
                        <li><a href="/accounting">Cash/Stock balances</a></li>
    					<li>Stock registry(coming soon)</li>
    				</ul>
    			</div>
    		</div>
    		<br>
    		<div class="card">
    			<div class="card-header">Sales</div>
    			<div class="card-body">
    				<ul class="sidebar">
    					<li><a href="{{ action('SalesInvoiceController@index') }}">Invoices</a></li>
    					<li><a href="{{ action('SalesPaymentController@index') }}">Collections</a></li>
                        <li><a href="{{ action('SalesItemController@index') }}">Items</a></li>
    				</ul>
    			</div>
    		</div>
    		<br>
    		<div class="card">
    			<div class="card-header">Purchases</div>
    			<div class="card-body">
    				<ul class="sidebar">
    					<li><a href="{{ action('PurchaseInvoiceController@index') }}">Invoices</a></li>
    					<li><a href="{{ action('PurchasePaymentController@index') }}">Payments</a></li>
                        <li><a href="{{ action('PurchaseItemController@index') }}">Items</a></li>
    				</ul>
    			</div>
    		</div>
    		<br>
    		<div class="card">
    			<div class="card-header">Expenses</div>
    			<div class="card-body">
    				<ul class="sidebar">
                        <li><a href="{{ action('ExpenseInvoiceController@index') }}">Invoices</a></li>
                        <li><a href="{{ action('ExpensePaymentController@index') }}">Payments</a></li>
    				</ul>
    			</div>
    		</div>
    	</div>
        <div class="col-md-9">
	        <h3>Hi, {{ $user->name }}!</h3>
            <h4>You are managing <strong>{{ $mycompany->name }}</strong>.</h4>
            <h3 class="text-center mt-5">Profit and Loss</h3>
            <h4 class="text-center">Last week</h4>
            <div class="row">
                <div class="col-md-3 offset-md-3 text-left">Sales</div>
                <div class="col-md-3 text-right">{{ $data->sales }}</div>
            </div>
            <div class="row">
                <div class="col-md-3 offset-md-3 text-left">Purchases</div>
                <div class="col-md-3 text-right">{{ $data->purchases }}</div>
            </div>
            <div class="row">
                <div class="col-md-3 offset-md-3 text-left">Expenses</div>
                <div class="col-md-3 text-right">{{ $data->expenses }}</div>
            </div>
            <div class="row border border-right-0 border-bottom-0 border-left-0">
                <div class="col-md-3 offset-md-3 text-left">Gross profit</div>
                <div class="col-md-3 text-right gross-profit">{{ number_format($data->grossprofit, 2, '.','') }}</div>
            </div>
            <div class="row mt-4">
                <div class="col-md-3 offset-md-3 text-left">Cash/Bank</div>
                <div class="col-md-3 text-right">
                    <input type="text" id="cash_input" class="text-right d-none">
                    <span id="cash_display">
                        @if( $data->cash )
                        {{ number_format($data->cash->amount, 2, '.','') }}
                        @else
                        0.00
                        @endif
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 offset-md-3 text-left">Stock</div>
                <div class="col-md-3 text-right">
                    <input type="text" id="stock_input" class="text-right d-none">
                    <span id="stock_display">
                        @if( $data->stock )
                        {{ number_format($data->stock->amount, 2, '.','') }}
                        @else
                        0.00
                        @endif
                    </span>
                </div>
            </div>
            <div class="row border border-right-0 border-bottom-0 border-left-0">
                <div class="col-md-3 offset-md-3 text-left">Net position</div>
                <div class="col-md-3 text-right net-profit"></div>
            </div>
        </div>
    </div>
</div>
@endsection
