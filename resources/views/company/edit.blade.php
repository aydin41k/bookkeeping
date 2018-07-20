@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit company details</div>
                <div class="card-body">
                    {{ Form::open(array('action' => ['CompanyController@update',$company->id], 'class'=>'form-horizontal', 'method'=>'post')) }}
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
                            {{ Form::text('abn', $company->abn, array('class'=>'form-control col-sm-10')) }}
                        </div>
                        <div class="form-group row">
                            {{ Form::label('name', 'Name', array('class'=>'control-label col-sm-2')) }}
                            {{ Form::text('name', $company->name, array('class'=>'form-control col-sm-10')) }}
                        </div>
                        <div class="form-group row">
                            {{ Form::label('address', 'Address', array('class'=>'control-label col-sm-2')) }}
                            {{ Form::textarea('address', $company->address, array('class'=>'form-control col-sm-10')) }}
                        </div>
                        <div class="form-group row">
                            {{ Form::label('contact_person', 'Contact person', array('class'=>'control-label col-sm-2')) }}
                            {{ Form::text('contact_person', $company->contact_person, array('class'=>'form-control col-sm-10')) }}
                        </div>
                        <div class="form-group row">
                            {{ Form::label('phone', 'Phone', array('class'=>'control-label col-sm-2')) }}
                            {{ Form::text('phone', $company->phone, array('class'=>'form-control col-sm-10')) }}
                        </div>
                        <div class="form-group row">
                            {{ Form::label('email', 'Email', array('class'=>'control-label col-sm-2')) }}
                            {{ Form::text('email', $company->email, array('class'=>'form-control col-sm-10')) }}
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                {{ Form::submit('Save',array('class'=>'btn btn-success')) }}
                            </div>
                        </div>
                        {{ Form::hidden('_method', 'PUT') }}                        
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    CKEDITOR.replace( 'description' );
    CKEDITOR.replace( 'social_activities' );
</script>
@endsection
