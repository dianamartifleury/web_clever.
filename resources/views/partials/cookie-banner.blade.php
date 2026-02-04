<style>
  #cookie-overlay {
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.6);
    z-index: 9999;
    align-items: center;
    justify-content: center;
  }

  #cookie-box {
    background: #fff;
    border-radius: 12px;
    padding: 2rem;
    max-width: 420px;
    width: 90%;
    text-align: center;
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
    font-family: 'Inter', sans-serif;
    color: #333;
    animation: fadeInUp 0.4s ease;
  }

  @keyframes fadeInUp {
    from { opacity:0; transform:translateY(20px);}
    to {opacity:1; transform:translateY(0);}
  }

  .cookie-buttons {display:flex; gap:1rem; justify-content:center;}
  .cookie-btn {border:none; border-radius:6px; padding:.6rem 1.4rem; cursor:pointer; font-weight:600;}
  #cookie-accept {background-color:#2563eb; color:#fff;}
  #cookie-decline {background-color:#e5e7eb;}
</style>

<div id="cookie-overlay">
  <div id="cookie-box">
    <h3>We Value Your Privacy</h3>
    <p>
      We use essential cookies to make our website work properly.<br>
      Read our <a href="{{ url('/privacy-policy') }}">Privacy & Cookies Policy</a>.
    </p>

    <div class="cookie-buttons">
      <button id="cookie-accept" class="cookie-btn">Accept</button>
      <button id="cookie-decline" class="cookie-btn">Decline</button>
    </div>
  </div>
</div>
<script>
/* ============================================================
   ⛔ BLOQUE TOTAL EN ADMIN (sin cambios)
============================================================ */
if (location.pathname.startsWith("/admin")) {
    console.log("⛔ Tracking y cookie-banner desactivados en /admin");
    window.disableTracking = true;
    const overlay = document.getElementById("cookie-overlay");
    if (overlay) overlay.style.display = "none";
    window.initTrackingAfterConsent = function(){};
    window.sendEventToServer = function(){};
    throw new Error("Cookie banner aborted in admin");
}

/* ============================================================
   UTILIDADES (UNIFICADAS y CORREGIDAS)
   → SameSite=Lax en localhost, SameSite=None; Secure en prod HTTPS
============================================================ */
function setCookie(name, value, days) {
    let expires = "";
    if (days) {
        const date = new Date();
        date.setTime(date.getTime() + days * 86400000);
        expires = "; expires=" + date.toUTCString();
    }

    const isLocal = (location.hostname === "localhost" || location.hostname === "127.0.0.1");
    // LOCAL: Lax (más compatible), PROD: None + Secure
    const sameSite = isLocal ? "Lax" : "None; Secure";

    document.cookie = `${name}=${value}${expires}; path=/; SameSite=${sameSite}`;
}

function getCookie(name) {
    return document.cookie.split("; ")
        .find(row => row.startsWith(name + "="))
        ?.split("=")[1] || null;
}

function ensureVisitorId() {
    let vid = getCookie("visitor_id");
    if (!vid) {
        vid = "v_" + Math.random().toString(36).substring(2, 12);
        setCookie("visitor_id", vid, 365);
    }
    return vid;
}

/* ============================================================
   FILTRO DE RUTAS (LA LISTA EXACTA QUE ME DIJISTE)
============================================================ */
const IGNORED_ROUTES_PREFIXES = [
    "/dashboard/",
    "/dashboard-products-create",
    "/dashboard-products-delete",
    "/dashboard-products-show",
    "/customers",
    "/customers/",
    "/customers/index",
    "/customers/filter",
    "/customers/metadata",
    "/admin",
    "/admin/",
    "/filter",
    "/metadata",
    "/portfolio-details"
];

function isInternalRoute(path) {
    return IGNORED_ROUTES_PREFIXES.some(prefix => path.startsWith(prefix));
}

/* ============================================================
   ENVIAR EVENTO AL SERVIDOR
   -> Nota: el backend decide si guardar o no la traza
============================================================ */
async function sendEventToServer(payload) {
    const visitorId = ensureVisitorId();
    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    fetch("{{ route('metadata.trace') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrf,
        },
        credentials: "include",
        body: JSON.stringify({
            ...payload,
            visitor_id: visitorId
        })
    }).catch(()=>{/* fail silently */});
}

/* ============================================================
   ACTIVAR TRACKING (frontend llama; backend filtra si hace falta)
============================================================ */
function initTrackingAfterConsent() {
    if (getCookie("cookie_consent") !== "accepted") return;

    if (!isInternalRoute(location.pathname)) {
        sendEventToServer({
            type: "route",
            text: location.pathname,
            href: location.href,
            timestamp: new Date().toISOString()
        });
    }

    document.addEventListener("click", (e) => {
        const el = e.target.closest("a, button, [data-track-click]");
        if (!el) return;

        const href = el.href || "";
        let path = "";
        try { path = href ? new URL(href, location.href).pathname : ""; } catch { path = ""; }

        if (!isInternalRoute(path)) {
            sendEventToServer({
                type: "click",
                text: (el.innerText || "").trim().slice(0, 200),
                href: href || null,
                timestamp: new Date().toISOString()
            });
        }
    });
}

/* ============================================================
   MOSTRAR / GESTIONAR BANNER
============================================================ */
document.addEventListener("DOMContentLoaded", () => {
    const overlay = document.getElementById("cookie-overlay");
    const accept  = document.getElementById("cookie-accept");
    const decline = document.getElementById("cookie-decline");
    const csrf    = document.querySelector('meta[name="csrf-token"]').content;

    if (!getCookie("cookie_consent")) {
        if (overlay) overlay.style.display = "flex";
    } else if (getCookie("cookie_consent") === "accepted") {
        initTrackingAfterConsent();
    }

    accept.addEventListener("click", async () => {
        const vid = ensureVisitorId();
        setCookie("cookie_consent", "accepted", 365);

        let geo = null;
        try {
            geo = await new Promise(resolve =>
                navigator.geolocation.getCurrentPosition(
                    pos => resolve({
                        lat: pos.coords.latitude,
                        lon: pos.coords.longitude,
                        accuracy: pos.coords.accuracy
                    }),
                    () => resolve(null)
                )
            );
        } catch {}

        await fetch("{{ route('metadata.consent') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrf,
            },
            credentials: "include",
            body: JSON.stringify({
                consent: "accepted",
                visitor_id: vid,
                geolocation: geo
            })
        });

        if (overlay) overlay.style.display = "none";
        initTrackingAfterConsent();
    });

    decline.addEventListener("click", async () => {
        const vid = ensureVisitorId();
        setCookie("cookie_consent", "declined", 365);

        await fetch("{{ route('metadata.consent') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrf,
            },
            credentials: "include",
            body: JSON.stringify({
                consent: "declined",
                visitor_id: vid
            })
        });

        if (overlay) overlay.style.display = "none";
    });
});

/* ============================================================
   REINICIAR TRACKING TRAS FORMULARIO
============================================================ */
window.addEventListener("startTracking", () => {
    console.log("Tracking restarted for new visitor_id");
    initTrackingAfterConsent();
});
</script>
