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
                <div class="card-header">Expense invoices (<a href="{{ action('ExpenseInvoiceController@create') }}">Add</a>)</div>
                <div class="card-body">
                    @empty($invoices)
	                    No invoice.
                    @else
                    	<table id="invoices" class="table table-striped table-responsive">
                    		<thead>
                    			<tr>
                    				<th>Invoice #</th>
                    				<th>Company</th>
                    				<th>Date</th>
                    				<th>Amount</th>
                                    <th></th>
                    			</tr>
                    		</thead>
                    		<tbody>
                    			@foreach($invoices as $inv)
	                    			<tr>
	                    				<td>{{ $inv->invoice_no }}</td>
	                    				<td>{{ $inv->company_name }}</td>
	                    				<td>{{ Carbon\Carbon::parse($inv->invoice_date)->format('d-m-Y') }}</td>
	                    				<td>{{ number_format($inv->amount, 2, '.', ',') }}</td>
                                        <td>
                                           <button type="button" onClick="location.href='{{ action('ExpenseInvoiceController@edit',$inv->id) }}'" class="btn btn-warning mx-auto">Edit</button> | 
                                            {{ Form::open(['action' => ['ExpenseInvoiceController@destroy',$inv->id], 'class'=>'form-horizontal d-inline-block', 'method'=>'post']) }}
                                                {{ Form::hidden('_method', 'DELETE') }}
                                                {{ Form::submit('Delete', array('class' => 'btn btn-danger mx-auto')) }}
                                            {{ Form::close() }}
                                        </td>
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