@extends('blank')
@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">Coupons list</h6>
            @if (session('cpn_dlt'))
                <div class="alert alert-danger">{{ session('cpn_dlt') }}</div>
            @endif
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Coupon Name</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Number of uses</th>
                            <th>Validity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>                        
                        @foreach ($coupons as $index => $coupon)
                        <tr>
                            <th>{{ $index + 1 }}</th>
                            <td>{{ $coupon->coupon_name }}</td>
                            <td>{{ $coupon->coupon_type == 1 ? 'Solid' : 'Percentage' }}</td>
                            <td>{{ $coupon->amount }} {{ $coupon->coupon_type == 1 ? '৳' : '%' }}</td>
                            <td class="text-center">{{ $coupon->count == null ? '0' : $coupon->count }}</td>
                            <td>
                                @if (carbon\Carbon::now() < $coupon->validity)
                                <button type="button" class="btn btn-success btn-sm">
                                    {{ carbon\Carbon::now()->diffInDays($coupon->validity) }} days remaining
                                </button>                                    
                                @else
                                <button type="button" class="btn btn-warning btn-sm">
                                   Expired {{ carbon\Carbon::now()->diffInDays($coupon->validity) }}  days ago
                                </button>
                                @endif                                
                            </td>
                            <td>
                                <a href="{{ route('delete.coupon' , $coupon->id) }}">
                                    <button type="button" class="btn btn-danger btn-icon">
                                        <i data-feather="trash"></i>
                                    </button>
                                </a>
                            </td>
                        </tr>                            
                        @endforeach
                    </tbody>
                </table>
            </div>
          </div>
        </div>
    </div>
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Create Coupons</h6>
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form class="forms-sample" method="POST" action="{{ route('coupon.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Coupon name</label>
                        <input type="text" class="form-control" id="name" autocomplete="off" placeholder="Coupon name .. " name="coupon_name">
                    </div>
                    <div class="form-group">
                        <label>Coupon type</label>
                        <select class="form-control form-control-sm mb-3" name="coupon_type">
                            <option selected disabled>Select coupon types</option>
                            <option value="1">Solid</option>
                            <option value="2">Percentage</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" class="form-control" id="amount" autocomplete="off" placeholder="Amount" name="amount">
                    </div>
                    <div class="form-group">
                        <label for="validity">Validity</label>
                        <input type="date" class="form-control" id="validity" name="validity">
                    </div>
                    <button type="submit" class="btn btn-success mr-2">Insert</button>
                </form>
            </div>
        </div>
    </div>    
</div>
@endsection