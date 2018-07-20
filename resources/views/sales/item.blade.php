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
                <div class="card-header">Items (<a href="{{ action('SalesItemController@create') }}">Add</a>)</div>
                <div class="card-body">
                    @empty($items)
	                    No payment recorded.
                    @else
                    	<table id="payments" class="table table-striped table-responsive">
                    		<thead>
                    			<tr>
                    				<th>ID</th>
                    				<th>Item name</th>
                                    <th>Multiplier</th>
                    				<th>Default price</th>
                                    <th></th>
                    			</tr>
                    		</thead>
                    		<tbody>
                    			@foreach($items as $item)
	                    			<tr>
	                    				<td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->multiplier }}</td>
                                        <td>{{ $item->default_price }}</td>
                                        <td>
                                            <button type="button" onClick="location.href='{{ action('SalesItemController@edit',$item->id) }}'" class="btn btn-warning mx-auto">Edit</button> 
                                            @if( $user_id == 1 )
                                            {{ Form::open(['action' => ['SalesItemController@destroy',$item->id], 'class'=>'form-horizontal d-inline-block', 'method'=>'post']) }}
                                                {{ Form::hidden('_method', 'DELETE') }}
                                                {{ Form::submit('Delete', array('class' => 'btn btn-danger mx-auto')) }}
                                            {{ Form::close() }}
                                            @endif
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