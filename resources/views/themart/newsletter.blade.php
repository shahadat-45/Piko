<!-- start of themart-cta-section -->
<section class="themart-cta-section section-padding" id="newsletter">
    <div class="container">
           <div class="cta-wrap" style="background: url({{ asset('uploads') }}/theMart/{{ App\Models\Newsletter::find(1)->image }})">
            <div class="row">
                <div class="col-lg-6 col-md-8 col-12">
                    <div class="cta-content">
                        <h2 >{!! App\Models\Newsletter::find(1)->title !!}</h2>
                        <form method="POST" action="{{ route('newsletter.store') }}">
                            @csrf
                            <div class="input-1">
                                <input type="email" name="newsletter" class="form-control" placeholder="Your Email..."
                                    required="">
                                    @error('newsletter')
                                        <strong class="text-danger">{{ $message }}</strong>
                                    @enderror
                                <div class="submit clearfix">
                                    <button class="theme-btn-s2" type="submit">Subscribe</button>
                                </div>
                            </div>
                            @if (session('email_submited'))
                                <strong class="text-success">{{ session('email_submited') }}</strong>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</section>
<!-- end of themart-cta-section -->