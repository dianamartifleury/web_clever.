<!-- About Section -->
<section id="about" class="about section">

  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <span class="description-title">{{ __('about.About') }}</span>
    <h2>{{ __('about.About Us') }}</h2>
  </div><!-- End Section Title -->

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="row gx-0 gx-lg-5 gy-5 align-items-center">
      <div class="col-lg-6" data-aos="zoom-out" data-aos-delay="200">
        <div class="image-wrapper">
          <div class="image-box">
            <img src="assets/img/about/about-square-15.webp" class="img-fluid" alt="About" loading="lazy">
          </div>
          <div class="experience-box" data-aos="zoom-in" data-aos-delay="300">
            <div class="years">10+</div>
            <div class="text">{{ __('about.Years of Experience') }}</div>
          </div>
        </div>
      </div>

      <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
        <div class="content">
          <div class="section-header">
            <h3><b><center>{{ __('about.Smart solutions for managing your stock') }}</center></b></h3>
          </div>

          <p class="highlight-text">
            {{ __('about.Main paragraph') }}
          </p>

          <div class="features-list">
            <div class="feature-item" data-aos="zoom-in" data-aos-delay="300">
              <div class="icon-box"><i class="bi bi-check2-circle"></i></div>
              <div class="text"><h4>{{ __('about.International barter') }}</h4></div>
            </div>

            <div class="feature-item" data-aos="zoom-in" data-aos-delay="400">
              <div class="icon-box"><i class="bi bi-check2-circle"></i></div>
              <div class="text"><h4>{{ __('about.European commercial network') }}</h4></div>
            </div>

            <div class="feature-item" data-aos="zoom-in" data-aos-delay="500">
              <div class="icon-box"><i class="bi bi-check2-circle"></i></div>
              <div class="text"><h4>{{ __('about.Logistics management') }}</h4></div>
            </div>

            <div class="feature-item" data-aos="zoom-in" data-aos-delay="600">
              <div class="icon-box"><i class="bi bi-check2-circle"></i></div>
              <div class="text"><h4>{{ __('about.Competitive prices') }}</h4></div>
            </div>
          </div>

          <div class="cta-buttons">
            <a id="btn-about-contact" class="btn-get-started">{{ __('about.Contact Us') }}</a>

            <div class="personalized-contact">
              <div class="phone-icon"><i class="bi bi-telephone-fill"></i></div>
              <div class="phone-text">
                <h5>{{ __('about.Personalized Attention') }}</h5>
                <a href="tel:+34617124101">+34 617 12 41 01</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const scrollToSection = (id) => {
      const section = document.querySelector(id);
      if (section) {
        section.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    };
    const aboutContactBtn = document.getElementById('btn-about-contact');
    if (aboutContactBtn) {
      aboutContactBtn.addEventListener('click', () => scrollToSection('#contact'));
    }
  });
</script><!-- /About Section -->
