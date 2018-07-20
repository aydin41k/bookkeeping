@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            {{ Form::open(['action' => 'PLController@show', 'class'=>'form-horizontal', 'method'=>'post', 'id'=>'top_form']) }}
                @if($errors->any())
                    <div class="text-danger">
                       <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group row">
                    {{ Form::label('from', 'From', array('class'=>'control-label col-md-2')) }}
                    {{ Form::date('from', $dates['from'], array('class'=>'form-control col-md-3')) }}
                </div>
                <div class="form-group row">
                    {{ Form::label('to', 'To', array('class'=>'control-label col-md-2')) }}
                    {{ Form::date('to', $dates['to'], array('class'=>'form-control col-md-3')) }}
                </div>
                <div class="form-group row">
                    <div class="col-md-10">
                        {{ Form::submit('Set dates',array('class'=>'btn btn-success')) }}
                        <button id="print_pl" class="btn btn-primary">Print the page</button>
                    </div>
                </div>
            {{ Form::close() }}
            <h3 class="text-center mt-5">Profit and Loss</h3>
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
<script>
    const applyToInput = (value,input_id) => $('#'+input_id).val(value.trim());
    const applyToSpan = (value,span_id) => $('#'+span_id).text(Number(value).toFixed(2));
    const toggleEdit = fieldGroup => {
        $('#'+fieldGroup+'_display').toggleClass('d-none');
        $('#'+fieldGroup+'_input').toggleClass('d-none');
    }
    const netProfitRecalc = ()=>{
        const grossProfit = $('.gross-profit').text();
        const cash = $('#cash_display').text();
        const stock = $('#stock_display').text();
        const netProfit = Number(grossProfit) + Number(cash) + Number(stock);
        $('.net-profit').text(netProfit.toFixed(2));
    }
    $(document).on('click','#cash_display',function() {
        toggleEdit('cash');
    });
    $(document).on('click','#stock_display',function() {
        toggleEdit('stock');
    });
    $(document).on('change','#cash_input',()=>{
        applyToSpan($('#cash_input').val(),'cash_display');
        toggleEdit('cash');
        netProfitRecalc();
    });
    $(document).on('change','#stock_input',()=>{
        applyToSpan($('#stock_input').val(),'stock_display');
        toggleEdit('stock');
        netProfitRecalc();
    });
    $(document).on('click','#print_pl',(e)=>{
        e.preventDefault();
        $('#top_form').slideUp('slow',()=>{
            window.print();
        });
    });
    $(function() {
        applyToInput($('#cash_display').text(),'cash_input');
        applyToInput($('#stock_display').text(),'stock_input');
        netProfitRecalc();
    })
</script>
@endsection