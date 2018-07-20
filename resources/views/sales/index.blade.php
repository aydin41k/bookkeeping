@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('status'))
        <div class="alert alert-success text-center">
            {{ session('status') }}
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Sales invoices (<a href="{{ action('SalesInvoiceController@create') }}">Add</a>)</div>
                <div class="card-body">
                    @empty($invoices)
	                    No invoice.
                    @else
                    	<table id="invoices" class="table table-striped table-responsive">
                    		<thead>
                    			<tr>
                    				<th>ID</th>
                    				<th>Company</a></th>
                    				<th>Date</th>
                    				<th>Amount</th>
                    				<th>Delivery date</th>
                    				<th>Delivered by</th>
                    				<th>Status</th>
                    			</tr>
                    		</thead>
                    		<tbody>
                    			@foreach($invoices as $inv)
	                    			<tr>
	                    				<td>{{ $inv->id }}</td>
	                    				<td><a href="{{ action('SalesInvoiceController@show',$inv->id) }}">{{ $inv->company_name }}</a></td>
	                    				<td>{{ Carbon\Carbon::parse($inv->invoice_date)->format('d-m-Y') }}</td>
	                    				<td>{{ number_format($inv->amount, 2, '.', ',') }}</td>
	                    				<td>{{ Carbon\Carbon::parse($inv->delivery_date)->format('d-m-Y') }}</td>
	                    				<td>{{ $inv->delivered_by }}</td>
	                    				<td class="{{ strtolower($inv->status) }}">{{ $inv->status }}</td>
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