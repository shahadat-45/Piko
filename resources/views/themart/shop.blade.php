@extends('themart.theMartBlank')
@section('martContent')
    <!-- start wpo-page-title -->
    <section class="wpo-page-title">
        <h2 class="d-none">Hide</h2>
        <div class="container">
            <div class="row">
                <div class="col col-xs-12">
                    <div class="wpo-breadcumb-wrap">
                        <ol class="wpo-breadcumb-wrap">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li>FAQ</li>
                        </ol>
                    </div>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- end page-title -->
<div class="shop-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="shop-filter-wrap">
                    <div class="filter-item">
                        <div class="shop-filter-item">
                            <div class="shop-filter-search">
                                <form>
                                    <div>
                                        <input type="text" class="form-control" placeholder="Search..">
                                        <button type="submit"><i class="ti-search"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="filter-item">
                        <div class="shop-filter-item category-widget">
                            <h2>Categories</h2>
                            <ul>
                                @foreach ($categories as $category)                                    
                                <li>
                                    <input type="radio" class="category_id" name="category" value="{{ $category->id }}" id="cat{{ $category->id }}" {{  @$_GET['ctd'] == $category->id ? 'checked' : '' }}>
                                    <label class="topcoat-radio-button_label" for="cat{{ $category->id }}">
                                        {{ $category->name }}<span>({{ App\Models\Products::where('category_id', $category->id)->count() }})</span>
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="filter-item">
                        <div class="shop-filter-item">
                            <h2>Filter by price</h2>
                            <div class="shopWidgetWraper">
                                <div class="priceFilterSlider">
                                    <form action="#" method="get" class="clearfix">
                                        <!-- <div id="sliderRange"></div>
                                        <div class="pfsWrap">
                                            <label>Price:</label>
                                            <span id="amount"></span>
                                        </div> -->
                                        <div class="d-flex">
                                            <div class="col-lg-6 pe-2">
                                                <label for="" class="form-label">Min</label>
                                                <input type="text" id="min" class="form-control" placeholder="Min" value="{{ @$_GET['min'] ?? 0 }}">
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="" class="form-label">Max</label>
                                                <input type="text" id="max" class="form-control" placeholder="Max" value="{{ @$_GET['max'] ?? 10000 }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mt-4">
                                            <button class="form-control bg-light price_submit">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="filter-item">
                        <div class="shop-filter-item">
                            <h2>Color</h2>
                            <ul>
                                @foreach ($colors as $color)
                                 <li>
                                    <label class="topcoat-radio-button__label">
                                        {{ $color->color_name }} <span>({{ App\Models\Inventory::where('color_id' , $color->id)->count() }})</span>
                                        <input type="radio" name="topcoat2" class="color_id" value="{{ $color->id }}" {{ @$_GET['col'] == $color->id ? 'checked' : '' }}>
                                        <span class="topcoat-radio-button"></span>
                                    </label>
                                </li>    
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="filter-item">
                        <div class="shop-filter-item">
                            <h2>Size</h2>
                            <ul>
                                @foreach ($sizes as $size)
                                <li>
                                    <label class="topcoat-radio-button__label">
                                        {{ $size->size }} <span>({{ App\Models\Inventory::where('size_id', $size->id)->count() }})</span>
                                        <input type="radio" class="size" name="topcoat3" value="{{ $size->id }}" {{ @$_GET['size'] == $size->id ? 'checked' : '' }}>
                                        <span class="topcoat-radio-button"></span>
                                    </label>
                                </li>    
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="filter-item">
                        <div class="shop-filter-item new-product">
                            <h2>New Products</h2>
                            <ul>
                                <li>
                                    <div class="product-card">
                                        <div class="card-image">
                                            <div class="image">
                                                <img src="assets/images/new-product/1.png" alt="">
                                            </div>
                                        </div>
                                        <div class="content">
                                            <h3><a href="product.html">Stylish Pink Coat</a></h3>
                                            <div class="rating-product">
                                                <i class="fi flaticon-star"></i>
                                                <i class="fi flaticon-star"></i>
                                                <i class="fi flaticon-star"></i>
                                                <i class="fi flaticon-star"></i>
                                                <i class="fi flaticon-star"></i>
                                                <span>30</span>
                                            </div>
                                            <div class="price">
                                                <span class="present-price">$120.00</span>
                                                <del class="old-price">$200.00</del>
                                            </div>
                                        </div>
                                    </div> 
                                </li>
                                <li>
                                    <div class="product-card">
                                        <div class="card-image">
                                            <div class="image">
                                                <img src="assets/images/new-product/2.png" alt="">
                                            </div>
                                        </div>
                                        <div class="content">
                                            <h3><a href="product.html">Blue Bag</a></h3>
                                            <div class="rating-product">
                                                <i class="fi flaticon-star"></i>
                                                <i class="fi flaticon-star"></i>
                                                <i class="fi flaticon-star"></i>
                                                <i class="fi flaticon-star"></i>
                                                <i class="fi flaticon-star"></i>
                                                <span>30</span>
                                            </div>
                                            <div class="price">
                                                <span class="present-price">$120.00</span>
                                                <del class="old-price">$200.00</del>
                                            </div>
                                        </div>
                                    </div> 
                                </li>
                                <li>
                                    <div class="product-card">
                                        <div class="card-image">
                                            <div class="image">
                                                <img src="assets/images/new-product/3.png" alt="">
                                            </div>
                                        </div>
                                        <div class="content">
                                            <h3><a href="product.html">Kids Blue Shoes</a></h3>
                                            <div class="rating-product">
                                                <i class="fi flaticon-star"></i>
                                                <i class="fi flaticon-star"></i>
                                                <i class="fi flaticon-star"></i>
                                                <i class="fi flaticon-star"></i>
                                                <i class="fi flaticon-star"></i>
                                                <span>30</span>
                                            </div>
                                            <div class="price">
                                                <span class="present-price">$120.00</span>
                                                <del class="old-price">$200.00</del>
                                            </div>
                                        </div>
                                    </div> 
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="filter-item">
                        <div class="shop-filter-item tag-widget">
                            <h2>Popular Tags</h2>
                            <ul>
                                @foreach ($tags as $tag)
                                <li style="text-transform: capitalize" class="tag" value="{{ $tag->id }}"><a>{{ $tag->tag_name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="shop-section-top-inner">
                    <div class="shoping-product">
                        <p>We found <span>{{ $products->count() }} items</span> for you!</p>
                    </div>
                    <div class="short-by">
                        <ul>
                            <li>
                                Sort by: 
                            </li>
                            <li>
                                <select name="show" class="sort">
                                    <option value="0">Default Sorting</option>
                                    <option value="1">A To Z</option>
                                    <option value="2">Z To A</option>
                                </select>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="product-wrap">
                    <div class="row align-items-center">
                        @foreach ($products as $product)
                         <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="product-item">
                                <div class="image">
                                    <img src="{{ asset('uploads') }}/product/{{ $product->thumbnail }}" alt="">
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
                                    @if ($reviews->count() > 99)
                                    <div class="tag sale">Sale</div>
                                    @else
                                    <div class="tag new">New</div>
                                    @endif
                                </div>
                                <div class="text">
                                    <h2><a href="{{ route('product.details' , $product->slug) }}">{{ Str::limit($product->product_name, 30, $end='..') }}</a></h2>
                                    <div class="rating-product">
                                        @if ($avg != 0)
                                            @for ($i=1; $i<=$avg; $i++)
                                                <i class="fi flaticon-star"></i>
                                            @endfor
                                        @endif
                                        <span>{{ $avg }}</span>
                                    </div>
                                    <div class="price">
                                        <span class="present-price">{{ $product->rel_to_inventory->first()->after_discount ?? 'soon' }}</span>
                                        <del class="old-price">${{ $product->rel_to_inventory->first()->new_price ?? '' }}</del>
                                    </div>
                                    <div class="shop-btn">
                                        <a class="theme-btn-s2" href="{{ route('product.details' , $product->slug) }}">Shop Now</a>
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
</div>
<!-- product-area-end -->
    
@endsection
@section('footer_script')
<script>
    $('.category_id').click(function(){
        var keyword = $('#search_input').val();
        var category_id = $('input:radio[class=category_id]:checked').val();
        var col = $('input:radio[class=color_id]:checked').val();
        var size = $('input:radio[class=size]:checked').val();
        var min = $('#min').val();
        var max = $('#max').val();
        var sort = $('.sort').val();
        var link = '{{ route('shop') }}' + '?q=' + keyword + '&ctd=' + category_id + '&min=' + min + '&max=' + max + '&col=' + col + '&size=' + size + '&sort=' + sort ;
        window.location.href = link;
    });
    $('.color_id').click(function(){
        var keyword = $('#search_input').val();
        var category_id = $('input:radio[class=category_id]:checked').val();
        var col = $('input:radio[class=color_id]:checked').val();
        var size = $('input:radio[class=size]:checked').val();
        var min = $('#min').val();
        var max = $('#max').val();
        var sort = $('.sort').val();
        var link = '{{ route('shop') }}' + '?q=' + keyword + '&ctd=' + category_id + '&min=' + min + '&max=' + max + '&col=' + col + '&size=' + size + '&sort=' + sort ;
        window.location.href = link;
    });
    $('.size').click(function(){
        var keyword = $('#search_input').val();
        var category_id = $('input:radio[class=category_id]:checked').val();
        var col = $('input:radio[class=color_id]:checked').val();
        var size = $('input:radio[class=size]:checked').val();
        var min = $('#min').val();
        var max = $('#max').val();
        var sort = $('.sort').val();
        var link = '{{ route('shop') }}' + '?q=' + keyword + '&ctd=' + category_id + '&min=' + min + '&max=' + max + '&col=' + col + '&size=' + size + '&sort=' + sort ;
        window.location.href = link;
    });
    $('.price_submit').click(function(){
        var keyword = $('#search_input').val();
        var category_id = $('input:radio[class=category_id]:checked').val();
        var col = $('input:radio[class=color_id]:checked').val();
        var size = $('input:radio[class=size]:checked').val();
        var min = $('#min').val();
        var max = $('#max').val();
        var sort = $('.sort').val();
        var link = '{{ route('shop') }}' + '?q=' + keyword + '&ctd=' + category_id + '&min=' + min + '&max=' + max + '&col=' + col + '&size=' + size + '&sort=' + sort ;
        window.location.href = link;
    });
    $('.sort').change(function(){
        var keyword = $('#search_input').val();
        var category_id = $('input:radio[class=category_id]:checked').val();
        var col = $('input:radio[class=color_id]:checked').val();
        var size = $('input:radio[class=size]:checked').val();
        var min = $('#min').val();
        var max = $('#max').val();
        var sort = $('.sort').val();
        var link = '{{ route('shop') }}' + '?q=' + keyword + '&ctd=' + category_id + '&min=' + min + '&max=' + max + '&col=' + col + '&size=' + size + '&sort=' + sort ;
        window.location.href = link;
    });
</script>
<script>
    $('.tag').click(function(){
        var tag = $(this).val();
        var link = '{{ route('shop') }}' + '?tag=' + tag ;
        window.location.href = link ;
    })
</script>
@endsection