@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add an Item</div>
                <div class="card-body">
                    {{ Form::open(['action' => 'PurchaseItemController@store', 'class'=>'form-horizontal', 'method'=>'post']) }}
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
                            {{ Form::label('name', 'Item name', array('class'=>'control-label col-sm-2')) }}
                            {{ Form::text('name', '', array('class'=>'form-control col-sm-10')) }}
                        </div>
                        <div class="form-group row">
                            {{ Form::label('default_price', 'Default price', array('class'=>'control-label col-sm-2')) }}
                            {{ Form::text('default_price', '', array('class'=>'form-control col-sm-2')) }}
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
