@extends('blank')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ $product->product_name}}</h4>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <td>Category</td>
                            <td>{{ $product->rel_to_ctg->name}}</td>
                        </tr>
                        <tr>
                            <td>Sub-Category</td>
                            <td>{{ $product->rel_to_subctg->sub_category_name}}</td>
                        </tr>
                        <tr>
                            <td>Brand</td>
                            <td>{{ $product->rel_to_brand->name ?? 'None' }}</td>
                        </tr>
                        <tr>
                            <td>Price</td>
                            <td>&#2547; {{ $product->price }}</td>
                        </tr>
                        <tr>
                            <td>Discount</td>
                            <td>{{ $product->discount }} %</td>
                        </tr>
                        <tr>
                            <td>After Discount</td>
                            <td>&#2547; {{ $product->price - ($product->price / 100 * $product->discount)}}</td>
                        </tr>
                        <tr>
                            <td>Short Description</td>
                            <td>{!! $product->short_desp !!}</td>
                        </tr>
                        <tr>
                            <td>Long Description</td>
                            <td>{!! $product->long_desp !!}</td>
                        </tr>
                        <tr>
                            <td>Additional Information</td>
                            <td>{!! $product->additional_info !!}</td>
                        </tr>
                        <tr>
                            <td>Tags</td>
                            <td>
                                @php
                                    if ($product->tags == null) {
                                        echo '';
                                    }
                                    else {                                        
                                        $explode = explode(',', $product->tags);                                    
                                        $color = ['badge-primary','badge-secondary','badge-success','badge-danger','badge-warning','badge-info','badge-light','badge-dark','badge-primary','badge-secondary','badge-success','badge-danger','badge-warning','badge-info','badge-light','badge-dark'];
                                        foreach ($explode as $key => $value) {
                                            $tag = App\Models\Tags::find($value)->tag_name;
                                            echo '<span class="badge badge-pill ' . $color[$key] . ' mr-2">' . $tag . '</span>';
                                        }
                                    }
                                @endphp
                            </td>
                        </tr>
                        <tr>
                            <td>Slug</td>
                            <td>{{ $product->slug }}</td>
                        </tr>
                        <tr>
                            <td>Preview Image</td>
                            <td><img class="img-xs rounded-circle" src="{{ asset('uploads/product') }}/{{ $product->thumbnail }}" alt=""></td>
                        </tr>
                        <tr>
                            <td>Gallery Image</td>
                            <td>
                                @foreach ($gallery as $gal_img)                                    
                                <img class="img-xs rounded-circle" src="{{ asset('uploads/product') }}/{{ $gal_img->images }}" alt="">
                                @endforeach
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection