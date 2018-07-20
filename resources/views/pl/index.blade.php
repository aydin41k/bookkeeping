@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            {{ Form::open(['action' => 'PLController@show', 'class'=>'form-horizontal', 'method'=>'post']) }}
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
                    {{ Form::date('from', '', array('class'=>'form-control col-md-3')) }}
                </div>
                <div class="form-group row">
                    {{ Form::label('to', 'To', array('class'=>'control-label col-md-2')) }}
                    {{ Form::date('to', '', array('class'=>'form-control col-md-3')) }}
                </div>
                <div class="form-group row">
                    <div class="col-md-10">
                        {{ Form::submit('Show',array('class'=>'btn btn-success')) }}
                    </div>
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection