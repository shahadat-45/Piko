@extends('blank')
@section('header_links')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-capitalize">Inputs your product information</h6>
                @if (session('product_added'))
                    <div class="alert alert-success">{{ session('product_added') }}</div>
                @endif
                <form action="{{ route('product.insert') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="category">Select Category</label>
                                <select class="form-control category" id="category" name="category">
                                    <option selected="" disabled="">Select Category</option>
                                    @foreach ($categories as $category)                                        
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="subcategory">Select SubCategory</label>
                                <select class="form-control" id="subcats" name="subcategory">
                                    <option selected="" disabled="">Select Sub-Category</option>                                   
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="brand">Select Brand</label>
                                <select class="form-control" id="brand" name="brand">
                                    <option selected="" disabled="">Select Brand</option>
                                    @foreach ($brands as $brand)                                        
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="product_name">Product Name</label>
                        <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Product Name">
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="price">Price </label>
                                <input type="number" class="form-control" id="price" name="price" placeholder="Price">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="discount">Discount </label>
                                <input type="number" class="form-control" id="discount" name="discount" placeholder="Discount">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <fieldset disabled>
                                <div class="form-group">
                                    <label for="product">Product Type</label>
                                    <input type="disable" class="form-control" id="product" name="product_type" placeholder="Disabled input">
                                </div>
                            </fieldset>
                        </div>
                    </div>                    
                    <div class="form-group">
                        <label for="short_desp">Short Description</label>
                        <input type="text" class="form-control" id="short_desp" name="short_desp" placeholder="Product Description">
                    </div>
                    <div class="form-group">
                        <label for="long_desp">Long Description</label>
                        <textarea id="summernote2" class="form-control" name="long_desp" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="additional_info">Additional Information</label>
                        <textarea id="summernote" class="form-control" name="additional_info" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="tags">Select Tags</label>
                        <select id="select-gear" name="tags[]" class="demo-default" multiple placeholder="Select Tags...">
                            <optgroup>
                                @foreach ($tags as $tag)                                    
                                <option value="{{ $tag->id }}">{{ $tag->tag_name }}</option>
                                @endforeach
                            </optgroup>
                          </select>                                  
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Thumbnail</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Gallery</label>
                                <input type="file" name="gallery[]" class="form-control" multiple>
                            </div>                            
                        </div>
                    </div>                    
                    <button class="btn btn-success" type="submit">Add Product</button>
                </form>     
            </div>
        </div>
    </div>
    {{-- <div class="col-lg-6">
        <div class="container mt-5">
            <div class="card">
              <div class="card-body">
                <div id="drop-area" class="border rounded d-flex justify-content-center align-items-center"
                  style="height: 200px; cursor: pointer">
                  <div class="text-center">
                    <i class="bi bi-cloud-arrow-up-fill text-primary" style="font-size: 48px"></i>
                    <p class="mt-3">
                      Drag and drop your image here or click to select a file.
                    </p>
                  </div>
                </div>
                <input type="file" id="fileElem" multiple accept="image/*" class="d-none" />
                <div id="gallery" style="position: absolute; height: 70px; top: 0px; transform: translateY(42%);"></div>
              </div>
            </div>
          </div>
    </div> --}}
</div>    
@endsection
@section('footer-script')
<script>
$('#select-gear').selectize({ sortField: 'text' });
$(document).ready(function() {
  $('#summernote').summernote();
  $('#summernote2').summernote();
});
</script>
<script>    

    $('.category').change(function() {
        let category_id = $(this).val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: '/products/getsubcategory',
        data: {'category_id' : category_id},
        success: function(data) {
            $('#subcats').html(data);
        },
    });
})
</script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
@endsection