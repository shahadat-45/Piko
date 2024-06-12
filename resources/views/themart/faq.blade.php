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

    <!-- start wpo-faq-section -->
    <section class="wpo-faq-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 offset-lg-2">
                    <div class="wpo-section-title">
                        <h2>Frequently Asked Question</h2>
                    </div>
                </div>
                <div class="col-lg-8 offset-lg-2">
                    <div class="wpo-faq-wrap">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <div class="wpo-benefits-item">
                                    <div class="accordion" id="accordionExample">
                                        @php
                                            $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
                                        @endphp
                                        @foreach ($faqs as $key => $faq)
                                            <div class="accordion-item">
                                                <h3 class="accordion-header" id="heading{{ $f->format($key + 1) }}">
                                                    <button class="accordion-button {{ $key == 0 ? '' : 'collapsed' }}" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapse{{ $f->format($key + 1) }}"
                                                        aria-expanded="{{ $key == 0 ? true : false }}" aria-controls="collapse{{ $f->format($key + 1) }}">
                                                        {{ $faq->question }}
                                                    </button>
                                                </h3>
                                                <div id="collapse{{ $f->format($key + 1) }}" class="accordion-collapse collapse {{ $key == 0 ? 'show' : '' }}"
                                                    aria-labelledby="heading{{ $f->format($key + 1) }}" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <p>{{ $faq->answer }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach                                        
                                        {{-- <div class="accordion-item">
                                            <h3 class="accordion-header" id="headingTwo">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                    aria-expanded="false" aria-controls="collapseTwo">
                                                    Before hiring a consoel, what kind of questions should I ask?
                                                </button>
                                            </h3>
                                            <div id="collapseTwo" class="accordion-collapse collapse"
                                                aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eum
                                                        exercitationem pariatur iure nemo esse repellendus est quo
                                                        recusandae. Delectus, maxime.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h3 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                    aria-expanded="false" aria-controls="collapseThree">
                                                    Should I meet with multiple Consultancy and shop around before
                                                    hiring one?
                                                </button>
                                            </h3>
                                            <div id="collapseThree" class="accordion-collapse collapse"
                                                aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eum
                                                        exercitationem pariatur iure nemo esse repellendus est quo
                                                        recusandae. Delectus, maxime.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h3 class="accordion-header" id="headingFour">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                                    aria-expanded="false" aria-controls="collapseFour">
                                                    In addition to billable hours, what other costs can consoel's
                                                    charge for?
                                                </button>
                                            </h3>
                                            <div id="collapseFour" class="accordion-collapse collapse"
                                                aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eum
                                                        exercitationem pariatur iure nemo esse repellendus est quo
                                                        recusandae. Delectus, maxime.</p>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end container -->
    </section>
    <!-- end faq-section -->

    <div class="question-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="wpo-section-title">
                        <h2>Do You Have Any Question?</h2>
                    </div>
                </div>
            </div>
            <div class="row" id="faq">
                <div class="col-lg-12">
                    <div class="question-touch">
                        <h2>Get In Touch</h2>
                        @if (session('submited'))
                            <div class="alert alert-success">{{ session('submited') }}</div>
                        @endif
                        <form method="POST" class="contact-validation-active" id="contact-form"
                            novalidate="novalidate" action="{{ route('store.faqs') }}">
                            @csrf
                            <div class="half-col">
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="@error('name'){{ $message }} @else Your Name @enderror ">
                            </div>
                            <div class="half-col">
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="@error('email'){{ $message }} @else Email Address @enderror ">
                            </div>
                            <div class="half-col">
                                <input type="text" name="phone" id="phone" class="form-control"
                                    placeholder="Phone Number">
                            </div>
                            <div>
                                <textarea class="form-control" name="question" id="note"
                                    placeholder="@error('question'){{ $message }} @else  Your Question @enderror"></textarea>
                            </div>
                            <div class="submit-btn-wrapper">
                                <button type="submit" class="theme-btn color-9">Submit Now</button>
                                <div id="loader">
                                    <i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>
                                </div>
                            </div>
                            <div class="clearfix error-handling-messages">                                
                                <div id="success">Thank you</div>                                    
                                <div id="error"> Error occurred while sending email. Please try again later. </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- start of wpo-site-footer-section -->
@endsection