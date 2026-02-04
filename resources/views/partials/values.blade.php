<!-- Values Section -->
<section id="values" class="values section">
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <span class="description-title">{{ __('values.section_title') }}</span>
        <h2>{{ __('values.section_title') }}</h2>
    </div><!-- End Section Title -->

    <div class="container values-grid" data-aos="fade-up" data-aos-delay="100">

        <!-- Left Column -->
        <div class="values-column left">
            @foreach(array_slice(__('values.values', [], app()->getLocale()), 0, 2) as $index => $value)
                <div class="process-item" data-aos="fade-up" data-aos-delay="{{ 200 + ($index * 100) }}">
                    <div class="content">
                        <span class="value-number">0{{ $index + 1 }}</span>
                        <div class="card-body">
                            <div class="value-icon">
                                <i class="bi {{ ['bi-arrow-left-right','bi-globe-americas'][$index] }}"></i>
                            </div>
                            <div class="value-content">
                                <h3>{{ $value['title'] }}</h3>
                                <p>{{ $value['text'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Center Image -->
        <div class="values-image" data-aos="zoom-in" data-aos-delay="350">
            <img src="assets/img/ourvalues/ourvalues.jpg" alt="{{ __('values.section_title') }}">
        </div>

        <!-- Right Column -->
        <div class="values-column right">
            @foreach(array_slice(__('values.values', [], app()->getLocale()), 2, 2) as $index => $value)
                <div class="process-item" data-aos="fade-up" data-aos-delay="{{ 400 + ($index * 100) }}">
                    <div class="content">
                        <span class="value-number">0{{ $index + 3 }}</span>
                        <div class="card-body">
                            <div class="value-icon">
                                <i class="bi {{ ['bi-truck','bi-diagram-3'][$index] }}"></i>
                            </div>
                            <div class="value-content">
                                <h3>{{ $value['title'] }}</h3>
                                <p>{{ $value['text'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    <br>

    <!-- Offers Section -->
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="container section-title" data-aos="fade-up">
                <span class="description-title">{{ __('values.offers_title') }}</span>
                <h2>{{ __('values.offers_title') }}</h2>
            </div>
            <div class="hero-stats" data-aos="fade-up" data-aos-delay="500">
                @foreach(__('values.offers_stats', [], app()->getLocale()) as $stat)
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="bi bi-database-lock"></i> {{-- Cambiar iconos si quieres --}}
                        </div>
                        <h3>
                            <span data-purecounter-start="0"
                                  data-purecounter-end="{{ $stat['percent'] }}"
                                  data-purecounter-duration="1"
                                  class="purecounter"></span>%
                        </h3>
                        <p>{{ $stat['text'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section><!-- End Values Section -->
