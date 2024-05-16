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
                        <li><a href="#">Product Page</a></li>
                        <li>Cart</li>
                    </ol>
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<!-- end page-title -->

<!-- cart-area-s2 start -->
<div class="cart-area-s2 section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="single-page-title">
                    <h2>Your Cart</h2>
                    <p>There are {{ App\Models\Cart::where('customer_id' , Auth::guard('customer')->id())->count() }} products in this list</p>
                </div>
            </div>
        </div>
        <div class="cart-wrapper">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <form action="{{ route('update.cart') }}" method="POST">
                        @csrf
                        <div class="cart-item">
                            <table class="table-responsive cart-wrap">
                                <thead>
                                    <tr>
                                        <th class="images images-b">Product</th>
                                        <th class="ptice">Price</th>
                                        <th class="stock">Quantity</th>
                                        <th class="ptice total">Subtotal</th>
                                        <th class="remove remove-b">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sub_total = 0;
                                    @endphp
                                    @foreach ($carts as $cart)          
                                    <tr class="wishlist-item">
                                        <td class="product-item-wish">
                                            <div class="check-box"><input type="checkbox"
                                                    class="myproject-checkbox">
                                            </div>
                                            <div class="images">
                                                <span>
                                                    <img src="{{ asset('uploads') }}/product/{{ $cart->rel_to_product->thumbnail }}" alt="">
                                                </span>
                                            </div>
                                            <div class="product">
                                                <ul>
                                                    <li class="first-cart">{{ $cart->rel_to_product->product_name }}</li>
                                                    <li>
                                                        <div class="rating-product">
                                                            <i class="fi flaticon-star"></i>
                                                            <i class="fi flaticon-star"></i>
                                                            <i class="fi flaticon-star"></i>
                                                            <i class="fi flaticon-star"></i>
                                                            <i class="fi flaticon-star"></i>
                                                            <span>130</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td class="ptice">${{ $cart->rel_to_inventory->where('color_id' , $cart->color_id)->where('size_id' , $cart->size_id)->first()->after_discount }}</td>
                                        <td class="td-quantity">
                                            <div class="quantity cart-plus-minus">
                                                <input class="text-value" name="quantity[{{ $cart->id }}]" type="text" value="{{ $cart->quantity }}">
                                                <div class="dec qtybutton">-</div>
                                                <div class="inc qtybutton">+</div>
                                            </div>
                                        </td>
                                        <td class="ptice">${{ $cart->rel_to_inventory->where('color_id' , $cart->color_id)->where('size_id' , $cart->size_id)->first()->after_discount * $cart->quantity }}</td>
                                        <td class="action">
                                            <ul>
                                                <li class="w-btn"><a data-bs-toggle="tooltip" data-bs-html="true" title="" href="{{ route('delete.cart' ,$cart->id) }}" data-bs-original-title="Remove from Cart"
                                                    aria-label="Remove from Cart"><i class="fi ti-trash"></i> </a> </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    @php
                                        $sub_total += $cart->rel_to_inventory->where('color_id' , $cart->color_id)->where('size_id' , $cart->size_id)->first()->after_discount * $cart->quantity ;
                                    @endphp  
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                        <div class="cart-action">                            
                            <button class="theme-btn-s2 ms-auto" type="submit"><i class="fi flaticon-refresh"></i>Update Cart</button>
                        </div>
                    </form>
                    
                </div>
                <div class="col-lg-4 col-12">
                    @if ($err_msg)
                        <div class="alert alert-danger">{{ $err_msg }}</div>
                    @endif
                    <form action="{{ route('cart',Auth::guard('customer')->id()) }}" method="GET" class="mb-3">
                        <div class="apply-area">
                            <input type="text" name="coupon" class="form-control" placeholder="Enter your coupon">
                            <button class="theme-btn-s2" type="submit">Apply</button>
                        </div>
                    </form>
                    <div class="cart-total-wrap">
                        <h3>Cart Totals</h3>
                        <div class="sub-total">
                            <h4>Subtotal</h4>
                            <span>${{ $sub_total }}</span>
                        </div>
                        <div class="sub-total my-3">
                            <h4>Discount</h4>
                            <span>- @if ($amount)
                                {{ $type == 1  ? '$'. $amount : $amount . '%'}}
                                @else
                                00.00
                            @endif
                            </span>
                            @php
                                $discount = 0;                                
                                if ($type == 2) {
                                    $discount = ($sub_total / 100) * $amount;
                                }
                                else {
                                    $discount = $amount;
                                }
                                session([
                                    'discount' => $discount,
                                ])
                            @endphp
                        </div>
                        <div class="total mb-3">
                            <h4>Total</h4>                            
                            <span>
                                @if ($type == 1)
                                    ${{ $sub_total - $amount}}
                                @elseif ($type == 2)
                                    ${{ $sub_total - ( ($sub_total / 100) * $amount ) }}
                                @else
                                    ${{ $sub_total }}
                                @endif
                            </span>
                        </div>
                        <a class="theme-btn-s2" href="{{ route('checkout') }}">Proceed To CheckOut</a>
                    </div>
                </div>
            </div>
        </div>        
    </div>
</div>
@endsection