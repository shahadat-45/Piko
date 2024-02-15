@extends('blank')

@section('content')

<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Brand</li>
    </ol>
</nav>

<div class="row">    
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">          
                <div class="card-body">
                    <h6 class="card-title">Brand list</h6>
                    @if (session('delete_success'))
                    <div class="alert alert-success" role="alert">{{ session('delete_success') }}</div>
                    @endif
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>                                       
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Created_Time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $brands as $key=> $brand )
                                    <tr>
                                        <td><img src="{{ asset('uploads/brand') }}/{{ $brand->image }}" width="50" style="border-radius: 50%"></td>
                                        <td>{{ $brand->name }}</td>
                                        <td>{{ $brand->created_at->DiffForHumans() }}</td>
                                        <td><button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#showData{{ $brand->id }}">View</button></td>
                                    </tr>
                                        {{-- Modal for showing details --}}
                                        <div class="modal fade" id="showData{{ $brand->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{ $brand->name }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="card flex-row">                                                        
                                                        <div class="">
                                                            <img src="{{ asset('uploads/brand') }}/{{ $brand->image }}" class="card-img-top" style="width: 120px; height:100%">
                                                        </div>
                                                        <div class="card-body">
                                                            
                                                            <p>{{ $brand->slug }}</p>
                                                           
                                                        <p class="card-text"><small class="text-muted">Last updated {{ $brand->updated_at === NULL ? 'none' : $brand->updated_at->DiffForHumans() }}</small></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                <a href="{{ route('delete.brand',$brand->id) }}"><button type="button" class="btn btn-danger">Delete</button></a>
                                                </div>
                                            </div>
                                            </div>
                                        </div>                                        
                                        {{-- Modal for showing details end --}}                
                                    @endforeach
                                </tbody>
                            </table>
                            @if ($brands->isEmpty())
                            <p class="m-auto position-absolute new-text-center">brand filed is empty</p>                                
                            @endif
                        </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card" style="max-height: 300px;">
            <div class="card-body">
                <h6 class="card-title">Create Brand</h6>
                @if (session('success'))
                <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                @endif
                <form class="forms-sample" action="{{ route('insert.brand') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-1">
                        <label class="mt-2" for="name">Brand Name</label>
                        <input type="text" class="form-control" name="name" placeholder="name">
                    </div>
                    @error('name')
                    <strong class="text-danger mb-2">{{ $message }}</strong>
                    @enderror                   
                   <div class="form-group mb-0">
                        <label>Brand Image</label>
                        <input type="file" name="image" class="form-control mb-2" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                        <img id="blah" width="100"/>
                        <br>
                    @error('image')
                    <strong class="text-danger mb-2">{{ $message }}</strong>
                    @enderror
                    </div>                    
                    <button type="submit" class="btn btn-primary mr-2 mt-2">Insert</button>
                </form>
            </div>
        </div>
    </div>
</div>    
@endsection