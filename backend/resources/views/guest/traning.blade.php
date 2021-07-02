@extends('layouts.master_guest')

@section('title')
	{{"R&R Property Reservation LLC.| Your Property, Our Priority :: About Us"}}
@endsection


@section('content')
<section id="slider" class="hero p-0 odd featured">
            <div class="swiper-container no-slider slider-h-100">
                <div class="swiper-wrapper">

                    <!-- Item 1 -->
                    <div class="swiper-slide slide-center">
                        
                        <!-- <img src="assets/images/bg-8.jpg" class="full-image" data-mask="70"> -->

                        <div class="slide-content row">
                            <div class="col-12 d-flex inner">
                                <div class="center align-self-center text-center">
                                    <h1 data-aos="zoom-out-up" data-aos-delay="400" class="title effect-static-text">Contractor Training</h1>
                                    <p data-aos="zoom-out-up" data-aos-delay="800" class="description ml-auto mr-auto">Considering our high quality property preservation and consistently cost effective, due time completion, we aim to be the leading property preservation company in the country. Where our quality score card says it all.</p>
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
<!-- content part================================ -->
<!-- Content -->
         <section id="content" class="section-1 single">
            <div class="container">
                <div class="row">

                    <!-- Main -->
                    <main class="col-12 p-0">
                        <div class="row">
                            <div class="col-12 align-self-center">
                                <h2 class="featured mt-0 ml-0">R&R Property Reservation LLC. </h2>
                                <p>We provide personalized training in batches to all our new recruits in the field to ensure that everyone who come on board with us are all on the same page and understands the level of our professionalism and standards. From using mobile apps and the web version to looking out for the little things that so often contractors in the field, we provide an in depth training session and follow up with the participants to make sure that everyone is meeting the standards properly.

</p>
                            
                                <p>Once the recruiting documentation is screened and submitted, all new contractors are provided the training documents and an appointment where they will go through the session online in a live interactive training session.</p>

                                <!-- Image -->
                                <div class="gallery">
                                    <a href="{{ asset('resources/lib/frontend/assets/images/r_r.jpg') }}">
                                        <img src="{{ asset('resources/lib/frontend/assets/images/r_r.jpg') }}" class="w-100">
                                    </a>
                                </div>

                               
                            </div>
                        </div>        
                    </main>
                </div>
            </div>
        </section>

<!-- content part================================ -->
@endsection