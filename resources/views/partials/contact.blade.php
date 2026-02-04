<!-- Contact Section -->
<section id="contact" class="contact section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <span class="description-title">{{ __('contact.Contact') }}</span>
        <h2>{{ __('contact.Contact') }}</h2>
    </div><!-- End Section Title -->

    <div class="container">
        <div class="contact-wrapper">

            <!-- ================================
                 PANEL IZQUIERDO (INFO)
            ================================= -->
            <div class="contact-info-panel">
                <div class="contact-info-header">
                    <h3>{{ __('contact.Contact Information') }}</h3>
                </div>

                <div class="contact-info-cards">
                    <div class="info-card">
                        <div class="icon-container"><i class="bi bi-pin-map-fill"></i></div>
                        <div class="card-content">
                            <h4>{{ __('contact.Our Location') }}</h4>
                            <p>C. de Manzanares, 4, Arganzuela, 28005 Madrid</p>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="icon-container"><i class="bi bi-envelope-open"></i></div>
                        <div class="card-content">
                            <h4>{{ __('contact.Email Us') }}</h4>
                            <p>clevertradingmadrid@gmail.com</p>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="icon-container"><i class="bi bi-telephone-fill"></i></div>
                        <div class="card-content">
                            <h4>{{ __('contact.Call Us') }}</h4>
                            <p>+34 617 12 41 01</p>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="icon-container"><i class="bi bi-clock-history"></i></div>
                        <div class="card-content">
                            <h4>{{ __('contact.Working Hours') }}</h4>
                            <p>{{ __('contact.Monday-Friday: 9AM - 6PM') }}</p>
                        </div>
                    </div>
                </div>

                <div class="map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d299.48003513127446!2d-3.7184714500277103!3d40.4130593984752!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd42291c0b58c023%3A0x3a36b069bedc4933!2sClever%20Trading%20Europe!5e0!3m2!1ses!2ses!4v1760432289906!5m2!1ses!2ses"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>

                <div class="social-links-panel">
                    <h5>{{ __('contact.Follow Us') }}</h5>
                    <div class="social-icons">
                        <a href="#" class="twitter" target="_blank"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="facebook" target="_blank"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="instagram" target="_blank"><i class="bi bi-instagram"></i></a>
                        <a href="https://www.linkedin.com/in/kleberchilan/" class="linkedin" target="_blank"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
            </div>

            <!-- ================================
                 PANEL DERECHO (FORMULARIO)
            ================================= -->
            <div class="contact-form-panel">
                <div class="form-container">
                    <h3>{{ __('contact.Send Us a Message') }}</h3>
                    <p>{{ __('contact.Form intro') }}
                        <br><br>
                        <i>Fields marked with an asterisk (<span style="color: blue;">*</span>) are required.</i>
                    </p>

                     @php
                        $locale = request()->route('locale');
                    @endphp

                    <form id="contactForm"
                        action="{{ $locale 
                                ? route('contact.store.locale', ['locale' => $locale])
                                : route('contact.store.nolocale') }}"
                        method="POST">                 
                        @csrf

                        <!-- visitor + browser language -->
                        <input type="hidden" name="visitor_id" id="visitor_id_input">
                        <input type="hidden" name="browser_language" id="browser_language_input">

                        <!-- Nombre y apellido -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="firstNameInput" name="first_name" required>
                                    <label for="firstNameInput">{{ __('contact.First Name') }} <span style="color: blue;">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="lastNameInput" name="last_name">
                                    <label for="lastNameInput">{{ __('contact.Last Name') }}</label>
                                </div>
                            </div>
                        </div>

                        <!-- País, ciudad -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="countryInput" name="country">
                                    <label for="countryInput">{{ __('contact.Country') }}</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="cityInput" name="city">
                                    <label for="cityInput">{{ __('contact.City') }}</label>
                                </div>
                            </div>
                        </div>

                        <!-- Teléfono y compañía -->
                        <div class="form-floating mb-3">
                            <input type="tel" class="form-control" id="phoneInput" name="phone" required>
                            <label for="phoneInput">{{ __('contact.Phone Number') }} <span style="color: blue;">*</span></label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="companyInput" name="company">
                            <label for="companyInput">{{ __('contact.Company Name') }}</label>
                        </div>

                        <!-- Email -->
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="emailInput" name="email" required>
                            <label for="emailInput">{{ __('contact.Email Address') }} <span style="color: blue;">*</span></label>
                        </div>

                        <!-- Categorías -->
                        <div class="mb-3">
                            <label class="form-label"><h4>{{ __('contact.Select Categories') }}</h4></label>
                            <div class="row">
                                <div class="custom-checkbox-wrapper">
                                    @foreach ($categories->chunk(ceil($categories->count() / 2)) as $chunk)
                                        <div class="col-md-6">
                                            @foreach ($chunk as $category)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="interests[]" value="{{ $category->id }}">
                                                    <label class="form-check-label">{{ $category->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Mensaje -->
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="notesInput" name="notes" style="height:150px" required></textarea>
                            <label for="notesInput">{{ __('contact.Your Message') }}</label>
                        </div>

                        <!-- ⚡ HCAPTCHA -->
                        <div class="mb-3 mt-3">
                            <div class="h-captcha" data-sitekey="4ae6cdf0-d2fc-4f84-9a0c-1512f58e6fba"></div>
                        </div>

                        <!-- Feedback -->
                        <div class="my-3">
                            <div class="loading">{{ __('contact.Loading') }}</div>
                            <div class="error-message"></div>
                            <div class="sent-message">{{ __('contact.Message sent') }}</div>
                        </div>

                        <!-- Botón -->
                        <div class="d-grid">
                            <button type="submit" class="btn-submit">
                                {{ __('contact.Send Message') }} <i class="bi bi-send-fill ms-2"></i>
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
<!-- Browser language -->
<script>
document.addEventListener("DOMContentLoaded", () => {
    const browserInput = document.getElementById("browser_language_input");
    if (browserInput) {
        browserInput.value = navigator.language || "N/A";
    }
});
</script>

<!-- VISITOR ID -->
<script>
document.addEventListener("DOMContentLoaded", () => {

    function getCookie(n) {
        return document.cookie.split("; ")
            .find(r => r.startsWith(n + "="))
            ?.split("=")[1] || null;
    }

    function setCookie(name, value, days) {
        let expires = "";
        if (days) {
            const d = new Date();
            d.setTime(d.getTime() + days * 86400000);
            expires = "; expires=" + d.toUTCString();
        }

        const isLocal = (location.hostname === "localhost" || location.hostname === "127.0.0.1");
        const sameSite = isLocal ? "Lax" : "None; Secure";

        document.cookie = `${name}=${value}${expires}; path=/; SameSite=${sameSite}`;
    }

    let vid = getCookie("visitor_id");
    if (!vid) {
        vid = "v_" + Math.random().toString(36).substring(2, 12);
        setCookie("visitor_id", vid, 365);
    }

    const input = document.getElementById("visitor_id_input");
    if (input) input.value = vid;
});
</script>

<!-- ============================
     AJAX SUBMIT (CORREGIDO)
============================ -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("contactForm");
    if (!form) return;

    const errorMessage = form.querySelector(".error-message");
    const sentMessage = form.querySelector(".sent-message");
    const loading = form.querySelector(".loading");
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    const getCookie = (name) => {
        return document.cookie
            .split("; ")
            .find(row => row.startsWith(name + "="))
            ?.split("=")[1] || null;
    };

    function setCookie(name, value, days) {
        let expires = "";
        if (days) {
            const date = new Date();
            date.setTime(date.getTime() + days * 86400000);
            expires = "; expires=" + date.toUTCString();
        }

        const isLocal = (location.hostname === "localhost" || location.hostname === "127.0.0.1");
        const sameSite = isLocal ? "Lax" : "None; Secure";

        document.cookie = `${name}=${value}${expires}; path=/; SameSite=${sameSite}`;
    }

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        if (loading) loading.style.display = "block";
        if (errorMessage) errorMessage.style.display = "none";
        if (sentMessage) sentMessage.style.display = "none";

        const visitorId = getCookie("visitor_id");
        const data = new FormData(form);

        if (!visitorId) {
            if (errorMessage) {
                errorMessage.textContent = "Visitor ID missing.";
                errorMessage.style.display = "block";
            }
            return;
        }

        try {
            const response = await fetch(form.action, {
                method: "POST",
                body: data,
                headers: {
                    "X-Visitor-ID": visitorId
                },
                credentials: "include"
            });

            if (loading) loading.style.display = "none";
            const json = await response.json().catch(() => ({}));

            if (response.ok) {

                if (sentMessage) sentMessage.style.display = "block";
                form.reset();

                //-------------------------------------------------------
                // 🔄 1) GENERAR NUEVO VISITOR ID TRAS ENVÍO EXITOSO
                //-------------------------------------------------------
                const newVisitorId = "v_" + Math.random().toString(36).substring(2, 12);
                setCookie("visitor_id", newVisitorId, 365);
                const visitorInput = document.getElementById("visitor_id_input");
                if (visitorInput) visitorInput.value = newVisitorId;
                console.log("Nuevo visitor_id generado:", newVisitorId);

                //-------------------------------------------------------
                // ⭐ 2) REGISTRAR CONSENTIMIENTO REAL DEL USUARIO
                //-------------------------------------------------------
                const consentReal = getCookie("cookie_consent") || "declined";

                fetch("{{ route('metadata.consent') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken
                    },
                    credentials: "include",
                    body: JSON.stringify({
                        consent: consentReal,
                        visitor_id: newVisitorId
                    })
                }).then(() => console.log("Consent registrado para visitor:", newVisitorId))
                  .catch((err) => console.warn("Error registrando consentimiento:", err));

                //-------------------------------------------------------
                // ⭐ 3) REINICIAR TRACKING PARA EL NUEVO ID
                //-------------------------------------------------------
                window.dispatchEvent(new Event("startTracking"));

                //-------------------------------------------------------
                // Reiniciar temporizador anti-bot
                //-------------------------------------------------------
                if (window.botSignals) {
                    window.botSignals.start_time = Date.now();
                    // reset counters if you want:
                    window.botSignals.mouse_moves = 0;
                    window.botSignals.scroll_events = 0;
                    window.botSignals.keypress_events = 0;
                    window.botSignals.time_spent = 0;
                    window.botSignals.cookies_enabled = navigator.cookieEnabled ? 1 : 0;
                }

                setTimeout(() => { if (sentMessage) sentMessage.style.display = "none"; }, 5000);

            } else {
                if (errorMessage) {
                    errorMessage.textContent = json.message || "An error occurred.";
                    errorMessage.style.display = "block";
                }
            }

        } catch (err) {
            if (loading) loading.style.display = "none";
            if (errorMessage) {
                errorMessage.textContent = "Unexpected error.";
                errorMessage.style.display = "block";
            }
        }
    });
});
</script>

<!-- ============================
     BOT SIGNALS
============================ -->
<script>
window.botSignals = {
    mouse_moves: 0,
    scroll_events: 0,
    keypress_events: 0,
    time_spent: 0,
    cookies_enabled: navigator.cookieEnabled ? 1 : 0,
    start_time: Date.now(),
};

document.addEventListener("mousemove", () => window.botSignals.mouse_moves++);
document.addEventListener("scroll", () => window.botSignals.scroll_events++);
document.addEventListener("keydown", () => window.botSignals.keypress_events++);

const contactFormEl = document.getElementById("contactForm");
if (contactFormEl) {
    contactFormEl.addEventListener("submit", () => {
        window.botSignals.time_spent = Date.now() - window.botSignals.start_time;

        const hidden = document.createElement("input");
        hidden.type = "hidden";
        hidden.name = "bot_signals";
        hidden.value = JSON.stringify(window.botSignals);

        contactFormEl.appendChild(hidden);
    });
}
</script>

<script src="https://js.hcaptcha.com/1/api.js" async defer></script>
</section>