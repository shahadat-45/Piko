@extends('blank')
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Category Page</li>
    </ol>
</nav>

<div class="row">    
    <div class="col-md-8 mx-auto grid-margin stretch-card">
        <div class="card">
            <form action="{{ route('trashed.category.checked.delete') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h6 class="card-title">Categories list</h6>
                        <button class="btn btn-danger btn-sm" style="height: fit-content" type="submit">Delete All</button>
                    </div>
                    @if (session('trash_deleted_permanently'))
                    <div class="alert alert-success" role="alert">{{ session('trash_deleted_permanently') }}</div>
                    @elseif (session('trash_restored'))
                    <div class="alert alert-success" role="alert">{{ session('trash_restored') }}</div>
                    @endif
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="d-flex" style="gap: 8px"> 
                                            <input onclick="toggle(this);" type="checkbox" value="" aria-label="Checkbox for following text input">
                                            <label class="form-label mb-0">Check All</label>
                                        </th>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        {{-- <th>Description</th> --}}
                                        <th>Deleted_Time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $categories as $key=> $category )
                                    <tr>
                                        <td class="mx-auto">
                                            <input name="foo[]" type="checkbox" value="{{ $category->id }}" aria-label="Checkbox for following text input">
                                        </td>
                                        <td><img src="{{ asset('uploads/category') }}/{{ $category->image }}" width="50" style="border-radius: 50%"></td>
                                        <td>{{ $category->name }}</td>
                                        {{-- <td>{{ $category->description }}</td> --}}
                                        <td>{{ $category->deleted_at->DiffForHumans() }}</td>
                                        <td><a href="{{ route('trash.category.restore', $category->id) }}"><button title="Restore" type="button" class="btn btn-success btn-icon">
                                            <i class="mdi mdi-replay"></i>
                                        </button></a>
                                        <a href="{{ route('trash.delete', $category->id) }}"><button title="Delete Permanently" type="button" class="btn btn-danger btn-icon">
                                            <i data-feather="trash"></i>
                                        </button></a></td>                                        
                                    </tr>                
                                    @endforeach
                                </tbody>
                            </table>                           
                        </div>
                </div>
            </form>
        </div>
    </div>
</div> 
@endsection
@section('footer-script')
    <script>
        function toggle(source) {
            checkboxes = document.getElementsByName('foo[]');
            for(var i=0, n=checkboxes.length;i<n;i++) {
                checkboxes[i].checked = source.checked;
            }
        }
    </script>
@endsection