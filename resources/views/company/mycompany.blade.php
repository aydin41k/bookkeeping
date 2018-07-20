@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">My Company (<a href="{{ action('CompanyController@edit',$mycompany->id) }}">Edit</a>)</div>
                <div class="card-body">
                    @empty($mycompany)
	                    No company specified.
                    @else
                    <div class="row">
	                    <div class="col-md-4">ABN:</div>
	                    <div class="col-md-8">{{ $mycompany->abn }}</div>
	                </div>
                    <div class="row">
	                    <div class="col-md-4">Name:</div>
	                    <div class="col-md-8">{{ ($mycompany->name) ?: '' }}</div>
	                </div>
                    <div class="row">
	                    <div class="col-md-4">Address:</div>
	                    <div class="col-md-8">{{ ($mycompany->address) ?: '' }}</div>
	                </div>
                    <div class="row">
	                    <div class="col-md-4">Contact person:</div>
	                    <div class="col-md-8">{{ ($mycompany->contact_person) ?: '' }}</div>
	                </div>
                    <div class="row">
	                    <div class="col-md-4">Phone:</div>
	                    <div class="col-md-8">{{ ($mycompany->phone) ?: '' }}</div>
	                </div>
                    <div class="row">
	                    <div class="col-md-4">Email:</div>
	                    <div class="col-md-8">{{ ($mycompany->email) ?: '' }}</div>
	                </div>
	                @endempty
                </div>
            </div>        	
    	</div>
    </div>
</div>
@endsection
