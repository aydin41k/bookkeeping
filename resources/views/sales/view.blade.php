@extends('layouts.app')
<?php
//echo 'Company:<pre>',print_r($inv->company),'</pre>';
//echo 'Items:<pre>',print_r($inv->items),'</pre>';
//die();
?>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h2 class="text-center">
                Sales Invoice #{{ $inv->id }}
                @if( $inv->status == 'Draft' )
                    <span class="text-danger">- Draft</span>
                @endif
            </h2>
            <div class="row">
                <div class="col-md-7 text-left">
                    <div><h5>Customer: <strong>{{ $inv->company_name }}</strong></h5></div>            
                    <div><h5>Invoice date: <strong>{{ Carbon\Carbon::parse($inv->invoice_date)->format('d-m-Y') }}</strong></h5></div>
                </div>
                <div class="col-md-5 text-right">
                    @if( $inv->delivery_date )
                    <div>Delivery date: {{ Carbon\Carbon::parse($inv->delivery_date)->format('d-m-Y') }}</div>
                    @endif
                    @if( $inv->delivered_by )
                    <div>Delivered by: {{ $inv->delivered_by }}</div>
                    @endif
                </div>
            </div>
            <div class="items-container mt-3">
                <div class="row">
                    <div class="col-sm-6"><strong>Item</strong></div>
                    <div class="col-sm-2 text-right"><strong>Qty</strong></div>
                    <div class="col-sm-2 text-right"><strong>Price</strong></div>
                    <div class="col-sm-2 text-right"><strong>Total</strong></div>
                </div>                
                @foreach( $inv->items as $item )
                <div class="row">
                    <div class="col-sm-6">{{ $item->info->name }}</div>
                    <div class="col-sm-2 text-right">{{ $item->qty }}</div>
                    <div class="col-sm-2 text-right">{{ number_format($item->price, 2, ',', '.') }}</div>
                    <div class="col-sm-2 text-right">{{ number_format($item->qty * $item->info->multiplier * $item->price, 2, '.', ',') }}</div>
                </div>
                @endforeach
                <div class="row">
                    <div class="col-sm-2 offset-sm-8 text-right border border-primary border-right-0">TOTAL:</div>
                    <div class="col-sm-2 text-right border border-primary border-left-0">{{ number_format($inv->amount, 2, '.', ',') }}</div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="text-center">
        <button type="button" onClick="location.href='{{ action('SalesInvoiceController@print',$inv->id) }}'" class="btn btn-primary mx-auto">Print</button> | 
        <button type="button" onClick="location.href='{{ action('SalesInvoiceController@edit',$inv->id) }}'" class="btn btn-warning mx-auto">Edit</button> | 
        {{ Form::open(['action' => ['SalesInvoiceController@destroy',$inv->id], 'class'=>'form-horizontal d-inline-block', 'method'=>'post']) }}
            {{ Form::hidden('_method', 'DELETE') }}
            {{ Form::submit('Delete', array('class' => 'btn btn-danger mx-auto')) }}
        {{ Form::close() }}
    </div>
</div>
@endsection