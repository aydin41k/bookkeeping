@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Payments to Suppliers (<a href="{{ action('PurchasePaymentController@create') }}">Add</a>)</div>
                <div class="card-body">
                    @empty($payments)
	                    No payment recorded.
                    @else
                    	<table id="payments" class="table table-striped table-responsive">
                    		<thead>
                    			<tr>
                    				<th>ID</th>
                    				<th>Company</th>
                    				<th>Date</th>
                    				<th>Amount</th>
                    				<th>Payment method</th>
                    				<th>Notes</th>
                                    <th></th>
                    			</tr>
                    		</thead>
                    		<tbody>
                    			@foreach($payments as $pmt)
	                    			<tr>
	                    				<td>{{ $pmt->id }}</td>
	                    				<td>{{ $pmt->company_name }}</td>
	                    				<td>{{ Carbon\Carbon::parse($pmt->date)->format('d-m-Y') }}</td>
	                    				<td>{{ number_format($pmt->amount, 2, ',', '.') }}</td>
                                        <td>{{ $pmt->payment_method }}</td>
                                        <td>{{ $pmt->notes }}</td>
                                        <td>
                                            <button type="button" onClick="location.href='{{ action('PurchasePaymentController@edit',$pmt->id) }}'" class="btn btn-warning mx-auto">Edit</button> 
                                            {{ Form::open(['action' => ['PurchasePaymentController@destroy',$pmt->id], 'class'=>'form-horizontal d-inline-block', 'method'=>'post']) }}
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