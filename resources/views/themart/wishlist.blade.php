@extends('themart.theMartBlank')
@section('martContent')
<section class="wpo-page-title">
    <h2 class="d-none">Hide</h2>
    <div class="container">
        <div class="row">
            <div class="col col-xs-12">
                <div class="wpo-breadcumb-wrap">
                    <ol class="wpo-breadcumb-wrap">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('shop') }}">Product Page</a></li>
                        <li>Wishlist</li>
                    </ol>
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<!-- end page-title -->

<!-- cart-area start -->
<div class="cart-area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="single-page-title">
                    <h2>Your Wishlist</h2>
                    <p>There are {{ $wishlist->count() }} products in this list</p>
                </div>
            </div>
        </div>
        <div class="form">
            <div class="cart-wrapper">
                <div class="row">
                    <div class="col-12">
                        <form action="https://wpocean.com/html/tf/themart/cart">
                            <table class="table-responsive cart-wrap">
                                <thead>
                                    <tr>
                                        <th class="images images-b">Product</th>
                                        <th class="ptice">Price</th>
                                        <th class="stock">Stock Status</th>
                                        <th class="remove remove-b">Action</th>
                                        <th class="remove remove-b">Remove</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach ($wishlist as $wishlist)
                                     <tr class="wishlist-item">
                                        <td class="product-item-wish">
                                            <div class="check-box"><input type="checkbox"
                                                    class="myproject-checkbox">
                                            </div>
                                            <div class="images">
                                                <span>
                                                    <img src="{{ asset('uploads') }}/product/{{ $wishlist->rel_to_product->thumbnail }}" alt="">
                                                </span>
                                            </div>
                                            <div class="product">
                                                <ul>
                                                    <li class="first-cart">{{ $wishlist->rel_to_product->product_name }}</li>
                                                    <li>
                                                        @php
                                                            $avg = 0;
                                                            $reviews = App\Models\OrderedProduct::where('product_id' , $wishlist->product_id)->whereNotNull('review')->latest()->get();
                                                            $total_star = App\Models\OrderedProduct::where('product_id' , $wishlist->product_id)->whereNotNull('review')->sum('star');
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
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td class="ptice">$ {{ $wishlist->rel_to_product->rel_to_inventory->first()->after_discount }}</td>
                                        @if ($wishlist->rel_to_product->rel_to_inventory->sum('quantity') > 0)
                                        <td class="stock"><span class="in-stock">In Stock</span></td>
                                        @else    
                                        <td class="stock"><span class="in-stock out-stock">Out Stock</span></td>
                                        @endif
                                        <td class="add-wish">
                                            <a class="theme-btn-s2" href="{{ route('product.details', $wishlist->rel_to_product->slug) }}">Shop Now</a>
                                        </td>
                                        <td class="action">
                                            <ul>
                                                <li class="w-btn"><a data-bs-toggle="tooltip"
                                                        data-bs-html="true" title="" href="{{ route('delete.wishlist', $wishlist->product_id) }}"
                                                        data-bs-original-title="Remove"
                                                        aria-label="Remove"><i
                                                            class="fi flaticon-remove"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>   
                                    @endforeach
                                </tbody> 
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- cart-area end -->

<!-- start of wpo-site-footer-section -->    
@endsection