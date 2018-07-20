@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">Add a Sales Invoice</div>
                <div class="card-body">
                    {{ Form::open(['action' => 'SalesInvoiceController@store', 'class'=>'form-horizontal', 'method'=>'post']) }}
                        @if($errors->any())
                            <div class="text-danger">
                               <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @empty( $items )
                            <div class="text-danger">
                                <h3>You have not added any sales items in your system. Please proceed to {{ action('SalesItemController@index') }} to add sales items.</h3>
                            </div>
                        @endempty
                        <div class="form-group row">
                            {{ Form::label('company_id', 'Customer', array('class'=>'control-label col-md-2')) }}
                            {{ Form::select('company_id', $coys, '', ['class'=>'form-control col-md-10','autocomplete'=>'off']) }}
                        </div>
                        <div class="form-group row">
                            {{ Form::label('invoice_date', 'Invoice date', array('class'=>'control-label col-md-2')) }}
                            {{ Form::date('invoice_date', '', array('class'=>'form-control col-md-3')) }}
                        </div>
                        <div class="form-group row">
                            {{ Form::label('delivery_date', 'Delivery date', array('class'=>'control-label col-md-2')) }}
                            {{ Form::date('delivery_date', '', array('class'=>'form-control col-md-3')) }}
                        </div>
                        <div class="form-group row">
                            {{ Form::label('delivered_by', 'Delivered by', array('class'=>'control-label col-md-2')) }}
                            {{ Form::text('delivered_by', '', array('class'=>'form-control col-md-10')) }}
                        </div>
                        <div class="form-group row">
                            {{ Form::label('status', 'Save as Draft?', array('class'=>'control-label col-md-2')) }}
                            {{ Form::checkbox('status',0) }}
                        </div>
                        <div class="form-group row">
                            {{ Form::label('amount', 'Total', array('class'=>'control-label col-md-2')) }}
                            {{ Form::text('amount', '', array('class'=>'form-control col-md-2 autofill total-amount text-center')) }}
                        </div>
                        <div class="form-group row">
                            <div class="col-md-2">Invoice items:</div>
                            <div id="invoice_items" class="col-md-10">
                                <div class="row d-none item-titles">
                                    <div class="col-md-6">Item name</div>
                                    <div class="col-md-2">Qty</div>
                                    <div class="col-md-2">Price</div>
                                    <div class="col-md-2">Subtotal</div>
                                </div>
                            </div>
                            <button id="add_item" class="btn btn-primary col-md-2 offset-md-2 mt-1">+ Add item</button>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-10">
                                {{ Form::submit('Save',array('class'=>'btn btn-success')) }}
                            </div>
                        </div>
                    {{ Form::close() }}                    
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('click','#add_item',function(e) {
        e.preventDefault();
        $('.item-titles').removeClass('d-none');
        $('#invoice_items').append(itemLine);
    });
    var calcSubtotal = node=>{
        let qty = (node.hasClass('item-qty')) ? node.val() : node.siblings('.item-qty').val();
        let price = (node.hasClass('item-price')) ? node.val() : node.siblings('.item-price').val();
        let multiplier = node.siblings('.item-multiplier').val();
        console.log(qty);
        console.log(price);
        console.log(multiplier);
        return parseFloat(qty) * parseFloat(multiplier) * parseFloat(price);
    }
    var calcTotal = ()=>{
        let sum = 0;
        $('.subtotal').each((i,e)=>{
            sum += parseFloat($(e).text());
        });
        return sum;
    }
    var itemLine = `<div class="row">
                        {{ Form::select('item[]', $item_options, '', array('class'=>'form-control col-md-6 select-item')) }}
                        {{ Form::text('qty[]', '', array('class'=>'form-control col-md-2 item-qty')) }}
                        {{ Form::text('price[]', '', array('class'=>'form-control col-md-2 item-price')) }}
                        {{ Form::hidden('multiplier', '', array('class'=>'form-control col-md-2 item-multiplier')) }}
                        <div class="subtotal col-md-2 text-right"></div>
                    </div>`;
    var items = {};
    <?php
        foreach( $items as $item ) {
            echo 'items['.$item->id.'] = {
                name: "'.$item->name.'",
                multiplier: '.$item->multiplier.',
                default_price: '.(($item->default_price) ?: '""').'
            };'.PHP_EOL;
        }
    ?>
    $(document).on('change','.select-item',function(){
        let price = items[$(this).val()].default_price;
        price = (price) ? price : 0;
        let multiplier = items[$(this).val()].multiplier;
        $(this).siblings('.item-qty').val(1);
        $(this).siblings('.item-price').val(price);
        $(this).siblings('.item-multiplier').val(multiplier);        
        $(this).siblings('.subtotal').text(calcSubtotal($(this)).toFixed(2));
        $('.total-amount').val(calcTotal().toFixed(2));
    });
    $(document).on('change','.item-qty',function(){
        $(this).siblings('.subtotal').text(calcSubtotal($(this)).toFixed(2));
        $('.total-amount').val(calcTotal().toFixed(2));
    });
    $(document).on('change','.item-price',function(){
        $(this).siblings('.subtotal').text(calcSubtotal($(this)).toFixed(2));
        $('.total-amount').val(calcTotal().toFixed(2));
    });
</script>
@endsection