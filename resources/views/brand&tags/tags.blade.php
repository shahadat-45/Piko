@extends('blank')

@section('content')

<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tags</li>
    </ol>
</nav>

<div class="row">    
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">          
                <div class="card-body">
                    <h6 class="card-title">Tag list</h6>
                    @if (session('delete_success'))
                    <div class="alert alert-success" role="alert">{{ session('delete_success') }}</div>
                    @endif
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>                                        
                                        <th>Tags</th>
                                        <th>Created_Time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $tags as $key=> $tag )
                                    <tr>
                                        <td>{{ $tag->tag_name }}</td>
                                        <td>{{ $tag->created_at->DiffForHumans() }}</td>
                                        <td><a href="{{ route('tag.delete', $tag->id) }}"><button type="button" class="btn btn-danger btn-icon">
                                            <i data-feather="trash"></i>
                                        </button></a></td>
                                    </tr>               
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="my-2">
                                {{ $tags->links() }}
                            </div>
                            @if ($tags->isEmpty())
                            <p class="m-auto position-absolute new-text-center">tag list is empty</p>                                
                            @endif
                        </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card" style="max-height: 300px;">
            <div class="card-body">
                <h6 class="card-title">Create Tags</h6>
                @if (session('success'))
                <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                @endif
                <form class="forms-sample" action="{{ route('insert.tag') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-1">
                        <label class="mt-2" for="name">Tag Name</label>
                        <input type="text" class="form-control" name="tags" placeholder="example">
                    </div>
                    @error('tags')
                    <strong class="text-danger mb-2">{{ $message }}</strong>
                    @enderror                                                         
                    <button type="submit" class="btn btn-primary mr-2 mt-2">Insert</button>
                </form>
            </div>
        </div>
    </div>
</div>    
@endsection