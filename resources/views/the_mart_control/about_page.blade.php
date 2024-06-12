@extends('blank')
@section('content')
<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Update About Information</h6>
                @if (session('success'))
                <div class="alert alert-success" role="alert">{{ session('success') }}</div>                
                @endif
                <form class="forms-sample" method="POST" action="{{ route('about.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputTitle1">Title</label>
                        <input type="text" name="title" class="form-control" id="exampleInputTitle1" value="{{ $data->title }}">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" id="description" cols="30" rows="7">{{ $data->description }}</textarea>
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
</div>    
@endsection