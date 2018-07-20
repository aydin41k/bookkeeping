@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add business details</div>
                <div class="card-body">
                    {{ Form::open(array('action' => 'CompanyController@store', 'class'=>'form-horizontal', 'method'=>'post')) }}
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
                            {{ Form::label('abn', 'ABN', array('class'=>'control-label col-sm-2')) }}
                            {{ Form::text('abn', '', array('class'=>'form-control col-sm-10')) }}
                        </div>
                        <div class="form-group row">
                            {{ Form::label('name', 'Business or Trading name', array('class'=>'control-label col-sm-2')) }}
                            {{ Form::text('name', '', array('class'=>'form-control col-sm-10')) }}
                        </div>
                        <div class="form-group row">
                            {{ Form::label('address', 'Address', array('class'=>'control-label col-sm-2')) }}
                            {{ Form::textarea('address', '', array('class'=>'form-control col-sm-10')) }}
                        </div>
                        <div class="form-group row">
                            {{ Form::label('phone', 'Phone', array('class'=>'control-label col-sm-2')) }}
                            {{ Form::text('phone', '', array('class'=>'form-control col-sm-10')) }}
                        </div>
                        <div class="form-group row">
                            {{ Form::label('email', 'Email', array('class'=>'control-label col-sm-2')) }}
                            {{ Form::text('email', '', array('class'=>'form-control col-sm-10')) }}
                        </div>
                        <div class="form-group row">
                            {{ Form::label('contact_person', 'Contact Person', array('class'=>'control-label col-sm-2')) }}
                            {{ Form::text('contact_person', '', array('class'=>'form-control col-sm-10')) }}
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
