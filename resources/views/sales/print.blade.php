<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>
<body class="h-100 bg-white">
    <div id="app" class="h-100">
        <main class="py-4 h-100">
            <div class="container position-relative h-100">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-md-6 text-left">
                                <div><h4>{{ $mycompany->name }}</h4></div>
                                <div><small>ABN: {{ $mycompany->abn }}</small></div>
                            </div>
                            <div class="col-md-6 text-right">
                                <div>{{ $mycompany->address }}</div>
                                <div>Phone: {{ $mycompany->phone }}</div>
                                <div>Email: {{ $mycompany->email }}</div>
                            </div>
                        </div>
                        <h2 class="text-center my-5">
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
                        </div>
                    </div>
                </div>
                <div class="totals position-absolute w-100">
                    <div class="row mx-0">
                        <div class="col-sm-2 offset-sm-8 text-right border border-primary border-right-0">TOTAL:</div>
                        <div class="col-sm-2 text-right border border-primary border-left-0">{{ number_format($inv->amount, 2, '.', ',') }}</div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
<script>
    window.print();
</script>
</html>