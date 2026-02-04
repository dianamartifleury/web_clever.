<!-- Hero Section -->
<section id="hero" class="hero section">
  <!-- Fondo dinámico -->
  <div class="hero-background">
    <img src="{{ asset('assets/img/index/bg3.jpg') }}" alt="Background Hero" class="hero-bg-img dynamic-hero-img" id="hero-bg-img">
  </div>

  <!-- Overlay con contenido sobre la imagen -->
  <div class="hero-overlay">
    <div class="container px-3 h-100">
      <div class="row h-100 align-items-center justify-content-center">
        <div class="col-12">

          <!-- TÍTULO CENTRADO -->
          <div class="hero-title-centered">
            <h1><span style="color: #1057C1;">Clever</span> <span style="color: #9CCC65;">Trading</span></h1>
          </div>

          <!-- Layout con columnas -->
          <div class="hero-content-layout">
            <!-- Columna izquierda -->
            <div class="hero-left">
              <h2>{{ __('hero.left_title') }}</h2>
              <p>{{ __('hero.left_paragraph') }}</p>
            </div>

            <!-- Columna derecha -->
            <div class="hero-right">
              <h2 class="dynamic-title">{{ __('hero.dynamic_titles.0') }}</h2>
              <ul class="fixed-subtitles two-columns">
                @foreach(__('hero.subtitles', [], app()->getLocale()) as $subtitle)
                  <li>{{ $subtitle }}</li>
                @endforeach
              </ul>
              <div class="hero-buttons">
                <button id="btn-learn-more" class="btn btn-white">{{ __('hero.btn_learn_more') }}</button>
                <button id="btn-get-started" class="btn btn-primary">{{ __('hero.btn_get_started') }}</button>
              </div>
            </div>
          </div> <!-- /hero-content-layout -->

        </div>
      </div>
    </div>
  </div>

  <!-- Script para cambiar imagen y título dinámico -->
<script>
  const images = [
      @foreach(__('hero.dynamic_titles', [], app()->getLocale()) as $title)
        { src: "{{ asset('assets/img/index/bg' . ($loop->iteration + 2) . '.jpg') }}", title: "{{ $title }}" },
      @endforeach
    ];


    const imgElement = document.querySelector('.dynamic-hero-img');
    const titleElement = document.querySelector('.dynamic-title');

    let currentIndex = 0;

    function updateHeroContent() {
      currentIndex = (currentIndex + 1) % images.length;

      titleElement.classList.remove('fade-in');
      void titleElement.offsetWidth;
      titleElement.classList.add('fade-in');

      imgElement.src = images[currentIndex].src;
      titleElement.textContent = images[currentIndex].title;
    }

    setInterval(updateHeroContent, 5500);
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
        const scrollToSection = (id) => {
            const section = document.querySelector(id);
            if (section) {
                section.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        };

        const learnMoreBtn = document.getElementById('btn-learn-more');
        const getStartedBtn = document.getElementById('btn-get-started');

        if (learnMoreBtn) learnMoreBtn.addEventListener('click', () => scrollToSection('#services'));
        if (getStartedBtn) getStartedBtn.addEventListener('click', () => scrollToSection('#contact'));
    });
  </script>
</section>
