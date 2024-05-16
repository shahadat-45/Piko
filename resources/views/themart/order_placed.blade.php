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
                        <li>Error</li>
                    </ol>
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<!-- end page-title -->

<!-- start error-404-section -->
<section class="error-404-section pb-5">
    <div class="container">
        <div class="row">
            <div class="col col-xs-12">
                <div class="content clearfix">
                    <div class="error">
                        <img src="{{ asset('TheMart/assets/images/deals/7778129.webp') }}" alt>
                    </div>
                    <div class="error-message mt-0">
                        <h3>Your order placed successfully.</h3>
                        <p>We’re sorry but we can’t seem to find the page you requested. This might be because
                            you have typed the web address incorrectly.</p>
                        <a href="{{ route('home') }}" class="theme-btn">Back to home</a>
                    </div>
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<!-- end error-404-section -->    
@endsection
