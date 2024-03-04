@extends('blank')
@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
                <h6 class="card-title">Banner Table</h6>
                <p class="card-description">List of <code>.banner</code> slider</p>
                @if (session('success'))
                    <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                @elseif (session('delete'))   
                    <div class="alert alert-success" role="alert">{{ session('delete') }}</div> 
                @endif
                <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Title</th>
                                    <th>Link</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($banners as $index => $banner)
                                <tr>
                                    <th>{{ $index + 1 }}</th>
                                    <td>{{ $banner->title }}</td>
                                    <td>{{ $banner->link }}</td>
                                    <td><a href="{{ route('banner.status', $banner->id) }}"><span class="badge {{ $banner->status == 0 ? 'badge-secondary' : 'badge-success' }}  ">{{ $banner->status == 0 ? 'Deactive' : 'Active' }}</span></a></td>
                                    <td><img src="{{ asset('uploads') }}/theMart/banner/{{ $banner->image }}" alt="{{ $banner->image }}" width="200px"></td>
                                    <td><a href="{{ route('banner.delete', $banner->id) }}"><button type="button" class="btn btn-danger btn-icon">
                                        <i data-feather="trash"></i>
                                    </button></a></td>
                                </tr> 

                                @endforeach
                            </tbody>
                        </table>
                </div>
          </div>
        </div>
    </div>
    <div class="col-md-4 ml-auto grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Add Banner </h6>
                <form class="forms-sample" method="POST" enctype="multipart/form-data" action="{{ route('add.banner.slider') }}">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputUsername1">Image</label>
                        <input type="file" class="form-control mb-1" name="image" id="exampleInputUsername1" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])" onclick="document.getElementById('blah').classList.replace('d-none', 'd-block')">
                        <img class="mt-2 d-none" height="184px" id="blah">
                        @error('image')                            
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                        </div>
                        <div class="form-group">
                        <label for="exampleInputEmail1">Title</label>
                        <input type="text" class="form-control mb-1" name="title" id="exampleInputEmail1" placeholder="Entre a title">
                        @error('title')                            
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Link</label>
                        <input type="text" class="form-control" name="link" id="exampleInputPassword1" placeholder="Enter redirection link">
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection