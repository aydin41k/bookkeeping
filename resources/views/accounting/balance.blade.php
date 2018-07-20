@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Balance with {{ $company->name }}</div>
                <div class="card-body">
                    <div class="row border border-top-0 border-right-0 border-left-0">
                        <div class="col-md-6"><strong>#</strong></div>
                        <div class="col-md-2 text-right"><strong>Dr</strong></div>
                        <div class="col-md-2 text-right"><strong>Cr</strong></div>
                        <div class="col-md-2 text-right"><strong>Balance</strong></div>
                    </div>
                    @if( $company->account == 'dr' )
                        @foreach( $dr as $d )
                        <div class="row lineitem">
                            <div class="col-md-2 date">
                                @if( $d->invoice_date )
                                {{ Carbon\Carbon::parse($d->invoice_date)->format('d-m-Y') }}
                                @else
                                {{ Carbon\Carbon::parse($d->date)->format('d-m-Y') }}
                                @endif
                            </div>
                            <div class="col-md-4">
                                @if( $d->invoice_date )
                                Sale #{{ $d->id }}
                                @else
                                Collection #{{ $d->id }}
                                @endif
                            </div>
                            <div class="col-md-2 sale text-right">
                                @if( $d->invoice_date )
                                {{ number_format($d->amount,2,'.','') }}
                                @endif
                            </div>
                            <div class="col-md-2 payment text-right">
                                @empty( $d->invoice_date )
                                {{ number_format($d->amount,2,'.','') }}
                                @endempty
                            </div>
                            <div class="col-md-2 balance text-right">

                            </div>
                        </div>
                        @endforeach
                    @elseif( $company->account == 'cr' )
                        @foreach( $cr as $c )
                        <div class="row lineitem">
                            <div class="col-md-2 date">
                                @if( $c->invoice_date )
                                {{ Carbon\Carbon::parse($c->invoice_date)->format('d-m-Y') }}
                                @else
                                {{ Carbon\Carbon::parse($c->date)->format('d-m-Y') }}
                                @endif
                            </div>
                            <div class="col-md-4">
                                @if( $c->invoice_date )
                                Sale #{{ $c->id }}
                                @else
                                Collection #{{ $c->id }}
                                @endif
                            </div>
                            <div class="col-md-2 sale text-right">
                                @if( $c->invoice_date )
                                {{ number_format($c->amount,2,'.','') }}
                                @endif
                            </div>
                            <div class="col-md-2 payment text-right">
                                @empty( $c->invoice_date )
                                {{ number_format($c->amount,2,'.','') }}
                                @endempty
                            </div>
                            <div class="col-md-2 balance text-right">

                            </div>
                        </div>
                        @endforeach
                    @else
                        <div>No information added to the system</div>
                    @endif
                    <div class="row border border-bottom-0 border-right-0 border-left-0 totals">
                        <div class="col-md-6"></div>
                        <div id="total_sales" class="col-md-2 text-right"></div>
                        <div id="total_payments" class="col-md-2 text-right"></div>
                        <div id="total_balance" class="col-md-2 text-right"><strong></strong></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const moveUp = e=>{
        let thisDateArray = $(e).children('.date').text().trim().split('-');
        let thisDate = new Date(Date.UTC(thisDateArray[2],thisDateArray[1]-1,thisDateArray[0]));
        let prevDateArray = $(e).prev().children('.date').text().trim().split('-');
        let prevDate = new Date(Date.UTC(prevDateArray[2],prevDateArray[1]-1,prevDateArray[0]));
        if ( thisDate < prevDate ) {
            $(e).insertBefore($(e).prev());
            moveUp(e);
        } else {
            return;
        }
    }
    $(()=>{
        // Sort the lines by date
        $('.lineitem').each(function(i,e){
            if( i == 0 ) return;
            else moveUp(e);
        });
        // Calculate balance fields
        let lastBalance = 0;
        let thisBalance = 0;
        let thisSale = 0;
        let thisPayment = 0;
        let totalSales = 0;
        let totalPayments = 0;
        $('.balance').each(function(i,e) {
            thisSale = Number($(e).siblings('.sale').text());
            totalSales += thisSale;
            thisPayment = Number($(e).siblings('.payment').text());
            totalPayments += thisPayment;
            thisBalance = lastBalance + thisSale - thisPayment;
            // Line balances
            $(this).text(thisBalance.toFixed(2));
            lastBalance = thisBalance;
        });
        // Column totals        
        $('#total_sales').text(totalSales.toFixed(2));
        $('#total_payments').text(totalPayments.toFixed(2));
        $('#total_balance strong').text(lastBalance.toFixed(2));        
    })
</script>
@endsection