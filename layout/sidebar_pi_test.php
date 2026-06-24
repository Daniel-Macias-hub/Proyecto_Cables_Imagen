<?php
date_default_timezone_set('America/Mexico_City');
$today = date('Y-m-d');
$station = 10000000001;

// Indicador: hay pauta publicada hoy?
include('db.php');
$hay_pauta = false;
$q_check = mysql_query("SELECT COUNT(*) as c FROM pi WHERE estacion = $station AND fecha LIKE '$today%'");
if ($q_check) {
    $r_check = mysql_fetch_assoc($q_check);
    $hay_pauta = ((int)$r_check['c']) > 0;
}

// Array Maestro de los 12 programas oficiales
$programas_pi = [
    'Imagen Empresarial',
    'Primera Emisión L-V',
    'Qué tal Fernanda',
    'Qué tal Fernanda Lun-Vie',
    'Segunda Emisión L-V',
    'Palabra del Deporte',
    'Autos en Imagen',
    'Negocios en Imagen',
    'Tercera Emisión L-V',
    'Análisis Superior',
    'En Directo Pue y Tlax',
    'Programa Pagado (Neximo)'
];
?>
<div class="col-lg-2 col-md-3 sidebar-column p-0 d-none d-md-block" style="height: 100vh; overflow-y: auto !important; overflow-x: hidden; display: block;">
    <div class="bg-transparent" style="padding-bottom: 150px;">

        <!-- Header SISTEMA PI TEST -->
        <div class="card-header pi-sidebar-header text-white fw-bold d-flex align-items-center justify-content-between"
             style="font-family: 'Outfit', sans-serif; z-index: 10; height: 50px; padding: 0 18px; background: linear-gradient(135deg, #1a1a1a 0%, #333333 100%); border-bottom: 3px solid #E30613; position: sticky; top: 0;">
            <span style="white-space: nowrap; font-size: 1rem; letter-spacing: 0.5px;">
                <i class="fas fa-broadcast-tower me-2" style="color:#E30613;"></i>SISTEMA PRUEBAS
            </span>
        </div>

        <!-- SECCIÓN ESTACIÓN -->
        <div class="list-group-item fw-bold text-uppercase py-2 d-flex align-items-center gap-2 pi-sidebar-divider"
             style="font-size: 0.7rem; letter-spacing: 1.5px; border: none; padding-left: 16px; margin-top: 10px;">
            <i class="fas fa-satellite-dish" style="color:#E30613;"></i> ACCIONES GENERALES
        </div>

        <!-- XEDA Pauta Completa -->
        <a href="./programstest.php?dateT=<?= $today ?>&station=<?= $station ?>" target="mainIframe"
           class="list-group-item list-group-item-action d-flex align-items-center gap-2 pi-btn-primary"
           style="border-radius:6px; margin:4px 10px; padding:10px 14px; font-family:'Outfit',sans-serif; font-size:0.85rem; font-weight:700; letter-spacing:0.3px; transition:all 0.2s; text-decoration:none; width:calc(100% - 20px);">
            <i class="fas fa-list-alt" style="font-size: 1.1rem; color: #009FE3;"></i>
            <span style="flex-grow: 1;">XEDA Pauta Completa</span>
            <?php if ($hay_pauta): ?>
            <span title="Pauta publicada hoy" style="display:inline-block; width:10px; height:10px; border-radius:50%; background:#009FE3; box-shadow:0 0 6px rgba(0,159,227,0.8); flex-shrink:0;"></span>
            <?php endif; ?>
        </a>

        <!-- Consultas Especiales -->
        <div style="margin: 4px 10px; width: calc(100% - 20px);">
            <div style="font-size:0.65rem; font-weight:700; text-transform:uppercase; letter-spacing:1.5px; color:#6c757d; margin:10px 0 6px 6px;">
                <i class="fas fa-folder-open" style="color:#E30613;"></i> Consultas Especiales
            </div>
            <a href="javascript:void(0)" onclick="window.parent.document.getElementById('mainIframe').src='layout/history_pi_test.php'"
               style="display:flex; align-items:center; gap:10px; padding:10px 14px; border-radius:8px; background:rgba(227,6,19,0.06); border:1px solid rgba(227,6,19,0.18); text-decoration:none; color:inherit; font-family:'Outfit',sans-serif; font-size:0.83rem; font-weight:700; transition:all 0.2s; width:100%;"
               onmouseover="this.style.background='rgba(227,6,19,0.14)'; this.style.color='#E30613';"
               onmouseout="this.style.background='rgba(227,6,19,0.06)'; this.style.color='inherit';">
                <i class="fas fa-history" style="font-size:1rem; color:#E30613; flex-shrink:0;"></i>
                <span>Ver Historial Completo</span>
            </a>
        </div>

        <!-- Nuevo Registro -->
        <a href="./nuevo.php?action=pi&id=0000000&nom=9999999" target="mainIframe"
           class="list-group-item list-group-item-action d-flex align-items-center gap-2 pi-btn-cta"
           style="border-radius:6px; margin:4px 10px; padding:10px 14px; font-family:'Outfit',sans-serif; font-size:0.85rem; font-weight:700; letter-spacing:0.3px; transition:all 0.2s; text-decoration:none; width:calc(100% - 20px); background: #E30613; color: #fff;">
            <i class="fas fa-plus-circle" style="font-size: 1.1rem;"></i> NUEVO REGISTRO
        </a>

        <!-- Divider Programas -->
        <div class="list-group-item fw-bold text-uppercase py-2 d-flex align-items-center gap-2 mt-2 pi-sidebar-divider"
             style="font-size: 0.7rem; letter-spacing: 1.5px; border: none; padding-left: 16px;">
            <i class="fas fa-tv" style="color:#E30613;"></i> PROGRAMAS L-V
        </div>

        <!-- Lista de 12 programas -->
        <?php foreach($programas_pi as $prog):
            $url = './GetPiByProgramStationTest.php?Programa=' . urlencode($prog) . '&Station=' . $station . '&Date=' . $today;
        ?>
        <a href="<?= $url ?>" target="mainIframe"
           class="list-group-item list-group-item-action pi-prog-link"
           style="display:flex; align-items:center; padding:10px 20px; border:none; border-left:4px solid transparent; font-family:'Outfit',sans-serif; font-size:0.82rem; font-weight:700; text-decoration:none;">
            <i class="fas fa-play-circle me-3" style="font-size: 1.1rem; opacity: 0.8; flex-shrink:0;"></i>
            <span><?= htmlspecialchars($prog) ?></span>
        </a>
        <?php endforeach; ?>

        <!-- Safe area al final -->
        <div style="height: 100px; display: block;"></div>

    </div>
</div>

<style>
/* Estilos Profesionales para el Sidebar PI */
.pi-sidebar-body {
    background-color: var(--bs-body-bg);
}
.pi-sidebar-divider {
    background: transparent;
    color: #6c757d;
    opacity: 0.9;
    margin-top: 10px;
}
.pi-prog-link {
    background: transparent !important;
    border: none !important;
    border-left: 4px solid transparent !important;
    padding: 9px 20px !important;
    font-family: 'Outfit', sans-serif;
    font-size: 0.82rem !important;
    font-weight: 700 !important;
    color: var(--bs-body-color) !important;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: center;
}
.pi-prog-link:hover {
    background-color: rgba(227, 6, 19, 0.06) !important;
    color: #E30613 !important;
    border-left-color: #E30613 !important;
    padding-left: 24px !important;
}
.pi-btn-primary {
    background-color: rgba(0, 159, 227, 0.08);
    border: 1px solid rgba(0, 159, 227, 0.2);
    color: var(--bs-body-color);
}
.pi-btn-primary:hover {
    background-color: rgba(0, 159, 227, 0.15);
    border-color: #009FE3;
    color: #009FE3;
    transform: translateY(-2px);
}
.pi-btn-cta {
    background: #E30613;
    color: #fff;
    border: 1px solid rgba(255,255,255,0.1);
}
.pi-btn-cta:hover {
    background-color: #c2000d !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(227,6,19,0.3);
    color: #fff !important;
}

/* Modo Oscuro - Paleta de Colores Corporativa */
[data-bs-theme="dark"] .pi-prog-link { 
    color: #f8f9fa !important;
}
[data-bs-theme="dark"] .pi-prog-link:hover { 
    background-color: rgba(227, 6, 19, 0.15) !important;
    color: #ff4d4d !important;
}
</style>
