<?php
date_default_timezone_set('America/Mexico_City');
$today = date('Y-m-d');
$station = 10000000001;

// Array Maestro de los 12 programas en Orden Cronológico
$programas_pi = [
    'Imagen Empresarial',
    'Primera Emision L-V',
    'Que tal Fernanda',
    'Segunda Emisión L-V',
    'Bien y Saludable',
    'Palabra del Deporte',
    'Autos en Imagen',
    'Informativo Puebla L-V',
    'Tercera Emisión L-V',
    'Analisis Superior',
    'Programa Pagado (Neximo)',
    'Ya Cierra'
];
?>
<div class="col-lg-2 col-md-3 sidebar-column p-0 d-none d-md-flex flex-column">
    <div class="card shadow-sm border-0 h-100 d-flex flex-column bg-transparent">

        <!-- Header SISTEMA PI -->
        <div class="card-header pi-sidebar-header text-white fw-bold sticky-top d-flex align-items-center justify-content-between"
             style="font-family: 'Outfit', sans-serif; z-index: 10; height: 50px; padding: 0 18px; background: linear-gradient(135deg, #1a1a1a 0%, #333333 100%); border-bottom: 3px solid #E30613;">
            <span style="white-space: nowrap; font-size: 1rem; letter-spacing: 0.5px;">
                <i class="fas fa-broadcast-tower me-2" style="color:#E30613;"></i>SISTEMA PI
            </span>
        </div>

        <div class="list-group list-group-flush flex-grow-1 overflow-auto pi-sidebar-body" style="padding-bottom: 20px;">

            <!-- SECCIÓN ESTACIÓN -->
            <div class="list-group-item fw-bold text-uppercase py-2 d-flex align-items-center gap-2 pi-sidebar-divider"
                 style="font-size: 0.7rem; letter-spacing: 1.5px; border: none; padding-left: 16px; margin-top: 15px;">
                <i class="fas fa-satellite-dish" style="color:#E30613;"></i> ACCIONES GENERALES
            </div>

            <!-- XEDA Pauta Completa -->
            <a href="programas.php?dateT=<?= $today ?>&station=10000000001" target="mainIframe"
               class="list-group-item list-group-item-action d-flex align-items-center gap-2 pi-btn-primary"
               style="border-radius:6px; margin:4px 10px; padding:12px 14px; font-family:'Outfit',sans-serif; font-size:0.85rem; font-weight:700; letter-spacing:0.3px; transition:all 0.2s; text-decoration:none; width:calc(100% - 20px);">
                <i class="fas fa-list-alt" style="font-size: 1.1rem; color: #009FE3;"></i> XEDA Pauta Completa
            </a>

            <!-- Nuevo Registro -->
            <a href="nuevo.php?action=pi&id=0000000&nom=9999999" target="mainIframe"
               class="list-group-item list-group-item-action d-flex align-items-center gap-2 pi-btn-cta"
               style="border-radius:6px; margin:4px 10px; padding:12px 14px; font-family:'Outfit',sans-serif; font-size:0.85rem; font-weight:700; letter-spacing:0.3px; transition:all 0.2s; text-decoration:none; width:calc(100% - 20px); background: #E30613; color: #fff;">
                <i class="fas fa-plus-circle" style="font-size: 1.1rem;"></i> NUEVO REGISTRO
            </a>

            <!-- Consultar Historial -->
            <a href="consultar_historial_pi.php" target="mainIframe"
               class="list-group-item list-group-item-action d-flex align-items-center gap-2 pi-btn-secondary"
               style="border-radius:6px; margin:4px 10px; padding:12px 14px; font-family:'Outfit',sans-serif; font-size:0.85rem; font-weight:700; letter-spacing:0.3px; transition:all 0.2s; text-decoration:none; width:calc(100% - 20px);">
                <i class="fas fa-history" style="font-size: 1.1rem; color:#E30613;"></i> HISTORIAL
            </a>

            <!-- Divider Programas -->
            <div class="list-group-item fw-bold text-uppercase py-2 d-flex align-items-center gap-2 mt-3 pi-sidebar-divider"
                 style="font-size: 0.7rem; letter-spacing: 1.5px; border: none; padding-left: 16px;">
                <i class="fas fa-tv" style="color:#E30613;"></i> PROGRAMAS L-V
            </div>

            <?php foreach($programas_pi as $prog): 
                $url = 'GetPiByProgramStation.php?Programa=' . urlencode($prog) . '&Station=' . $station . '&Date=' . $today;
            ?>
            <a href="<?= $url ?>" target="mainIframe"
               class="list-group-item list-group-item-action pi-prog-link">
                <i class="fas fa-play-circle me-3" style="font-size: 1.2rem; opacity: 0.8;"></i>
                <span style="flex-grow: 1;"><?= htmlspecialchars($prog) ?></span>
            </a>
            <?php endforeach; ?>

        </div>
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
    padding: 14px 20px !important;
    font-family: 'Outfit', sans-serif;
    font-size: 16px !important;
    font-weight: 700 !important;
    color: #343a40 !important;
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
.pi-btn-secondary {
    background-color: rgba(var(--bs-tertiary-bg-rgb), 0.5);
    border: 1px solid rgba(var(--bs-border-color-rgb), 0.1);
    color: var(--bs-body-color);
}
.pi-btn-secondary:hover {
    border-color: #E30613;
    color: #E30613;
    transform: translateY(-2px);
}
.pi-btn-cta:hover {
    background-color: #c2000d !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(227,6,19,0.3);
}

/* Modo Oscuro - Paleta de Colores Corporativa */
[data-bs-theme="dark"] .pi-prog-link { 
    color: #f8f9fa !important; /* Blanco puro para máxima legibilidad */
}
[data-bs-theme="dark"] .pi-prog-link:hover { 
    background-color: rgba(227, 6, 19, 0.15) !important;
    color: #ff4d4d !important; /* Rojo corporativo más vibrante en oscuro */
}
[data-bs-theme="dark"] .pi-sidebar-body { 
    background-color: #1a1e21; /* Gris azulado profundo */
}
[data-bs-theme="dark"] .pi-sidebar-divider {
    color: #adb5bd;
}
</style>
