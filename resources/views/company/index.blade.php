@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Customers and Suppliers (<a href="{{ action('CompanyController@create') }}">Add new</a>)</div>
                <div class="card-body">
                    @empty($companies)
	                    No companies added.
                    @else
                    <table id="companies" class="table table-striped">
                    	<thead>
                    		<tr>
                    			<th>Name</th>
                    			<th>ABN</th>
                    			<th>Contact Person</th>
                    			<th>Phone</th>
                			</tr>
                		</thead>
                		<tbody>
                			@foreach( $companies as $co )
	                    		<tr>
	                    			<td>{{ $co->name }}</td>
	                    			<td>{{ $co->abn }}</td>
	                    			<td>{{ $co->contact_person }}</td>
	                    			<td>{{ $co->phone }}</td>
	                			</tr>
                			@endforeach
                		</tbody>
                    </table>
                    @endempty
                </div>
            </div>        	
    	</div>
    </div>
</div>
@endsection
