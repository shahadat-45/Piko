@extends('blank')
@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Customer Orders</h6>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Order ID</th>
                                <th>Total</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $sl => $order)
                            <tr>
                                <th>{{ $sl + 1 }}</th>
                                <td>{{ $order->order_id }}</td>
                                <td>${{ $order->total }}</td>
                                <td>{{ $order->created_at->diffForHumans() }}</td>
                                <td>
                                    @if ($order->status == 1)
                                        <button type="button" style="padding: 0.4rem 1rem 0.3rem" class="btn btn-sm btn-light">Placed</button>
                                        @elseif ($order->status == 2)
                                        <button type="button" style="padding: 0.4rem 1rem 0.3rem" class="btn btn-sm btn-secondary">Processing</button>
                                        @elseif ($order->status == 3)
                                        <button type="button" style="padding: 0.4rem 1rem 0.3rem" class="btn btn-sm btn-primary">Shipping</button>
                                        @elseif ($order->status == 4)
                                        <button type="button" style="padding: 0.4rem 1rem 0.3rem" class="btn btn-sm btn-info">Ready to Delivery</button>
                                        @elseif ($order->status == 5)
                                        <button type="button" style="padding: 0.4rem 1rem 0.3rem" class="btn btn-sm btn-success">Delivered</button>
                                        @elseif ($order->status == 0)
                                        <button type="button" style="padding: 0.4rem 1rem 0.3rem" class="btn btn-sm btn-danger">Cancel</button>
                                    @endif
                                </td>
                                <td>
                                <form action="{{ route('order.change.status' , $order->id) }}" method="POST">
                                    @csrf
                                    <div class="btn-group">
                                        <button class="btn btn-light btn-sm" type="button">
                                          Change Status
                                        </button>
                                        <button type="button" class="btn btn-sm btn-light dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-expanded="false">
                                          <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu">
                                            <button name="status" value="0" class="dropdown-item" type="submit">Cancel</button>
                                            <button name="status" value="1" class="dropdown-item" type="submit">Placed</button>
                                            <button name="status" value="3" class="dropdown-item" type="submit">Shipping</button>
                                            <button name="status" value="5" class="dropdown-item" type="submit">Delivered</button>
                                            <button name="status" value="2" class="dropdown-item" type="submit">Processing</button>
                                            <button name="status" value="4" class="dropdown-item" type="submit">Ready to Delivery</button>
                                        </div>
                                    </div>
                                </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection