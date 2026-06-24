<?php
// Layout Footer (Cierra contenedores y carga Scripts JS)
?>
    </div> <!-- End Row -->
</div> <!-- End Container Fluid -->

<!-- Botón Flotante para GIM-AI -->
<div class="bot-label">ASISTENTE DE BÚSQUEDA</div>
<div class="gimm-btn shadow-lg" id="gimai-btn-trigger" title="Asistente de Búsqueda">
    <div class="gimm-logo-icon me-0" style="transform: scale(0.8);">
        <div class="circle" style="width: 14px; height: 14px; background: white; border-radius: 50%;"></div>
        <div class="square" style="width: 14px; height: 14px; background: #E30613; box-shadow: 0 0 10px rgba(255,255,255,0.4);"></div>
    </div>
</div>

<!-- Ventana de Chat GIM-AI (Transformada en Offcanvas para mayor espacio) -->
<div class="offcanvas offcanvas-end border-0 shadow-lg" tabindex="-1" id="gimai-offcanvas" aria-labelledby="gimaiLabel" style="width: 450px;">
    <!-- Cabecera Corporativa Inmersiva -->
    <div class="offcanvas-header text-white" style="background: linear-gradient(135deg, #1a1a1a 0%, #333 100%); border-bottom: 3px solid #E30613;">
        <div class="d-flex align-items-center gap-3">
            <div class="gimm-logo-icon" style="transform: scale(0.8);">
                <div class="circle" style="width: 18px; height: 18px; background-color: #009FE3; border-radius: 50%;"></div>
                <div class="square" style="width: 18px; height: 18px; background-color: #E30613;"></div>
            </div>
            <div>
                <h5 class="offcanvas-title fw-bold" id="gimaiLabel" style="letter-spacing: 0.5px; font-family: 'Outfit', sans-serif;">ASISTENTE DE BÚSQUEDA</h5>
                <small class="opacity-75" style="font-size: 0.75rem;">Buscador de Cables - Grupo Imagen</small>
            </div>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <!-- Cuerpo del Chat (Scroll Aislado) -->
    <div class="offcanvas-body d-flex flex-column bg-body-tertiary p-0">
        <div id="gimai-chat-body" class="p-3 flex-grow-1" style="overflow-y: auto; overscroll-behavior: contain; scrollbar-width: thin;">
            <!-- Los mensajes se inyectan aquí -->
        </div>

        <!-- Área de Input Fija al fondo -->
        <div class="p-3 bg-body border-top shadow-sm">
            <div class="input-group mb-2">
                <input type="text" id="gimai-input" class="form-control rounded-pill me-2 border-primary py-2 px-3" placeholder="¿En qué puedo ayudarte hoy?" style="box-shadow: none; font-size: 0.8rem;">
                <button id="gimai-send" class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 45px; height: 45px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                </button>
            </div>
            <div class="text-center">
                <small class="text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 1px; opacity: 0.5;">
                     DESARROLLADO POR EQUIPO DE SISTEMAS - IMAGEN
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Cargar el Cerebro NLP del Asistente GIM-AI -->
<script src="js/gimai_bot.js?v=<?php echo time(); ?>"></script>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script para la animación expansiva del modo oscuro -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const trigger = document.getElementById('gimai-btn-trigger');
    const offcanvasEl = document.getElementById('gimai-offcanvas');
    const chatBody = document.getElementById('gimai-chat-body');
    const input = document.getElementById('gimai-input');

    if (offcanvasEl && trigger) {
        const offcanvas = new bootstrap.Offcanvas(offcanvasEl);

        // Disparador del botón flotante
        trigger.onclick = () => {
            offcanvas.toggle();
        };

        // Al abrir, limpiar, saludar y OCULTAR botón para evitar solapamiento
        offcanvasEl.addEventListener('show.bs.offcanvas', () => {
             chatBody.innerHTML = ""; 
             // addMessage está definido en gimai_bot.js
             if (typeof addMessage === 'function') {
                addMessage(GIMAI_INTRO, 'bot');
             }
             trigger.style.opacity = "0"; 
             trigger.style.pointerEvents = "none";
             const label = document.querySelector('.bot-label');
             if(label) label.style.opacity = "0";
             setTimeout(() => { if(input) input.focus(); }, 500);
        });

        // Al cerrar, devolver botón
        offcanvasEl.addEventListener('hidden.bs.offcanvas', () => {
             trigger.style.opacity = "1";
             trigger.style.pointerEvents = "auto";
             const label = document.querySelector('.bot-label');
             if(label) label.style.opacity = "1";
        });
    }

    const themeBtn = document.getElementById('themeToggleBtn');
    const ripple = document.getElementById('theme-ripple');
    const htmlElement = document.documentElement;

    if(themeBtn) {
        // Sincronizar estado inicial con el checkbox
        const currentTheme = htmlElement.getAttribute('data-bs-theme');
        if(currentTheme === 'dark') {
            themeBtn.checked = true;
        } else {
            themeBtn.checked = false;
        }

        // Cambiar el tema al hacer click en el switch
        themeBtn.addEventListener('change', (e) => {
            const isDark = themeBtn.checked;
            const newTheme = isDark ? 'dark' : 'light';
            
            // Opcional: Mantener el ripple effect
            const rect = themeBtn.getBoundingClientRect();
            const x = rect.left + rect.width / 2;
            const y = rect.top + rect.height / 2;
            const radius = Math.max(Math.hypot(x, y), Math.hypot(window.innerWidth - x, y), Math.hypot(x, window.innerHeight - y), Math.hypot(window.innerWidth - x, window.innerHeight - y));
            
            if(ripple) {
                ripple.style.width = '2px'; ripple.style.height = '2px'; ripple.style.left = (x - 1) + 'px'; ripple.style.top = (y - 1) + 'px'; ripple.style.transition = 'none'; ripple.style.transform = 'scale(0)'; ripple.style.opacity = '1';
                void ripple.offsetWidth;
                ripple.style.transition = 'transform 0.6s cubic-bezier(0.645, 0.045, 0.355, 1), opacity 0.6s ease';
                ripple.style.transform = `scale(${radius})`;
            }

            setTimeout(() => {
                htmlElement.setAttribute('data-bs-theme', newTheme);
                localStorage.setItem('theme', newTheme);
            }, 300);
            
            if(ripple) {
                setTimeout(() => { 
                    ripple.style.opacity = '0'; 
                    setTimeout(() => { ripple.style.transform = 'scale(0)'; }, 300); 
                }, 600);
            }
        });
    }
});
</script>

</body>
</html>
