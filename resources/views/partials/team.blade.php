<!-- Team Section -->
<section id="team" class="team section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <span class="description-title">{{ __('team.section_title') }}</span>
        <h2>{{ __('team.section_title') }}</h2>
        <p>{{ __('team.section_description') }}</p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row g-4">
            @foreach(__('team.members') as $member)
            <div class="col-md-4 col-sm-12" data-aos="fade-up" data-aos-delay="{{ 200 + $loop->index * 100 }}">
                <div class="team-member">
                    <div class="member-image">
                        <img src="{{ asset('assets/img/person/' . $member['image']) }}" 
                        class="img-fluid" 
                        alt="{{ $member['name'] }}" 
                        loading="lazy">
                        <div class="social-overlay">
                            <div class="social-icons">
                                <a href="#"><i class="bi bi-linkedin"></i></a>
                                <a href="#"><i class="bi bi-twitter-x"></i></a>
                                <a href="#"><i class="bi bi-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="member-info">
                        <h4>{{ $member['name'] }}</h4>
                        <span>{{ $member['role'] }}</span>
                        <p>{{ $member['description'] }}</p>
                    </div>
                </div><!-- End Team Member -->
            </div>
            @endforeach
        </div>
    </div>
</section><!-- /Team Section -->
