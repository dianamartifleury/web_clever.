<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Home - Clever Trading</title>
  <meta name="description" content="">
  <meta name="keywords" content="">
  
  <!-- Meta SEO -->
  <meta name="description" content="Clever Trading - Tu plataforma de trading inteligente.">
  <meta name="keywords" content="trading, finanzas, inversión, clever trading">
<!-- Google Analytics (se activará solo tras aceptar cookies) -->
  {{-- 
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXX"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-XXXXXXX', { 'anonymize_ip': true });
  </script>
  --}}
  <!-- CSRF Token (necesario para Laravel y tus scripts JS) -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    @include('layouts.navbar')
  </header>

  <main class="main">
    @include('partials.hero')
    @include('partials.about')
    @include('partials.values')
    @include('partials.services')
    @include('partials.portfolio')
    @include('partials.team')
    @include('partials.testimonials')
    @include('partials.contact')
  </main>

  @include('layouts.footer')

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>
  @stack('scripts')

  <script>
    document.addEventListener("DOMContentLoaded", function() {
        console.log("DOM Cargado. Intentando detectar idioma..."); 
        var userLang = navigator.language || navigator.userLanguage; 
        console.log("Idioma detectado:", userLang); 
        var langInput = document.getElementById("browser_language_input");
        if (langInput) {
            langInput.value = userLang;
            console.log("Idioma asignado al campo oculto:", langInput.value); 
        } else {
            console.error("Error: No se encontró el campo oculto #browser_language_input"); 
        }
    });
  </script>

<!-- AI Chat Partial -->
@include('partials.ai-chat')
 
@include('partials.cookie-banner')

</body>

</html>
