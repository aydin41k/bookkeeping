@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add an Expense Payment</div>
                <div class="card-body">
                    {{ Form::open(['action' => 'ExpensePaymentController@store', 'class'=>'form-horizontal', 'method'=>'post']) }}
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
                            {{ Form::label('company_id', 'Provider', array('class'=>'control-label col-sm-2')) }}
                            {{ Form::select('company_id', $coys, '', ['class'=>'form-control col-sm-10','autocomplete'=>'off']) }}
                        </div>
                        <div class="form-group row">
                            {{ Form::label('date', 'Payment date', array('class'=>'control-label col-sm-2')) }}
                            {{ Form::date('date', '', array('class'=>'form-control col-sm-3')) }}
                        </div>
                        <div class="form-group row">
                            {{ Form::label('amount', 'Amount', array('class'=>'control-label col-sm-2')) }}
                            {{ Form::text('amount', '', array('class'=>'form-control col-sm-10')) }}
                        </div>
                        <div class="form-group row">
                            {{ Form::label('payment_method', 'Payment Method', array('class'=>'control-label col-sm-2')) }}
                            {{ Form::select('payment_method', $pmt_methods, '', ['class'=>'form-control col-sm-10','autocomplete'=>'off']) }}
                        </div>
                        <div class="form-group row">
                            {{ Form::label('notes', 'Notes', array('class'=>'control-label col-sm-2')) }}
                            {{ Form::textarea('notes', '', array('class'=>'form-control col-sm-10')) }}
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                {{ Form::submit('Save',array('class'=>'btn btn-success')) }}
                            </div>
                        </div>
                    {{ Form::close() }}                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
