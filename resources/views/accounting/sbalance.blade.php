@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Collection Balances</div>
                <div class="card-body">
                    @empty( $dr )
                    <div>No companies added to the system</div>
                    @else
                        <div class="row border border-top-0 border-right-0 border-left-0">
                            <div class="col-md-6"><strong>Co name</strong></div>
                            <div class="col-md-2"><strong>Total sales</strong></div>
                            <div class="col-md-2"><strong>Total payments</strong></div>
                            <div class="col-md-2"><strong>Balance</strong></div>
                        </div>
                        @foreach( $dr as $d )
                        @if( $d->salesinvoice->sum('amount') )
                        <div class="row lineitem">
                            <div class="col-md-6"><a href="{{ action('CompanyController@balance',$d->id,'dr') }}">{{ $d->name }}</a></div>
                            <div class="col-md-2 sale text-right">{{ number_format($d->salesinvoice->sum('amount'),2,'.','') }}</div>
                            <div class="col-md-2 payment text-right">{{ number_format($d->collections->sum('amount'),2,'.','') }}</div>
                            <div class="col-md-2 balance text-right">{{ number_format($d->balance,2,'.','') }}</div>
                        </div>
                        @endif
                        @endforeach
                        <div class="row border border-bottom-0 border-right-0 border-left-0 totals">
                            <div class="col-md-6"></div>
                            <div id="total_sales" class="col-md-2 text-right"></div>
                            <div id="total_payments" class="col-md-2 text-right"></div>
                            <div id="total_balance" class="col-md-2 text-right"><strong></strong></div>
                        </div>
                    @endempty
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(()=>{
        let sales = 0;
        let payment = 0;
        let balance = 0;
        $('.lineitem').each(function() {
            sales += Number($(this).children('.sale').text());
            payment += Number($(this).children('.payment').text());
            balance += Number($(this).children('.balance').text());
        });
        $('#total_sales').text(sales.toFixed(2));
        $('#total_payments').text(payment.toFixed(2));
        $('#total_balance strong').text(balance.toFixed(2));
    })
</script>
@endsection