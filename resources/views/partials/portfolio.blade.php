<!-- Portfolio Section -->
<section id="portfolio" class="portfolio section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <span class="description-title">{{ __('portfolio.Portfolio') }}</span>
        <h2>{{ __('portfolio.Our Offers') }}</h2>
    </div>
    <!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="isotope-layout" data-default-filter="*" data-layout="fitRows" data-sort="original-order">

            <!-- FILTERS DINÁMICOS -->
            <div class="portfolio-filters-wrapper" data-aos="fade-up" data-aos-delay="100">
                <ul class="portfolio-filters isotope-filters">
                    <li data-filter="*" class="filter-active">{{ __('portfolio.All Products') }}</li>

                    @foreach($categories as $category)
                        <li data-filter=".cat-{{ $category->id }}">{{ __('portfolio.' . $category->name) }}</li>
                    @endforeach
                </ul>
            </div>

            <!-- PORTFOLIO GRID -->
            <div class="row gy-4 portfolio-grid isotope-container" data-aos="fade-up" data-aos-delay="200">

                @foreach($categories as $category)
                    @foreach($category->products as $product)
                        <div class="col-lg-4 col-md-6 portfolio-item isotope-item cat-{{ $category->id }}">

                            <div class="portfolio-card">

                                <div class="image-container">

                                    <img 
                                        src="{{ $product->image_path ? asset('storage/' . $product->image_path) : asset('assets/img/placeholder.png') }}"
                                        class="img-fluid"
                                        alt="{{ $product->name }}"
                                        loading="lazy"
                                    >

                                    <div class="overlay">
                                        <div class="overlay-content">

                                            <a href="{{ $product->image_path ? asset('storage/' . $product->image_path) : asset('assets/img/placeholder.png') }}"
                                               class="glightbox zoom-link"
                                               title="{{ $product->name }}">
                                                <i class="bi bi-zoom-in"></i>
                                            </a>

                                            <a href="#contact"
                                            class="details-link scroll-to-contact"
                                            title="Ver Contacto">
                                            <i class="bi bi-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>

                                </div>

                                <div class="content">
                                    <h3>{{ $product->name }}</h3>
                                    <p>{{ $product->description }}</p>
                                </div>

                            </div>

                        </div>
                    @endforeach
                @endforeach

            </div>
            <!-- End Portfolio Grid -->

        </div>

    </div>

</section>
<!-- /Portfolio Section -->
