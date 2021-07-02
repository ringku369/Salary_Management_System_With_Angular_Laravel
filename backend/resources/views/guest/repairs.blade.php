@extends('layouts.master_guest')

@section('title')
	{{"R&R Property Reservation LLC.| Your Property, Our Priority :: About Us"}}
@endsection


@section('content')

<!-- content part================================ -->
<section id="slider" class="hero p-0 odd featured">
            <div class="swiper-container no-slider slider-h-100">
                <div class="swiper-wrapper">

                    <!-- Item 1 -->
                    <div class="swiper-slide slide-center">
                        
                        <!-- <img src="assets/images/bg-8.jpg" class="full-image" data-mask="70"> -->

                        <div class="slide-content row">
                            <div class="col-12 d-flex inner">
                                <div class="center align-self-center text-center">
                                    <h1 data-aos="zoom-out-up" data-aos-delay="400" class="title effect-static-text">Repairs and Replacements</h1>
                                    <p data-aos="zoom-out-up" data-aos-delay="800" class="description ml-auto mr-auto">Considering our high quality property preservation and consistently cost effective, due time completion, we aim to be the leading property preservation company in the country. Where our quality score card says it all.</p>
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


<!-- Content -->
       <section id="content" class="section-1 single">
            <div class="container">
                <div class="row">

                    <!-- Main -->
                    <main class="col-12 p-0">
                        <div class="row">
                            <div class="col-12 align-self-center">
                                <h2 class="featured mt-0 ml-0">R&R Property Reservation LLC. </h2>
                                <p>R&R Property Reservation LLC., a property preservation company, based on TX is dedicated to integrity and quality. We are offering a wide variety of services including REO services, property preservation, asset management, home maintenance inspection, trash-out, lawn maintenance, landscaping, among others. Our long standing reputation of high performance, flexibility and accountability defines who we are. A dedicated team of professionals with experience and expertise in property preservation guarantee a quality workmanship in a timely manner. That’s how we strive to meet all our customers’ demands/requirements and also extends to a mutual relationship with them. Our primary goal is to provide the superior, unmatched quality of property preservation services at a reasonable market prices. Our priority is to maintain a healthy and transparent communication and relation both with the clients and the contractor to have a cost-effective solutions for your valuable assets.</p>
                                <p>
                                    <blockquote>Considering our high quality property preservation and consistently cost effective, due time completion, we aim to be the leading property preservation company in the country. Where our quality score card says it all.</blockquote>
                                </p>
                                <p><b>WHY CHOOSE US:</b> because we have a long-standing consistent performance. No task is too small or too big for us to handle. We have highly trained professionals with the ever changing property preservation industry. We provide complete security for your property; hence there should be no worries of vandalism. We also have a dynamic team who takes into all the customers’ feedbacks and opinions focused only on building long term relationships based upon trust and integrity.</p>

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