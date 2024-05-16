@extends('themart.theMartBlank')
@php
    $bold = 0 ;
@endphp
@section('martContent')
    <div class="container py-5">
        <div class="row">
            @include('themart.order_side_bar')
            <div class="col-lg-9 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Profile</h5>
                        <p class="card-description">Edit & update your <a href="#" > profile</a> information.</p>
                        <form class="forms-sample text-dark" action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <div class="col mb-3">
                                    <label class="form-label">Name:</label>
                                    <input class="form-control mb-4 mb-md-0" type="text" name="name" value="{{ Auth::guard('customer')->user()->name }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email:</label>
                                    <input class="form-control" type="email" name="email" value="{{ Auth::guard('customer')->user()->email }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Password:</label>
                                    <input class="form-control mb-4 mb-md-0" type="password" name="password">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input class="form-control" type="password" name="password_confirmation">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Country:</label>
                                    <input class="form-control mb-4 mb-md-0" type="text" name="country" value="{{ Auth::guard('customer')->user()->country }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">City:</label>
                                    <input class="form-control" type="text" name="city" value="{{ Auth::guard('customer')->user()->city }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Address:</label>
                                    <input class="form-control mb-4 mb-md-0" type="text" name="address" value="{{ Auth::guard('customer')->user()->address }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Zip code:</label>
                                    <input class="form-control" type="number" name="zip" value="{{ Auth::guard('customer')->user()->zip }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Photo:</label>
                                    <input class="form-control mb-4 mb-md-0" type="file" name="photo">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 mb-2">
                                    <button type="submit" class="btn btn-success">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection