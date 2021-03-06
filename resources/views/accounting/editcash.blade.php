@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Cash Balances</div>
                <div class="card-body">
                    {{ Form::open(['action' => ['CashBalanceController@update',$item->id], 'class'=>'form-horizontal', 'method'=>'post']) }}
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
                            {{ Form::label('date', 'Date', array('class'=>'control-label col-lg-4')) }}
                            {{ Form::date('date', Carbon\Carbon::parse($item->date)->format('Y-m-d'), array('class'=>'form-control col-lg-4')) }}
                        </div>
                        <div class="form-group row">
                            {{ Form::label('amount', 'Amount', array('class'=>'control-label col-lg-4')) }}
                            {{ Form::text('amount', $item->amount, array('class'=>'form-control col-lg-4 text-center')) }}
                        </div>
                        <div class="form-group row">
                            {{ Form::label('counted_by', 'Counted by', array('class'=>'control-label col-lg-4')) }}
                            {{ Form::text('counted_by', $item->counted_by, array('class'=>'form-control col-lg-4 text-center')) }}
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