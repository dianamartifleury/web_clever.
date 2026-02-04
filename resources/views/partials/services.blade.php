<!-- Services Section -->
<section id="services" class="services section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <span class="description-title">{{ __('services.section_title') }}</span>
        <h2>{{ __('services.section_title') }}</h2>
        <p>{{ __('services.section_description') }}</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="services-container">
            <div class="row g-4">
                @foreach(__('services.services', [], app()->getLocale()) as $service)
                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="{{ 100 * ($loop->iteration) }}">
                        <div class="service-item">
                            <div class="service-icon">
                                @php
                                    $icons = ['bi-code-slash','bi-bar-chart','bi-palette','bi-megaphone'];
                                @endphp
                                <i class="bi {{ $icons[$loop->index] }}"></i>
                            </div>
                            <div class="service-content">
                                <span class="service-number">{{ $service['number'] }}</span>
                                <h3 class="service-title">{{ $service['title'] }}</h3>
                                <p class="service-text">{{ $service['text'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="cta-wrapper mt-5 text-center" data-aos="fade-up" data-aos-delay="100">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="cta-box">
                        <div class="row align-items-center">
                            <div class="col-lg-4">
                                <div class="cta-image" data-aos="zoom-in" data-aos-delay="200">
                                    <img src="{{ asset('assets/img/services/services-7.webp') }}" alt="Services" class="img-fluid rounded-circle">
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="cta-content text-lg-start" data-aos="fade-left" data-aos-delay="300">
                                    <h3>{{ __('services.cta.title') }}</h3>
                                    <p>{{ __('services.cta.description') }}</p>
                                    <div class="cta-buttons">
                                        <div class="personalized-contact">
                                            <div class="phone-icon">
                                                <i class="bi bi-telephone-fill"></i>
                                            </div>
                                            <div class="phone-text">
                                                <h5>{{ __('services.cta.attention') }}</h5>
                                                <a href="tel:+34617124101">+34 617 12 41 01</a>
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
    
</section><!-- /Services Section -->
