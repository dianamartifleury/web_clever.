<body>
<!-- HEADER -->
<div class="container position-relative d-flex align-items-center justify-content-between">

  <!-- Logo a la izquierda -->
  <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto me-xl-0">
    <img src="{{ asset('assets/img/logoclevertrading-web.png') }}" alt="">
  </a>

  <!-- Nav centrado -->
  <nav id="navmenu" class="navmenu">
    <i class="mobile-nav-toggle bi bi-list"></i>

    <ul>
      <li><a href="#hero" class="active">{{ __('navbar.home') }}</a></li>
      <li><a href="#about">{{ __('navbar.about_us') }}</a></li>
      <li><a href="#services">{{ __('navbar.our_services') }}</a></li>
      <li><a href="#portfolio">{{ __('navbar.our_offers') }}</a></li>
      <li><a href="#team">{{ __('navbar.team') }}</a></li>
      <li><a href="#contact">{{ __('navbar.contact') }}</a></li>


      <!-- 🌐 Dropdown de idioma -->
      <li class="dropdown">
        <a href="#" class="dropdown-toggle">
        {{ __('navbar.language') }} <i class="bi bi-chevron-down"></i>
        </a>

        <ul class="dropdown-menu">
          <li><a href="{{ route('lang.switch', ['locale' => 'en']) }}">English</a></li>
          <li><a href="{{ route('lang.switch', ['locale' => 'fr']) }}">French</a></li>
          <li><a href="{{ route('lang.switch', ['locale' => 'es']) }}">Spanish</a></li>
          <li><a href="{{ route('lang.switch', ['locale' => 'it']) }}">Italian</a></li>
        </ul>
      </li>

      @auth
        <li><a href="{{ route('dashboard') }}">Panel de administración</a></li>
        <li>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-link nav-link" style="display:inline;padding:0;margin:0;">
              Cerrar sesión
            </button>
          </form>
        </li>
      @endauth
    </ul>
  </nav>

  <!-- Redes sociales -->
  <div class="header-social-links">
    <a href="#" class="twitter" target="_blank"><i class="bi bi-twitter-x"></i></a>
    <a href="#" class="facebook" target="_blank"><i class="bi bi-facebook"></i></a>
    <a href="#" class="instagram" target="_blank"><i class="bi bi-instagram"></i></a>
    <a href="https://www.linkedin.com/in/kleberchilan/" class="linkedin" target="_blank"><i class="bi bi-linkedin"></i></a>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const toggle = document.querySelector('.mobile-nav-toggle');
  const navMenu = document.querySelector('.navmenu ul');

  if (toggle && navMenu) {
    toggle.addEventListener('click', function () {
      navMenu.classList.toggle('navmenu-open');
    });
  }

  const dropdownToggles = document.querySelectorAll('.dropdown > .dropdown-toggle');
  dropdownToggles.forEach(function (toggle) {
    toggle.addEventListener('click', function (e) {
      e.preventDefault();
      const parentLi = this.parentElement;
      const dropdownMenu = parentLi.querySelector('.dropdown-menu');
      dropdownMenu.classList.toggle('dropdown-open');
    });
  });
});
</script>
</body>
