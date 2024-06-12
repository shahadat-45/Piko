@extends('themart.theMartBlank')
@section('martContent')
<div class="container">
    <div class="row">
        <div class="col-lg-6 py-5 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Password Reset Form</h4>
                    {{-- @if (session('invalid'))
                    <div class="alert alert-danger" role="alert">{{ session('invalid') }}</div>
                    @elseif (session('success'))
                    <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                    @endif --}}
                    <form class="forms-sample" action="{{ route('pass.reset.update' , $token) }}" method="POST">                        
                        @csrf
                        <div class="form-group mb-3">
                            <label class="form-label" for="exampleInputEmail1">Password</label>
                            <input type="password" class="form-control mb-2" id="exampleInputEmail1" name="password" placeholder="Enter a Password">
                            @error('password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>                            
                        <div class="form-group mb-3">
                            <label class="form-label" for="exampleInputEmail1">Confirm Password</label>
                            <input type="password" class="form-control mb-2" id="exampleInputEmail1" name="password_confirmation" placeholder="Retype this Password">
                            @error('password_confirmation')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>                            
                        <button type="submit" class="btn btn-primary mr-2 mb-3">Send Request</button>
                    </form>
                </div>
            </div>
        </div>
    </div>    
</div>
@endsection