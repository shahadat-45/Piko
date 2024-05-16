@extends('themart.theMartBlank')
@php
    $bold = 1 ;
@endphp
@section('martContent')
    <div class="container py-5">
        <div class="row">
            @include('themart.order_side_bar')
            <div class="col-lg-9 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">My Orders</h4>
                        <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Order ID</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Created at</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($myorders as $index => $myorder)
                                        <tr>
                                            <th>{{ $index + 1 }}</th>
                                            <td>{{ $myorder->order_id }}</td>
                                            <td>${{ $myorder->total }}</td>
                                            <td>
                                                @if ($myorder->status == 1)
                                                <button type="button" class="btn btn-sm btn-light">Placed</button>
                                                @elseif ($myorder->status == 2)
                                                <button type="button" class="btn btn-sm btn-secondary">Processing</button>
                                                @elseif ($myorder->status == 3)
                                                <button type="button" class="btn btn-sm btn-primary">Shipping</button>
                                                @elseif ($myorder->status == 4)
                                                <button type="button" class="btn btn-sm btn-info">Ready to Delivery</button>
                                                @elseif ($myorder->status == 5)
                                                <button type="button" class="btn btn-sm btn-success">Delivered</button>
                                                @elseif ($myorder->status == 0)
                                                <button type="button" class="btn btn-sm btn-danger">Cancel</button>
                                                @endif
                                            </td>
                                            <td>{{ $myorder->created_at->format('d-M-Y') }}</td>
                                            <td><a href="{{ route('download.invoice', $myorder->id) }}"><button type="button" class="btn btn-success">Download Invoice</button></a></td>
                                        </tr>                                                      
                                        @endforeach
                                    </tbody>
                                </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
