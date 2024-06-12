@extends('themart.theMartBlank')
@section('martContent')
<div class="container">
    <div class="row">
        <div class="col-lg-6 py-5 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Password Reset Request</h4>
                    @if (session('invalid'))
                    <div class="alert alert-danger" role="alert">{{ session('invalid') }}</div>
                    @elseif (session('success'))
                    <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                    @endif
                    <form class="forms-sample" action="{{ route('pass.reset.req.send') }}" method="POST">                        
                        @csrf
                        <div class="form-group mb-3">
                            <label class="form-label" for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control mb-3" id="exampleInputEmail1" name="email" placeholder="Type Your Email">
                        </div>                            
                        <button type="submit" class="btn btn-primary mr-2 mb-3">Send Request</button>
                    </form>
                </div>
            </div>
        </div>
    </div>    
</div>
@endsection