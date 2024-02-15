@extends('blank')


@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="row">
            @foreach ($category as $categories)
            <div class="col-lg-6 my-2">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ $categories->name }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Sub-Category</th>                                
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (App\Models\SubCategory::where('category_id', $categories->id)->get() as $key => $subcategories)
                                    <tr>
                                        <th>{{ $key + 1 }}</th>
                                        <td>{{ $subcategories->sub_category_name }}</td>
                                        <td class="d-flex" style="gap: 4px"><a href="{{ route('sub_category.delete',$subcategories->id) }}"><button type="button" class="btn btn-danger btn-sm btn-icon">
                                            <i data-feather="trash"></i>
                                        </button></a><button type="button" class="btn btn-primary btn-icon btn-sm" data-toggle="modal" data-target="#showData{{ $subcategories->id }}">
                                            <i data-feather="check-square"></i>
                                        </button></td>
                                    </tr>
                                    <div class="modal fade" id="showData{{ $subcategories->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">{{ $categories->name }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <form action="{{ route('sub_category.update',$subcategories->id) }}" method="POST">
                                                @csrf
                                            <div class="modal-body">
                                                <div class="card">                                                    
                                                    <div class="card-body">                                                                        
                                                        <div class="mb-3">
                                                            <label for="sub_category_name" class="form-label">Sub-Category Name</label>
                                                            <input type="text" class="form-control" name="sub_category_name" id="sub_category_name" value="{{ $subcategories->sub_category_name }}">
                                                            @error('sub_category_name')
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                            @enderror
                                                        </div>
                                                        <p class="card-text"><small class="text-muted">Last updated {{ $subcategories->updated_at === NULL ? '---' : $subcategories->updated_at->DiffForHumans() }}</small></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Update</button>
                                            </div>
                                            </form>
                                        </div>
                                        </div>
                                    </div>
                                    @endforeach
                                                          
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            
        </div>            
    </div>    
    <div class="col-lg-4 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4>Add New Sub-Categories</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('sub_category.insert') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <select name="category_name" class="form-select" aria-label="Default select example">
                            <option selected hidden disabled>Select Category First</option>
                            @foreach ($category as $categories)
                            <option value="{{ $categories->id }}">{{ $categories->name }}</option>                            
                            @endforeach
                        </select>
                        @error('category_name')
                        <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>                 
                    <div class="mb-3">
                        <label for="sub_category_name" class="form-label">Sub-Category Name</label>
                        <input type="text" class="form-control" name="sub_category_name" id="sub_category_name" placeholder="example">
                        @error('sub_category_name')
                        <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>                 
                    <div class="mb-3">
                        <button type="submit" class="btn btn-info">Insert</button>
                    </div>                 
                </form>
            </div>
        </div>            
</div>    
@endsection