<footer id="footer" class="footer light-background">

    <div class="container">
      <div class="row gy-3">
        <div class="col-lg-3 col-md-6 d-flex">
          <i class="bi bi-geo-alt icon"></i>
          <div class="address">
            <h4>{{ __('footer.Address') }}</h4>
            <p>{{ __('footer.Street') }}</p>
            <p>{{ __('footer.City') }}</p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 d-flex">
          <i class="bi bi-telephone icon"></i>
          <div>
            <h4>{{ __('footer.Contact') }}</h4>
            <p>
              <strong>{{ __('footer.Phone') }}:</strong> <span>+34 617 12 41 01</span><br>
              <strong>{{ __('footer.Email') }}:</strong> <span>clevertradingmadrid@gmail.com</span><br>
            </p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 d-flex">
          <i class="bi bi-clock icon"></i>
          <div>
            <h4>{{ __('footer.Opening Hours') }}</h4>
            <p>
              <strong>{{ __('footer.Mon-Fri') }}:</strong> <span>9AM - 6PM</span><br>
              <strong>{{ __('footer.Sat-Sun') }}:</strong> <span>{{ __('footer.Closed') }}</span>
            </p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <h4>{{ __('footer.Follow Us') }}</h4>
          <div class="social-icons">
              <a href="#" class="twitter" target="_blank"><i class="bi bi-twitter-x"></i></a>
              <a href="#" class="facebook" target="_blank"><i class="bi bi-facebook"></i></a>
              <a href="#" class="instagram" target="_blank"><i class="bi bi-instagram"></i></a>
              <a href="https://www.linkedin.com/in/kleberchilan/" class="linkedin" target="_blank"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>
      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <div class="footer-left">
        <p>© <span>{{ __('footer.Copyright') }}</span> 
          <strong class="px-1 sitename">Nexa</strong> 
          <span>{{ __('footer.All Rights Reserved') }}</span>
        </p>
        <div class="credits">
          {{ __('footer.Designed by') }} <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
      </div>

      <div class="footer-right">
        <p><strong>{{ __('footer.Developed by') }}:</strong> Diana Marti Fleury <br> Luis Fernando Garcia Escorcia <br> Diego Amaro López </p>
      </div>
    </div>
</footer>
