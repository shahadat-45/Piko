@extends('themart.theMartBlank')
@section('mart_header')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('martContent')
<section class="wpo-page-title">
    <h2 class="d-none">Hide</h2>
    <div class="container">
        <div class="row">
            <div class="col col-xs-12">
                <div class="wpo-breadcumb-wrap">
                    <ol class="wpo-breadcumb-wrap">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('cart',Auth::guard('customer')->id()) }}">Cart</a></li>
                        <li>Checkout</li>
                    </ol>
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<!-- end page-title -->

<!-- wpo-checkout-area start-->
<div class="wpo-checkout-area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="single-page-title">
                    <h2>Your Checkout</h2>
                    <p>There are {{ App\Models\Cart::where('customer_id' , Auth::guard('customer')->id())->count() }} products in this list</p>
                </div>
            </div>
        </div>
        <form action="{{ route('order.confirm') }}" method="POST">
            @csrf
            <div class="checkout-wrap">
                <div class="row">
                    <div class="col-lg-8 col-12">
                        <div class="caupon-wrap s3">
                            <div class="biling-item">
                                <div class="coupon coupon-3">
                                    <h2>Billing Address</h2>
                                </div>
                                <div class="billing-adress">
                                    <div class="contact-form form-style">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <input type="text" placeholder="First Name*" id="fname1"
                                                    name="bill_fname">
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <input type="text" placeholder="Last Name*" id="fname2"
                                                    name="bill_lname">
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <select name="bill_country" id="country" class="form-control country">
                                                    <option disabled selected hidden>Select Your Country</option>
                                                    @foreach ($countries as $country)
                                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <select name="bill_city" id="city" class="form-control">
                                                    <option disabled selected hidden>Select City</option>                                                    
                                                </select>
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <input type="text" placeholder="Postcode / ZIP*" id="Post2"
                                                    name="bill_zip">
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <input type="text" placeholder="Company Name*" id="Company"
                                                    name="bill_company">
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <input type="text" placeholder="Email Address*" id="email4"
                                                    name="bill_email">
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <input type="number" placeholder="Phone*" id="email2"
                                                    name="bill_phone">
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-12">
                                                <input type="text" placeholder="Address*" id="Adress"
                                                    name="bill_address">
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-12">
                                                <div class="note-area">
                                                    <textarea name="notes"
                                                        placeholder="Additional Information"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="biling-item-3">
                                    <input id="toggle4" type="checkbox" name="checkbox" value="1">
                                    <label class="fontsize" for="toggle4">Ship to a Different Address?</label>
                                    <div class="billing-adress" id="open4">
                                        <div class="contact-form form-style">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <input type="text" placeholder="First Name*" id="fname6"
                                                        name="ship_fname">
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <input type="text" placeholder="Last Name*" id="fname7"
                                                        name="ship_lname">
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <select name="ship_country" id="Country2" class="form-control">
                                                        <option disabled selected>Select your country</option>
                                                        @foreach ($countries as $country)
                                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                        @endforeach                                                        
                                                    </select>
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <input type="text" placeholder="City / Town*" id="City1"
                                                        name="ship_city">
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <input type="text" placeholder="Postcode / ZIP*" id="Post1"
                                                        name="ship_zip">
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <input type="text" placeholder="Company Name*" id="Company1"
                                                        name="ship_company">
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <input type="email" placeholder="Email Address*" id="email5"
                                                        name="ship_email">
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-12">
                                                    <input type="number" placeholder="Phone*" id="phone1"
                                                        name="ship_phone">
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-12">
                                                    <input type="text" placeholder="Address*" id="Adress1"
                                                        name="ship_address">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="cout-order-area">
                            <h3>Your Order</h3>
                            <div class="oreder-item">
                                <div class="title">
                                    <h2>Products <span>Subtotal</span></h2>
                                </div>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach (App\Models\Cart::where('customer_id' , Auth::guard('customer')->id())->get() as $cart)
                                <div class="oreder-product">
                                    <div class="images">
                                        <span>
                                            <img src="{{ asset('uploads') }}/product/{{ $cart->rel_to_product->thumbnail }}" alt="{{ $cart->rel_to_product->product_name }}">
                                        </span>
                                    </div>
                                    <div class="product">
                                        <ul>
                                            <li class="first-cart">Stylish Pink(x{{ $cart->quantity }})</li>
                                            <li>
                                                <div class="rating-product">
                                                    <i class="fi flaticon-star"></i>
                                                    <i class="fi flaticon-star"></i>
                                                    <i class="fi flaticon-star"></i>
                                                    <i class="fi flaticon-star"></i>
                                                    <i class="fi flaticon-star"></i>
                                                    <span>15</span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <span>${{ $cart->rel_to_inventory->where('color_id' , $cart->color_id)->where('size_id' , $cart->size_id)->first()->after_discount * $cart->quantity }}</span>
                                </div>
                                @php
                                    $total += $cart->rel_to_inventory->where('color_id' , $cart->color_id)->where('size_id' , $cart->size_id)->first()->after_discount * $cart->quantity
                                @endphp
                                @endforeach
                                <div class="title s2">
                                    <h2>Discount<span class="discount">- $ {{ session('discount') ? session('discount') : '0' }}</span></h2>
                                    <input type="hidden" name="discount" value="{{ session('discount') }}">
                                    <input type="hidden" name="customer_id" value="{{ Auth::guard('customer')->id() }}">
                                </div>
                                <!-- Shipping -->
                                <div class="mt-3 mb-3">
                                    <div class="title border-0">
                                        <h2>Delivery Charge</h2>
                                    </div>
                                    <ul>
                                        <li class="free">
                                            <input data-discount="{{ session('discount') }}" id="Free" type="radio" class="charge" name="charge" value="10">
                                            <label for="Free">Inside City: <span>$10.00</span></label>
                                        </li>
                                        <li class="free">
                                            <input data-discount="{{ session('discount') }}" id="Local" type="radio" class="charge" name="charge" value="20">
                                            <label for="Local">Outside City: <span>$20.00</span></label>
                                        </li>
                                    </ul>
                                </div>
                                <div class="title s2">
                                    <h2>Total <span><span>$</span><span class="total">{{ session('discount') ? $total - session('discount') : $total }}</span></span></h2>
                                    <input type="hidden" name="sub_total" value="{{ session('discount') ? $total - session('discount') : $total }}">
                                </div>
                            </div>
                        </div>
                        <div class="caupon-wrap s5">
                            <div class="payment-area">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="payment-option" id="open5">
                                            <h3>Payment</h3>
                                            <div class="payment-select">
                                                <ul>
                                                    <li class="">
                                                        <input id="remove" type="radio" name="payment"
                                                            value="1" checked="checked">
                                                        <label for="remove">Cash on Delivery</label>
                                                    </li>
                                                    <li class="">
                                                        <input id="add" type="radio" name="payment" value="2">
                                                        <label for="add">Pay With SSLCOMMERZ</label>
                                                    </li>
                                                    <li class="">
                                                        <input id="getway" type="radio" name="payment"
                                                            value="3">
                                                        <label for="getway">Pay With STRIPE</label>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div id="open6" class="payment-name active">
                                                <div class="contact-form form-style">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-12">
                                                            <div class="submit-btn-area text-center">
                                                                <button class="theme-btn" type="submit">Place
                                                                    Order</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('footer_script')
<script>
    $('.country').change(function(){
        var country_id = $(this).val();
        // alert($country_id);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url': '/get_cities',
            'type': 'POST',
            data: {'country_id': country_id},
            success: function(data){
                $('#city').html(data);
            }
        });
    })
</script>
<script>
    $('.charge').click(function () {
        $charge = $(this).val();
        $sub_total = {{ $total }};
        $discount = $(this).attr('data-discount');
        if ($discount) {
            $total = (parseInt($charge) + parseInt($sub_total)) - parseInt($discount);
        } else {
           $total = parseInt($charge) + parseInt($sub_total);
        }        
        $('.total').html($total);
        // alert($discount);
    })

</script>
<script>
// In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
    $('.country').select2();
});
</script>
<script>
// In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
    $('#city').select2();
});
</script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection