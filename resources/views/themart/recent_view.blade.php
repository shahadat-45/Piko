@extends('themart.theMartBlank')
@section('martContent')
<section class="wpo-page-title">
    <h2 class="d-none">Hide</h2>
    <div class="container">
        <div class="row">
            <div class="col col-xs-12">
                <div class="wpo-breadcumb-wrap">
                    <ol class="wpo-breadcumb-wrap">
                        <li><a href="index.html">Home</a></li>
                        <li>Recently Viewed</li>
                    </ol>
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<!-- end page-title -->

<!-- start of themart-interestproduct-section -->
<section class="themart-interestproduct-section section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="wpo-section-title">
                    <h2>Recently Viewed Product</h2>
                </div>
            </div>
        </div>
        <div class="product-wrap">
            <div class="row">
                @foreach ($data as $product)
                 <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="product-item">
                        <div class="image">
                            <img src="{{ asset('uploads') }}/product/{{ $product->thumbnail }}" alt="">
                            <div class="tag new">New</div>
                        </div>
                        <div class="text">
                            <h2><a href="{{ route('product.details' , $product->slug) }}">{{ $product->product_name }}</a></h2>
                                @php
                                    $avg = 0;
                                    $reviews = App\Models\OrderedProduct::where('product_id' , $product->id)->whereNotNull('review')->latest()->get();
                                    $total_star = App\Models\OrderedProduct::where('product_id' , $product->id)->whereNotNull('review')->sum('star');
                                    if ($reviews->count() != 0) {
                                        $avg = $total_star / $reviews->count() ;
                                    }
                                    else {
                                        $avg = 0;
                                    }
                                @endphp
                            <div class="rating-product">
                                @if ($avg != 0)
                                 @for ($i=1; $i<=$avg; $i++)                                    
                                <i class="fi flaticon-star"></i>
                                @endfor
                                @else
                                @endif
                                <span>{{ $reviews->count() }}</span>
                            </div>
                            <div class="price">
                                <span class="present-price">${{ $product->rel_to_inventory->first()->after_discount ?? 'soon' }}</span>
                                <del class="old-price">${{ $product->rel_to_inventory->first()->new_price ?? '' }}</del>
                            </div>
                            <div class="shop-btn">
                                <a class="theme-btn-s2" href="{{ route('product.details' , $product->slug) }}">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>    
                @endforeach                               
                <div class="more-btn">
                    <a class="theme-btn-s2" href="product.html">Load More</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end of themart-interestproduct-section -->
@endsection