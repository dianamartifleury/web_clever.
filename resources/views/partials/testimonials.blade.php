<!-- Testimonials Section -->
<section id="testimonials" class="testimonials section light-background">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <span class="description-title">{{ __('testimonials.section_title') }}</span>
        <h2>{{ __('testimonials.section_title') }}</h2>
        <p>{{ __('testimonials.section_description') }}</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="testimonials-slider swiper init-swiper">
            <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 800,
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": 1,
              "spaceBetween": 30,
              "pagination": {
                "el": ".swiper-pagination",
                "type": "bullets",
                "clickable": true
              },
              "breakpoints": {
                "768": {
                  "slidesPerView": 2
                },
                "1200": {
                  "slidesPerView": 3
                }
              }
            }
            </script>

            <div class="swiper-wrapper">
                @foreach(__('testimonials.testimonials', [], app()->getLocale()) as $testimonial)
                    <div class="swiper-slide">
                        <div class="testimonial-card">
                            <div class="testimonial-content">
                                <p>
                                    <i class="bi bi-quote quote-icon"></i>
                                    {{ $testimonial['text'] }}
                                </p>
                            </div>
                            <div class="testimonial-profile">
                                <div class="rating">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>
                                <div class="profile-info">
                                    <img src="{{ asset('assets/img/person/' . $testimonial['image']) }}" alt="{{ $testimonial['name'] }}">
                                    <div>
                                        <h3>{{ $testimonial['name'] }}</h3>
                                        <h4>{{ $testimonial['role'] }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="swiper-pagination"></div>
        </div>

    </div>

</section><!-- /Testimonials Section -->
