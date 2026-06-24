<?php
session_start();

// Centralizamos la conexión a la base de datos
include('db.php');

// Incluimos el encabezado maestro (Navbar y Bootstrap CSS/Scripts)
include('layout/header.php');

// INICIO CAMBIO
// Verificar si la bienvenida ya fue mostrada en esta sesión
$mostrar_bienvenida = false;
if (!isset($_SESSION['splash_shown'])) {
    $mostrar_bienvenida = true;
    $_SESSION['splash_shown'] = true;
}

if ($mostrar_bienvenida) {
    // Ventana de Bienvenida General (Splash Screen Hero)
    // Consulta para contador dinámico de cables de hoy
    $today_date = date('Y-m-d');
    $count_query = "SELECT COUNT(*) as total FROM cables WHERE fecha = '$today_date'";
    $count_res = mysql_query($count_query, $conn);
    $total_cables_today = 0;
    if ($count_res) {
        $count_row = mysql_fetch_array($count_res);
        $total_cables_today = isset($count_row['total']) ? intval($count_row['total']) : 0;
    }

    // Consulta para obtener los últimos 3 cables reales
    $last_cables_query = "SELECT age, titulo FROM cables ORDER BY fecha DESC, hora DESC LIMIT 3";
    $last_cables_res = mysql_query($last_cables_query, $conn);
// FIN CAMBIO
?>
<div id="mainSplash" class="splash-screen-dynamic" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999; display: flex; align-items: center; justify-content: center; overflow: hidden; transition: all 0.8s cubic-bezier(0.77, 0, 0.175, 1);">
    
    <!-- Floating Background Elements (UI Cards) -->
    <div class="hero-visuals">
        <!-- Card 1: Cables (Left-Top) -->
        <div class="floating-card card-cables" style="top: 15%; left: 10%; transform: rotate(-12deg);">
            <div class="f-header"><i class="fas fa-stream"></i> Últimos Cables</div>
            <?php 
            if ($last_cables_res && mysql_num_rows($last_cables_res) > 0) {
                while ($cable = mysql_fetch_array($last_cables_res)) {
                    $agency = strtoupper(trim($cable['age']));
                    $titulo_short = strlen($cable['titulo']) > 28 ? substr($cable['titulo'], 0, 26) . '...' : $cable['titulo'];
                    $badge_class = 'badge-ntx'; // Fallback
                    if ($agency == 'AFP') $badge_class = 'badge-afp';
                    elseif (in_array($agency, ['RTR', 'REUTERS'])) $badge_class = 'badge-rtr';
                    elseif ($agency == 'NTX' || $agency == 'NTX-DEPORTES') $badge_class = 'badge-ntx';
                    else $badge_class = 'badge-other';
                    ?>
                    <div class="f-item">
                        <span class="<?= $badge_class ?>"><?= $agency ?></span>
                        <span><?= htmlspecialchars($titulo_short) ?></span>
                    </div>
                    <?php
                }
            } else {
                echo "<div class='f-item'>No hay cables recientes</div>";
            }
            ?>
        </div>

        <!-- Card 2: Estado del Sistema (Left-Bottom) [REEMPLAZO] -->
        <div class="floating-card card-sistema" style="bottom: 10%; left: 15%; transform: rotate(-5deg);">
            <div class="f-header"><i class="fas fa-server"></i> Estado del Sistema</div>
            <div class="f-item" style="justify-content: space-between; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 4px; margin-bottom: 8px;">
                <span>Servicio de Ingesta:</span>
                <span style="color: #00d1b2; font-weight: bold;"><i class="fas fa-check-circle"></i> ACTIVO</span>
            </div>
            <div class="f-item" style="justify-content: space-between; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 4px; margin-bottom: 8px;">
                <span>Base de Datos:</span>
                <span style="color: #00d1b2; font-weight: bold;"><i class="fas fa-database"></i> ONLINE</span>
            </div>
            <div class="f-item" style="justify-content: space-between; border-bottom: none; padding-bottom: 0; margin-bottom: 0;">
                <span>Uptime Servidor:</span>
                <span style="color: rgba(255,255,255,0.6);">99.9%</span>
            </div>
        </div>

        <!-- Card 3: Flujo de Noticias (Right-Bottom) [REEMPLAZO] -->
        <div class="floating-card card-agencias" style="bottom: 15%; right: 10%; transform: rotate(8deg);">
            <div class="f-header"><i class="fas fa-broadcast-tower"></i> Flujo de Noticias</div>
            <div class="f-item" style="justify-content: space-between; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 4px; margin-bottom: 8px;">
                <span>AFP Internacional:</span>
                <span style="color: #009FE3; font-weight: bold;">RECIBIENDO</span>
            </div>
            <div class="f-item" style="justify-content: space-between; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 4px; margin-bottom: 8px;">
                <span>Reuters Feed:</span>
                <span style="color: #FF8000; font-weight: bold;">RECIBIENDO</span>
            </div>
            <div class="f-item" style="justify-content: space-between; border-bottom: none; padding-bottom: 0; margin-bottom: 0;">
                <span>Notimex / DPA:</span>
                <span style="color: #E30613; font-weight: bold;">RECIBIENDO</span>
            </div>
        </div>

        <!-- Card 4: Stats (Right-Top) -->
        <div class="floating-card card-stats" style="top: 20%; right: 15%; transform: rotate(15deg);">
            <div class="s-val">+<?= number_format($total_cables_today) ?></div>
            <div class="s-lab">Cables Hoy</div>
        </div>
    </div>

    <!-- Central Content -->
    <div style="text-align: center; z-index: 10; position: relative;">
        <div class="splash-brand-animate">
            <div style="display: flex; flex-direction: column; align-items: center; gap: 6px; margin-bottom: 50px; transform: scale(2.4);">
                <div style="width: 20px; height: 20px; background: #009FE3; border-radius: 50%; box-shadow: 0 0 20px rgba(0,159,227,0.4);"></div>
                <div style="width: 20px; height: 20px; background: #E30613; box-shadow: 0 0 20px rgba(227,6,19,0.4);"></div>
            </div>
            <h1 class="splash-title-dynamic" style="font-family: 'Arial Black', sans-serif; font-size: 4rem; margin-bottom: 0px; letter-spacing: -3px; line-height: 1; text-shadow: 0 10px 30px rgba(0,0,0,0.5);">IMAGEN</h1>
            <p class="splash-subtitle-dynamic" style="font-family: 'Outfit', sans-serif; font-size: 0.85rem; letter-spacing: 6px; text-transform: uppercase; margin-bottom: 40px; font-weight: 700;">Sistema de Recepción de Cables</p>
            
            <!-- Texto Breve Descriptivo [NUEVO] -->
            <p class="splash-desc-dynamic" style="font-family: 'Outfit', sans-serif; font-size: 0.95rem; max-width: 480px; margin: -20px auto 50px auto; line-height: 1.5; font-weight: 300;">
                Plataforma interna de monitoreo y recepción de cables informativos en tiempo real.
            </p>
        </div>
        
        <div class="cta-wrapper" style="animation: ctaSlideUp 1s ease-out 0.5s both;">
            <button onclick="enterSystem()" class="btn-ingresar">
                INGRESAR AL SISTEMA
                <i class="fas fa-chevron-right ms-2" style="font-size: 0.8rem;"></i>
            </button>
        </div>
    </div>
</div>

<style>
/* Pantalla de Carga Dinámica */
.splash-screen-dynamic {
    background: radial-gradient(circle at center, #252525 0%, #1a1a1a 100%);
}
.splash-title-dynamic { color: white; }
.splash-subtitle-dynamic { color: rgba(255,255,255,0.4); }

.splash-desc-dynamic { color: rgba(255,255,255,0.5); }
[data-bs-theme="light"] .splash-desc-dynamic { color: rgba(0,0,0,0.6); }

/* Adaptación para Tema Claro */
[data-bs-theme="light"] .splash-screen-dynamic {
    background: radial-gradient(circle at center, #ffffff 0%, #f4f5f7 100%);
}
[data-bs-theme="light"] .splash-title-dynamic { 
    color: #1a1a1a; 
    text-shadow: 0 10px 30px rgba(0,0,0,0.1);
}
[data-bs-theme="light"] .splash-subtitle-dynamic { 
    color: rgba(0,0,0,0.5); 
}
[data-bs-theme="light"] .floating-card {
    background: rgba(0, 0, 0, 0.03);
    border-color: rgba(0, 0, 0, 0.1);
    box-shadow: 0 25px 50px rgba(0,0,0,0.1);
}
[data-bs-theme="light"] .f-item {
    color: rgba(0, 0, 0, 0.7);
    border-bottom-color: rgba(0, 0, 0, 0.05);
}
[data-bs-theme="light"] .s-lab {
    color: rgba(0, 0, 0, 0.4);
}

/* Base de las Tarjetas Flotantes */
.hero-visuals {
    position: absolute;
    width: 100%;
    height: 100%;
    pointer-events: none;
}
.floating-card {
    position: absolute;
    width: 260px;
    background: rgba(255, 255, 255, 0.03);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    padding: 15px;
    box-shadow: 0 25px 50px rgba(0,0,0,0.4);
    animation: floatAnim 6s ease-in-out infinite;
}
.card-cables   { animation-delay: 0s; --rot: -12deg; }
.card-sistema  { animation-delay: 1s; --rot: -5deg; }
.card-agencias { animation-delay: 2s; --rot: 8deg; }
.card-stats    { animation-delay: 1.5s; --rot: 15deg; width: 140px; }

@keyframes floatAnim {
    0%, 100% { transform: translateY(0) rotate(var(--rot)); }
    50% { transform: translateY(-20px) rotate(var(--rot)); }
}

/* Detalles Internos de las Tarjetas */
.f-header { color: #E30613; font-size: 0.75rem; font-weight: 800; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 1px; }
.f-item { display: flex; gap: 8px; margin-bottom: 8px; font-size: 0.7rem; color: rgba(255,255,255,0.7); border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 4px; white-space: nowrap; overflow: hidden; }
.badge-ntx { background: #E30613; color: white; padding: 1px 4px; border-radius: 3px; font-size: 0.6rem; font-weight: 900; }
.badge-afp { background: #009FE3; color: white; padding: 1px 4px; border-radius: 3px; font-size: 0.6rem; font-weight: 900; }
.badge-rtr { background: #FF8000; color: white; padding: 1px 4px; border-radius: 3px; font-size: 0.6rem; font-weight: 900; }
.badge-other { background: #6c757d; color: white; padding: 1px 4px; border-radius: 3px; font-size: 0.6rem; font-weight: 900; }

.f-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 6px; }
.g-box { height: 40px; background: rgba(255,255,255,0.1); border-radius: 4px; }

.f-video { height: 100px; background: #000; border-radius: 8px; margin-bottom: 10px; position: relative; display: flex; align-items: center; justify-content: center; }
.v-play { width: 30px; height: 30px; border-radius: 50%; background: #E30613; color: white; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; }
.v-live { position: absolute; top: 8px; left: 8px; background: #ff0000; color: white; font-size: 0.5rem; padding: 2px 5px; border-radius: 3px; font-weight: 800; }
.f-label { color: rgba(255,255,255,0.6); font-size: 0.65rem; text-align: center; }

.s-val { color: #00d1b2; font-size: 1.8rem; font-weight: 900; text-align: center; font-family: 'Arial Black'; }
.s-lab { color: rgba(255,255,255,0.4); font-size: 0.6rem; text-align: center; text-transform: uppercase; letter-spacing: 2px; }

/* Botón Ingresar Premium */
.btn-ingresar {
    background: #E30613;
    color: white;
    border: none;
    padding: 20px 60px;
    font-size: 1.2rem;
    font-weight: 900;
    border-radius: 60px;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    box-shadow: 0 20px 40px rgba(227, 6, 19, 0.4);
    font-family: 'Outfit', sans-serif;
    letter-spacing: 2px;
    position: relative;
    overflow: hidden;
}
.btn-ingresar:hover {
    transform: translateY(-5px) scale(1.05);
    box-shadow: 0 30px 60px rgba(227, 6, 19, 0.5);
    background: #ff1a2b;
}
.btn-ingresar::after {
    content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%;
    background: linear-gradient(45deg, transparent, rgba(255,255,255,0.2), transparent);
    transform: rotate(45deg);
    animation: btnShine 3s infinite;
}
@keyframes btnShine { from { transform: rotate(45deg) translateX(-100%); } to { transform: rotate(45deg) translateX(100%); } }

/* Animaciones de Entrada */
@keyframes splashFadeIn {
    from { opacity: 0; transform: translateY(30px) scale(0.95); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}
.splash-brand-animate { animation: splashFadeIn 1s cubic-bezier(0.23, 1, 0.32, 1) both; }
@keyframes ctaSlideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

/* Responsive Adjustments */
@media (max-width: 992px) {
    .floating-card { display: none; }
    h1 { font-size: 2.5rem !important; }
}
</style>

<script>
function enterSystem() {
    const splash = document.getElementById('mainSplash');
    splash.style.opacity = '0';
    splash.style.filter = 'blur(40px)';
    splash.style.transform = 'scale(1.1)';
    setTimeout(() => {
        splash.style.display = 'none';
        sessionStorage.setItem('splashShown', 'true');
    }, 800);
}

// INICIO CAMBIO - CORREGIR BUG F5 AUTO-CIERRA
// Eliminada validación de DOMContentLoaded para sessionStorage.getItem('splashShown')
// Esto asegura que al refrescar (F5) la pantalla de bienvenida no desaparezca sola y
// requiera interacción manual del usuario en el botón.
// FIN CAMBIO
</script>
<?php 
} // FIN if ($mostrar_bienvenida) 
?>

<?php
// Recibir parámetro para Sidebars Dinámicos (Fase 6)
$section = isset($_GET['section']) ? $_GET['section'] : 'cables';
$sidebar_path = 'layout/sidebar.php'; // Default

switch ($section) {
    case 'fotos':
        $sidebar_path = 'layout/sidebar_fotos.php';
        break;
    case 'video':
        $sidebar_path = 'layout/sidebar_videos.php';
        break;
    case 'temas':
        $sidebar_path = 'layout/sidebar_temas.php';
        break;
    case 'turbina':
        $sidebar_path = 'layout/sidebar_turbina.php';
        break;
    case 'pi':
        $sidebar_path = 'layout/sidebar_pi.php';
        break;
    case 'prueba':
        $sidebar_path = 'layout/sidebar_pi_test.php';
        break;
}

// Determinar la URL inicial del iframe según la sección
$iframe_src = 'landing.php'; // Fallback
switch ($section) {
    case 'cables':
        $iframe_src = 'landing.php';
        break;
    case 'fotos':
    case 'video':
    case 'temas':
    case 'turbina':
        $iframe_src = 'welcome_section.php?sec=' . urlencode($section);
        break;
    case 'pi':
        $iframe_src = 'layout/section_pi.php';
        break;
    case 'prueba':
        $iframe_src = 'layout/section_pi_test_fresh.php';
        break;
}

// Incluimos la barra lateral Dinámica
if (file_exists($sidebar_path)) {
    include($sidebar_path);
} else {
    include('layout/sidebar.php');
}
?>

<!-- Espacio Central de Trabajo -->
<div class="col-lg-10 col-md-9 col-12 content-column position-relative">
    <div class="card shadow-sm border-0 h-100 position-relative">
        
        <!-- Overlay Spiro de Carga -->
        <div id="spiroOverlay" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: var(--bs-body-bg); z-index: 1050; display: none; align-items: center; justify-content: center; flex-direction: column; border-radius: 0 0 8px 8px; opacity: 1; transition: opacity 0.3s;">
            <div class="spiro">
                <div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
            </div>
            <div class="mt-4 fw-bold" style="font-family: 'Outfit', sans-serif; color: var(--bs-body-color); opacity: 0.7; letter-spacing: 2px;">CONSULTANDO BASE DE DATOS...</div>
        </div>

        <div class="card-body p-0" style="height: 100%;">
            <iframe 
                id="mainIframe"
                name="mainIframe" 
                src="<?= $iframe_src ?>" 
                style="width:100%; height: 100%; border:none; border-radius: 0 0 8px 8px;">
            </iframe>
        </div>
    </div>
</div>

<style>
/* Estilo para resaltar la pestaña activa en el Sidebar */
.list-group-item-action {
    transition: all 0.2s ease;
}
.list-group-item-action:hover {
    background-color: rgba(227, 6, 19, 0.1) !important;
    color: #E30613 !important;
}
.sidebar-active {
    background-color: #E30613 !important;
    color: #ffffff !important;
    border-left: 5px solid #009FE3 !important;
    font-weight: bold !important;
    box-shadow: 0 2px 8px rgba(227, 6, 19, 0.3);
    z-index: 5;
}
.sidebar-active svg {
    stroke: #ffffff !important;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const overlay = document.getElementById("spiroOverlay");
    let loadingTimer;

    // Lógica para resaltar la pestaña activa en el Sidebar
    function setupSidebarActiveLinks() {
        const sidebarLinks = document.querySelectorAll('.list-group-item-action[target="mainIframe"]');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                // Remover clase activa de todos los links que tengan target content
                sidebarLinks.forEach(l => l.classList.remove('sidebar-active'));
                // Añadir clase activa al clicado
                this.classList.add('sidebar-active');
            });
        });
    }

    setupSidebarActiveLinks();

    // Detectar clics en cualquier enlace del menú lateral o Navbar que cargue en el Iframe
    document.body.addEventListener("click", function(e) {
        const link = e.target.closest('a[target="mainIframe"]');
        if (link) {
            showLoader();
        }
    });

    // Detectar si usan la barra de búsqueda animada global
    const globalForm = document.getElementById("globalSearchForm");
    if (globalForm) {
        globalForm.addEventListener("submit", function() {
            showLoader();
        });
    }

    function showLoader() {
        overlay.style.display = "flex";
        setTimeout(() => { overlay.style.opacity = "1"; }, 10);
        
        // Simular tiempo de consulta a la base de datos de 0.4 segundos
        clearTimeout(loadingTimer);
        loadingTimer = setTimeout(() => {
            overlay.style.opacity = "0";
            setTimeout(() => { overlay.style.display = "none"; }, 300);
        }, 400);
    }
});
</script>

<?php
// Incluimos el pie de página (Cierre de etiquetas e IA)
include('layout/footer.php');
?>
