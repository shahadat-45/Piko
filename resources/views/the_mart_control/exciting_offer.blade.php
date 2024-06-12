@extends('blank')
@section('content')
<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Update Exciting Offer</h6>
                @if (session('success'))
                <div class="alert alert-success" role="alert">{{ session('success') }}</div>                
                @endif
                <form class="forms-sample" method="POST" action="{{ route('exciting.offer.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputTitle1">Title</label>
                        <input type="text" name="title" class="form-control" id="exampleInputTitle1" value="{{ $data->title }}">
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="text" name="price" class="form-control" id="price" value="{{ $data->price }}">
                    </div>
                    <div class="form-group">
                        <label for="dis_price">Discount Price</label>
                        <input type="text" name="dis_price" class="form-control" id="dis_price" value="{{ $data->dis_price }}">
                    </div>
                    <div class="form-group">
                        <label for="time">Time</label>
                        <input type="date" name="time" class="form-control" id="time" value="{{ $data->time }}">
                    </div>
                    <div class="form-group">
                        <label for="link">Product Link</label>
                        <input type="text" name="link" class="form-control" id="link" value="{{ $data->product_link }}">
                    </div>
                    <div class="form-group">
                        <label for="photo">Photo</label>
                        <input type="file" name="photo" class="form-control mb-2" id="photo" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                        <img id="blah" src="{{ asset('uploads') }}/theMart/{{ $data->photo }}" height="100" />
                    </div>
                    <button type="submit" class="btn btn-success mr-2">Update</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Update Exciting Offer</h6>
                @if (session('success2'))
                <div class="alert alert-success" role="alert">{{ session('success2') }}</div>                
                @endif
                <form class="forms-sample" method="POST" action="{{ route('exciting.offer2.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputTitle1">Title</label>
                        <input type="text" name="title" class="form-control" id="exampleInputTitle1" value="{{ $data2->title }}">
                    </div>
                    <div class="form-group">
                        <label for="sub_title">Sub Title</label>
                        <input type="text" name="sub_title" class="form-control" id="sub_title" value="{{ $data2->sub_title }}">
                    </div>                    
                    <div class="form-group">
                        <label for="link">Product Link</label>
                        <input type="text" name="link" class="form-control" id="link" value="{{ $data2->product_link }}">
                    </div>
                    <div class="form-group">
                        <label for="photo">Photo</label>
                        <input type="file" name="photo" class="form-control mb-2" id="photo" onchange="document.getElementById('blah2').src = window.URL.createObjectURL(this.files[0])">
                        <img id="blah2" src="{{ asset('uploads') }}/theMart/{{ $data2->photo }}" height="100" />
                    </div>
                    <button type="submit" class="btn btn-success mr-2">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection