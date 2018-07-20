@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <table class="table table-responsive table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Counted by</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if( $cash_balance_list )
                        @foreach($cash_balance_list as $key=>$s)
                            <tr>
                                <td>{{ Carbon\Carbon::parse($s->date)->format('d.m.Y') }}</td>
                                <td>{{ $s->amount }}</td>
                                <td>{{ $s->counted_by }}</td>
                                <td><button type="button" onClick="location.href='{{ action('CashBalanceController@edit',$s->id) }}'" class="btn btn-warning mx-auto">Edit</button></td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection