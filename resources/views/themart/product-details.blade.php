@extends('themart.theMartBlank')
@section('mart_header')
<meta name="csrf-token" content="{{ csrf_token() }}">    
@endsection
@section('martContent')
    <!-- start wpo-page-title -->
    <section class="wpo-page-title">
        <h2 class="d-none">Hide</h2>
        <div class="container">
            <div class="row">
                <div class="col col-xs-12">
                    <div class="wpo-breadcumb-wrap">
                        <ol class="wpo-breadcumb-wrap">
                            <li><a href="index.html">Home</a></li>
                            <li><a href="product.html">Product</a></li>
                            <li>Product Single</li>
                        </ol>
                    </div>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- end page-title -->

    <!-- product-single-section  start-->
    <div class="product-single-section section-padding">
        <div class="container">
            <div class="product-details">
                <div class="row align-items-center">
                    <div class="col-lg-5">
                        <div class="product-single-img">
                            <div class="product-active owl-carousel">
                                @foreach ($galleries as $gallery) 
                                <div class="item">
                                    <img src="{{ asset('uploads') }}/product/{{ $gallery->images }}" alt="">
                                </div>
                                @endforeach
                            </div>
                            <div class="product-thumbnil-active  owl-carousel">
                                @foreach ($galleries as $gallery) 
                                <div class="item">
                                    <img src="{{ asset('uploads') }}/product/{{ $gallery->images }}" alt="">
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="product-single-content">
                            <form action="{{ route('add.cart', $products->id) }}" method="POST">                            
                                @csrf
                                <h2>{{ $products->product_name }}</h2>
                                <div class="price">
                                    <span class="present-price">${{ $products->rel_to_inventory->first()->after_discount ?? 'soon' }}</span>
                                    <del class="old-price">${{ $products->rel_to_inventory->first()->new_price ?? ''}}</del>
                                </div>
                                @php
                                    $avg = 0;
                                    $total_reviews = $reviews->count();
                                    if ($total_reviews == 0) {
                                        $avg = 0;
                                    }
                                    else {
                                        $avg = round($total_star / $total_reviews);
                                    }
                                @endphp
                                <div class="rating-product">
                                    @for ($i=1; $i<=$avg ; $i++)
                                    <i class="fi flaticon-star"></i>
                                    @endfor
                                    <span>{{ $total_reviews }} Reviews</span>
                                </div>
                                <p>{{ $products->short_desp }}</p>
                                <div class="product-filter-item color">
                                    <div class="color-name">
                                        <span>Color :</span>
                                        <ul>
                                            @foreach ($colors as $index => $color) 
                                            @if ($color->rel_to_color->color_code == null )
                                                <li class="{{ $index > 0 ? 'd-none' : 'color1' }}">
                                                    <input class="colors_id" type="radio" name="color_id" id="a1" value="{{ $color->color_id }}">
                                                    <label style="font-size: 12px" for="a1">N/A</label>
                                                </li>
                                                @else
                                                <li class="color1">
                                                    <input class="colors_id" id="a{{ $index + 1 }}" type="radio" name="color_id" value="{{ $color->color_id }}">
                                                    <label style="background-color: {{ $color->rel_to_color->color_code }}" for="a{{ $index + 1 }}"></label>
                                                </li>
                                            @endif
                                            @endforeach                                       
                                        </ul>
                                    </div>
                                </div>
                                <div class="product-filter-item color filter-size">
                                    <div class="color-name">
                                        <span>Sizes:</span>
                                        <ul id="sizes">
                                            @foreach ($sizes as $index => $size)
                                                {{-- {{ $size->rel_to_size->size }} --}}
                                            @if ($size->rel_to_size->size == 'NA')
                                            <li class="size"><input id="sz{{ $size->size_id }}" checked type="radio" name="size_id" value="{{ $size->size_id }}">
                                                <label for="sz{{ $size->size_id }}">{{ $size->rel_to_size->size }}</label>
                                            </li>
                                            @else                                            
                                            <li class="size"><input id="sz{{ $size->size_id }}" type="radio" name="size_id" value="{{ $size->size_id }}">
                                                <label for="sz{{ $size->size_id }}">{{ $size->rel_to_size->size }}</label>
                                            </li>
                                            @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="pro-single-btn">
                                    <div class="quantity cart-plus-minus">
                                        <input class="text-value" type="text" name="quantity" value="1">
                                    </div>
                                    @auth('customer')
                                    <button type="submit" class="theme-btn-s2 border-0">Add to cart</button>
                                    @else
                                    <a href="#" class="theme-btn-s2">Add to cart</a>
                                    @endauth
                                    @auth('customer')
                                    @if (App\Models\Wishlist::where('product_id' , $products->id)->where('customer_id', Auth::guard('customer')->id())->exists())
                                    <a href="{{ route('delete.wishlist', $products->id) }}" style="background: #83B735; color:white; border:1px solid transparent" class="wl-btn"><i class="fi flaticon-heart"></i></a>                                        
                                    @else
                                    <a href="{{ route('add.to.wishlist', $products->id) }}" class="wl-btn"><i class="fi flaticon-heart"></i></a>
                                    @endif
                                    @else
                                    <a href="#" class="wl-btn"><i class="fi flaticon-heart"></i></a>
                                    @endauth
                                </div>
                                <ul class="important-text">
                                    <li class="stock"></li>
                                    <li><span>SKU:</span>FTE569P</li>
                                    <li><span class="me-3">Categories:</span><a href="#" class="badge bg-dark">{{ $products->rel_to_ctg->name }} </a></li>
                                    <li><span class="me-2">Tags:</span>                                    
                                        @php
                                            if ($products->tags == null) {
                                                echo '';
                                            }
                                            else {                                        
                                                $explode = explode(',', $products->tags);                                    
                                                $color = ['bg-primary','bg-secondary','bg-success','bg-danger','bg-warning','bg-info','bg-light','bg-dark','bg-primary','bg-secondary','bg-success','bg-danger','bg-warning','bg-info','bg-light','bg-dark'];
                                                foreach ($explode as $key => $value) {
                                                    $tag = App\Models\Tags::find($value)->tag_name;
                                                    // echo '<span class="badge ' . $color[$key] . '">' . $tag . '</span>';
                                                    echo '<a class="badge me-2 ' . $color[$key] . '">' . $tag . '</a>';
                                                }
                                            }
                                        @endphp
                                    </li>
                                </ul>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-tab-area">
                <ul class="nav nav-mb-3 main-tab" id="tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="descripton-tab" data-bs-toggle="pill"
                            data-bs-target="#descripton" type="button" role="tab" aria-controls="descripton"
                            aria-selected="true">Description</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="Ratings-tab" data-bs-toggle="pill" data-bs-target="#Ratings"
                            type="button" role="tab" aria-controls="Ratings" aria-selected="false">Reviews
                            ({{ $reviews->count() }})</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="Information-tab" data-bs-toggle="pill"
                            data-bs-target="#Information" type="button" role="tab" aria-controls="Information"
                            aria-selected="false">Additional info</button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="descripton" role="tabpanel"
                        aria-labelledby="descripton-tab">
                        <div class="container">
                            {!! $products->long_desp !!}
                            
                        </div>
                    </div>
                    <div class="tab-pane fade" id="Ratings" role="tabpanel" aria-labelledby="Ratings-tab">
                        <div class="container">
                            <div class="rating-section">
                                <div class="row">
                                    <div class="col-lg-12 col-12">
                                        <div class="comments-area">
                                            <div class="comments-section">
                                                <h3 class="comments-title">{{ $reviews->count() }} reviews for Stylish Pink Coat</h3>
                                                <ol class="comments">
                                                    {{-- <li class="comment even thread-even depth-1" id="comment-1">
                                                        <div id="div-comment-1">
                                                            <div class="comment-theme">
                                                                <div class="comment-image"><img
                                                                        src="assets/images/blog-details/comments-author/img-1.jpg"
                                                                        alt></div>
                                                            </div>
                                                            <div class="comment-main-area">
                                                                <div class="comment-wrapper">
                                                                    <div class="comments-meta">
                                                                        <h4>Lily Zener</h4>
                                                                        <span class="comments-date">December 25, 2022 at 5:30 am</span>
                                                                        <div class="rating-product">
                                                                            <i class="fi flaticon-star"></i>
                                                                            <i class="fi flaticon-star"></i>
                                                                            <i class="fi flaticon-star"></i>
                                                                            <i class="fi flaticon-star"></i>
                                                                            <i class="fi flaticon-star"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="comment-area">
                                                                        <p>Turpis nulla proin donec a ridiculus. Mi suspendisse faucibus sed lacus. Vitae risus eu nullam sed quam.
                                                                                Eget aenean id augue pellentesque turpis magna egestas arcu sed. 
                                                                            Aliquam non faucibus massa adipiscing nibh sit. Turpis integer aliquam aliquam aliquam.
                                                                            <a class="comment-reply-link"
                                                                                    href="#"><span>Reply...</span></a>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <ul class="children">
                                                            <li class="comment">
                                                                <div>
                                                                    <div class="comment-theme">
                                                                        <div class="comment-image"><img
                                                                                src="assets/images/blog-details/comments-author/img-2.jpg"
                                                                                alt></div>
                                                                    </div>
                                                                    <div class="comment-main-area">
                                                                        <div class="comment-wrapper">
                                                                            <div class="comments-meta">
                                                                                <h4>Leslie Alexander</h4>
                                                                                <div class="rating-product">
                                                                                    <i class="fi flaticon-star"></i>
                                                                                    <i class="fi flaticon-star"></i>
                                                                                    <i class="fi flaticon-star"></i>
                                                                                    <i class="fi flaticon-star"></i>
                                                                                    <i class="fi flaticon-star"></i>
                                                                                </div>
                                                                                <span class="comments-date">December 26, 2022 at 5:30 am</span>
                                                                            </div>
                                                                            <div class="comment-area">
                                                                                <p>Turpis nulla proin donec a ridiculus. Mi suspendisse faucibus sed lacus. Vitae risus eu nullam sed quam.
                                                                                    Eget aenean id augue pellentesque turpis magna egestas arcu sed. 
                                                                                    Aliquam non faucibus massa adipiscing nibh sit. Turpis integer aliquam aliquam aliquam.
                                                                                    <a class="comment-reply-link"
                                                                                            href="#"><span>Reply...</span></a>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </li> --}}
                                                    @foreach ($reviews as $review)
                                                       <li class="comment">
                                                        <div>
                                                            <div class="comment-theme">
                                                                <div class="comment-image">
                                                                    @if($review->rel_to_customer->photo == NULL)
                                                                        <img src="{{ Avatar::create($review->rel_to_customer->name)->toBase64() }}" width="80"/>
                                                                    @else                                                                        
                                                                        <img src="{{ asset('uploads/customer') }}/{{ $review->rel_to_customer->photo }}" width="80">
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="comment-main-area">
                                                                <div class="comment-wrapper">
                                                                    <div class="comments-meta">
                                                                        <h4>{{ $review->rel_to_customer->name }}</h4>
                                                                        <div class="rating-product">
                                                                            @for ($i=1; $i<=$review->star ; $i++)                                                                                
                                                                                <i class="fi flaticon-star"></i>
                                                                            @endfor
                                                                        </div>
                                                                        <span class="comments-date">December 30, 2022 at 3:12 pm</span>
                                                                    </div>
                                                                    <div class="comment-area">
                                                                        <p>{{ $review->review }}
                                                                            <a class="comment-reply-link"
                                                                                    href="#"><span>Reply...</span></a>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </li> 
                                                    @endforeach                                                    
                                                </ol>
                                            </div> <!-- end comments-section -->
                                            <div class="col col-lg-10 col-12 review-form-wrapper">
                                                @auth('customer') 
                                                @if (App\Models\OrderedProduct::where('customer_id' , Auth::guard('customer')->id())->where('product_id' , $products->id)->exists())
                                                @if (App\Models\OrderedProduct::where('customer_id' , Auth::guard('customer')->id())->whereNotNull('review')->first() == false)
                                                <div class="review-form">
                                                    <h4>Add a review</h4>
                                                    <form action="{{ route('review.store' , $products->id) }}" method="POST">
                                                        @csrf
                                                        <div class="give-rat-sec">
                                                            <div class="give-rating">
                                                                <label>
                                                                    <input type="radio" name="stars" value="1">
                                                                    <span class="icon">★</span>
                                                                </label>
                                                                <label>
                                                                    <input type="radio" name="stars" value="2">
                                                                    <span class="icon">★</span>
                                                                    <span class="icon">★</span>
                                                                </label>
                                                                <label>
                                                                    <input type="radio" name="stars" value="3">
                                                                    <span class="icon">★</span>
                                                                    <span class="icon">★</span>
                                                                    <span class="icon">★</span>
                                                                </label>
                                                                <label>
                                                                    <input type="radio" name="stars" value="4">
                                                                    <span class="icon">★</span>
                                                                    <span class="icon">★</span>
                                                                    <span class="icon">★</span>
                                                                    <span class="icon">★</span>
                                                                </label>
                                                                <label>
                                                                    <input type="radio" name="stars" value="5">
                                                                    <span class="icon">★</span>
                                                                    <span class="icon">★</span>
                                                                    <span class="icon">★</span>
                                                                    <span class="icon">★</span>
                                                                    <span class="icon">★</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <textarea name="comment" class="form-control"
                                                                placeholder="Write Comment..."></textarea>
                                                        </div>
                                                        <div class="name-input">
                                                            <input type="text" name="name" class="form-control" value="{{ Auth::guard('customer')->user()->name }}"
                                                                required>
                                                        </div>
                                                        <div class="name-email">
                                                            <input type="email" name="email" class="form-control" value="{{ Auth::guard('customer')->user()->email }}"
                                                                required>
                                                        </div>
                                                        <div class="rating-wrapper">
                                                            <div class="submit">
                                                                <button type="submit" class="theme-btn-s2">Post
                                                                    review</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                @else
                                                <h3 class="text-center bg-primary py-2 px-2 text-white ">You already review this product</h3>
                                                @endif
                                                @else
                                                    <h3 class="text-center bg-primary py-2 px-2 text-white ">You did not buy this product yet</h3>
                                                @endif
                                                @else
                                                    <h3 class="text-center bg-primary py-2 px-2 text-white ">Login youself to review this product</h3>
                                                @endauth
                                            </div>
                                        </div> <!-- end comments-area -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="Information" role="tabpanel" aria-labelledby="Information-tab">
                        <div class="container">
                            <div class="Additional-wrap">
                                {!! $products->additional_info !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>        
            <div class="related-product">
                <div class="cart-prodact">
                    <h2>You May be Interested in…</h2>
                    <div class="row">
                        @foreach (App\Models\Products::where('category_id' , $products->category_id)->take(4)->get() as $rel_product)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                            <div class="product-item">
                                <div class="image">
                                    <img src="{{ asset('uploads') }}/product/{{ $rel_product->thumbnail }}" alt="{{ $rel_product->thumbnail }}" style="object-fit: contain">
                                    <div class="tag new">New</div>
                                </div>
                                <div class="text">
                                    <h2><a href="{{ route('product.details' , $rel_product->slug) }}">{{ $rel_product->product_name }}</a></h2>
                                    @php
                                        $avg = 0;
                                        $reviews = App\Models\OrderedProduct::where('product_id' , $rel_product->id)->whereNotNull('review')->latest()->get();
                                        $total_star = App\Models\OrderedProduct::where('product_id' , $rel_product->id)->whereNotNull('review')->sum('star');
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
                                        @endif
                                        <span>{{ $reviews->count() }}</span>
                                    </div>
                                    <div class="price">
                                        <span class="present-price">${{ $rel_product->rel_to_inventory->first()->after_discount ?? 'soon' }}</span>
                                        <del class="old-price">${{ $rel_product->rel_to_inventory->first()->new_price ?? '' }}</del>
                                    </div>
                                    <div class="shop-btn">
                                        <a class="theme-btn-s2" href="{{ route('product.details' , $rel_product->slug) }}">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer_script')
<script>
    $('.colors_id').click(function() {
        var product_id = {{ $products->id }};
        var color_id = $(this).val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url': '/product/get_size',
            'type': 'POST',
            data: {'color_id': color_id , 'product_id': product_id},
            success: function(data){
                $('#sizes').html(data);
                //stock
                $('.size').click(function(){
                        var product_id = {{ $products->id }};
                        var size_id = $(this).val();
                        var color_id = $("input[class='colors_id']:checked").val();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                        'url': '/product/get_stock',
                        'type': 'POST',
                        data: {'color_id': color_id, 'product_id':product_id , 'size_id': size_id},
                        success: function(data){
                            $('.stock').html(data);
                        }
                        })
                        $.ajax({
                        'url': '/product/get_price',
                        'type': 'POST',
                        data: {'color_id': color_id, 'product_id':product_id , 'size_id': size_id},
                        success: function(data){
                            $('.present-price').html(data);
                        }
                        })
                        $.ajax({
                        'url': '/product/old_price',
                        'type': 'POST',
                        data: {'color_id': color_id, 'product_id':product_id , 'size_id': size_id},
                        success: function(data){
                            $('.old-price').html(data);
                        }
                        })
                    })
            }
        })
    })
</script>
@endsection