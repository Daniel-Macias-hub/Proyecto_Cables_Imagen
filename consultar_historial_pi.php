<?php
date_default_timezone_set('America/Mexico_City');

$station = 10000000001; // XEDA
$today = date('Y-m-d');
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : $today;
$orden = isset($_GET['orden']) ? $_GET['orden'] : 'programa_asc';
$busqueda_activa = isset($_GET['aplicar']);
$prog_filtro = isset($_GET['prog']) ? $_GET['prog'] : '';

$programas_oficiales = array(
    'Imagen Empresarial', 'Primera Emisión L-V', 'Qué tal Fernanda',
    'Qué tal Fernanda Lun-Vie', 'Segunda Emisión L-V', 'Palabra del Deporte',
    'Autos en Imagen', 'Negocios en Imagen', 'Tercera Emisión L-V',
    'Análisis Superior', 'En Directo Pue y Tlax', 'Programa Pagado (Neximo)'
);

$programas = [];
$error_db = '';

// Solo ejecutar si el usuario presionó APLICAR
if ($busqueda_activa) {
if (!mysql_connect("localhost", "root", "d1nosauri0Z")) {
    $error_db = "No se pudo conectar a la base de datos.";
} else {
    mysql_select_db("cdcol");
    mysql_query("set names 'utf8'");

    $fecha_safe = mysql_real_escape_string($fecha);
    if ($orden == 'programa_desc') {
        $order_sql = 'programa DESC';
    } elseif ($orden == 'hora') {
        $order_sql = 'fecha ASC';
    } else {
        $order_sql = 'programa ASC';
    }

    $sql = "SELECT id, idTR, Nombre, estacion, fecha, status, obs, hrt, client, rutamp3, trorden, siglas, programa
            FROM pi
            WHERE DATE(fecha) = '$fecha_safe'
            AND estacion = $station";

    if ($prog_filtro && in_array($prog_filtro, $programas_oficiales)) {
        $prog_esc = mysql_real_escape_string($prog_filtro);
        $sql .= " AND programa = '$prog_esc'";
    }

    $sql .= " ORDER BY $order_sql, fecha ASC";

    $r = mysql_query($sql);
    if ($r) {
        while ($row = mysql_fetch_assoc($r)) {
            $prog = $row['programa'];
            if(!isset($programas[$prog])) {
                $programas[$prog] = [];
            }
            $programas[$prog][] = $row;
        }
    } else {
        $error_db = "Error en consulta: " . mysql_error();
    }
}
} // fin del candado busqueda_activa
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Consultar Historial Pi</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --bg-color: #f4f5f7;
            --text-color: #1a1a1a;
            --details-bg: #ffffff;
            --details-border: rgba(0,0,0,0.1);
            --summary-bg: #f8f9fa;
            --corp-red: #E30613;
            --corp-blue: #009FE3;
            --record-bg: #ffffff;
            --record-border: rgba(0,0,0,0.05);
            --filter-bg: #ffffff;
        }
        [data-bs-theme="dark"] {
            --bg-color: #121212;
            --text-color: #e0e0e0;
            --details-bg: #1e1e1e;
            --details-border: rgba(255,255,255,0.05);
            --summary-bg: linear-gradient(135deg, #1a1a1a 0%, #222222 100%);
            --record-bg: #161616;
            --record-border: rgba(255,255,255,0.03);
            --filter-bg: #1a1a1a;
        }
        body {
            background: var(--bg-color);
            color: var(--text-color);
            font-family: 'Outfit', sans-serif;
            padding: 30px;
            min-height: 100vh;
        }
        
        .page-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid var(--corp-red);
        }
        .page-header h1 {
            font-size: 2rem;
            font-weight: 800;
            margin: 0;
            color: var(--text-color);
        }
        .page-header i { font-size: 2rem; color: var(--corp-red); }

        /* Filtros */
        .filters-bar {
            background: var(--filter-bg);
            border: 1px solid var(--details-border);
            border-radius: 12px;
            padding: 20px 24px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        }
        [data-bs-theme="dark"] .filters-bar { box-shadow: 0 4px 15px rgba(0,0,0,0.2); }
        .filters-bar form {
            display: flex;
            align-items: flex-end;
            gap: 20px;
            flex-wrap: wrap;
        }
        .filter-group { display: flex; flex-direction: column; gap: 8px; }
        .filter-group label {
            font-size: 0.8rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-color);
            opacity: 0.7;
        }
        .filter-input {
            background: var(--bg-color);
            border: 2px solid var(--details-border);
            border-radius: 8px;
            color: var(--text-color);
            font-family: 'Outfit', sans-serif;
            font-size: 1rem;
            padding: 10px 16px;
            min-width: 200px;
            outline: none;
            transition: border-color 0.2s;
        }
        .filter-input:focus { border-color: var(--corp-red); }
        
        .btn-apply {
            background: var(--corp-red);
            border: none;
            color: #fff;
            border-radius: 8px;
            padding: 12px 24px;
            font-family: 'Outfit', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 10px rgba(227,6,19,0.2);
        }
        .btn-apply:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(227,6,19,0.3); }

        /* Resultados header */
        .results-label {
            font-size: 1rem;
            font-weight: 800;
            margin-bottom: 20px;
            color: var(--text-color);
            opacity: 0.8;
        }
        .results-label span { color: var(--corp-red); background: rgba(227,6,19,0.1); padding: 4px 12px; border-radius: 6px; }

        /* ACORDEON MODERNO */
        .details {
            background: var(--details-bg);
            border: 1px solid var(--details-border);
            border-radius: 12px;
            margin-bottom: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        [data-bs-theme="dark"] .details { box-shadow: 0 4px 15px rgba(0,0,0,0.2); }
        
        .details__summary {
            padding: 20px 24px;
            font-size: 1.3rem;
            font-weight: 800;
            background: var(--summary-bg);
            cursor: pointer;
            list-style: none;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: var(--text-color);
            transition: all 0.2s;
        }
        .details__summary::-webkit-details-marker { display: none; }
        .details__summary::after {
            content: '\f107';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            color: var(--corp-red);
            font-size: 1.2rem;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .details[open] .details__summary::after { transform: rotate(180deg); }
        .details[open] .details__summary {
            border-bottom: 2px solid rgba(227,6,19,0.2);
            color: var(--corp-blue);
        }

        /* Animación calc-size */
        .details__content {
            height: 0;
            opacity: 0;
            overflow: hidden;
            transition: height 0.4s ease-out, opacity 0.4s ease-out, display 0.4s allow-discrete;
        }
        .details[open] .details__content {
            height: calc-size(auto, size);
            opacity: 1;
            padding: 24px;
        }
        @supports not (height: calc-size(auto, size)) {
            .details[open] .details__content { height: auto; }
        }

        /* DISEÑO DE REGISTROS (GRID CARD) */
        .record-grid { display: flex; flex-direction: column; gap: 12px; }
        .record-card {
            display: grid;
            grid-template-columns: 80px 2fr 1.5fr 1fr 1fr 2fr 100px;
            align-items: center;
            gap: 20px;
            background: var(--record-bg);
            border: 1px solid var(--record-border);
            border-radius: 10px;
            padding: 18px 24px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .record-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
            border-color: rgba(0, 159, 227, 0.3);
        }
        .record-col { display: flex; flex-direction: column; gap: 4px; }
        .col-label { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; opacity: 0.5; font-weight: 700; }
        .col-value { font-size: 1.05rem; font-weight: 600; line-height: 1.3; }
        
        .val-id { font-family: monospace; color: var(--corp-blue); font-size: 1.1rem; }
        .val-prod { color: var(--corp-blue); font-weight: 800; font-size: 1.15rem; }
        .val-status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 700;
            background: rgba(0,0,0,0.05);
            width: fit-content;
        }
        .val-status i { font-size: 1.25rem; }
        [data-bs-theme="dark"] .val-status { background: rgba(255,255,255,0.05); }
        .status-err { color: #dc3545; background: rgba(220,53,69,0.1) !important; }

        /* Actions */
        .actions-col { display: flex; gap: 14px; justify-content: flex-end; }
        .btn-action {
            width: 52px; height: 52px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            text-decoration: none;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid var(--details-border);
            color: inherit;
        }
        .btn-action.audio { background: var(--corp-red); color: white; }
        .btn-action.text { background: rgba(0,0,0,0.05); color: var(--corp-blue); }
        [data-bs-theme="dark"] .btn-action.text { background: rgba(255,255,255,0.05); color: #fff; }
        
        .btn-action:hover { 
            transform: scale(1.15); 
            box-shadow: 0 8px 20px rgba(227,6,19,0.25); 
            border-color: var(--corp-red);
            color: var(--corp-red) !important;
            filter: brightness(1.1);
        }
        .btn-action:active {
            transform: scale(0.9);
            box-shadow: 0 2px 5px rgba(227,6,19,0.2);
        }
        .btn-action.disabled { opacity: 0.2; pointer-events: none; filter: grayscale(1); }
        .svg-icon-i { width: 28px; height: 28px; fill: none; stroke: currentColor; stroke-width: 8; transition: all 0.2s; }
        .btn-action:hover .svg-icon-i { stroke: var(--corp-red); color: var(--corp-red); }

        @media(max-width: 1200px) {
            .record-card { grid-template-columns: 80px 1.5fr 1fr 1fr 100px; }
            .col-obs, .col-client { display: none; }
        }
        @media(max-width: 768px) {
            .record-card { grid-template-columns: 1fr; gap: 12px; padding: 15px; }
            .actions-col { justify-content: flex-start; margin-top: 10px; }
            .col-obs, .col-client { display: flex; }
            .details__content { padding: 15px; }
        }

        .empty-hist { text-align: center; padding: 60px; opacity: 0.5; }
        .empty-hist i { font-size: 3rem; margin-bottom: 15px; }
    </style>
    <script>
        function syncTheme() {
            const theme = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-bs-theme', theme);
        }
        syncTheme();
        window.addEventListener('storage', syncTheme);
    </script>
</head>
<body>

<div class="page-header">
    <i class="fas fa-history"></i>
    <div>
        <h1>Historial de Transmisiones</h1>
    </div>
</div>

<?php if ($error_db): ?>
    <div style="background: rgba(227,6,19,0.1); color: #E30613; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($error_db) ?>
    </div>
<?php endif; ?>

<!-- Filtros -->
<div class="filters-bar">
    <form method="get">
        <div class="filter-group">
            <label>Fecha de Consulta</label>
            <input type="date" name="fecha" value="<?= htmlspecialchars($fecha) ?>" class="filter-input">
        </div>
        <div class="filter-group">
            <label>Organizar por</label>
            <select name="orden" class="filter-input">
                <option value="programa_asc" <?= $orden == 'programa_asc' ? 'selected' : '' ?>>Alfabético (A - Z)</option>
                <option value="programa_desc" <?= $orden == 'programa_desc' ? 'selected' : '' ?>>Alfabético (Z - A)</option>
                <option value="hora" <?= $orden == 'hora' ? 'selected' : '' ?>>Hora Programada</option>
            </select>
        </div>
        <div class="filter-group">
            <label>Programa</label>
            <select name="prog" class="filter-input">
                <option value="">— Todos (12 oficiales) —</option>
                <?php foreach($programas_oficiales as $p): ?>
                <option value="<?php echo htmlspecialchars($p); ?>" <?php echo ($prog_filtro === $p) ? 'selected' : ''; ?>><?php echo htmlspecialchars($p); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <input type="hidden" name="aplicar" value="1">
        <button type="submit" class="btn-apply"><i class="fas fa-filter"></i> APLICAR</button>
    </form>
</div>

<?php
$fecha_parts = explode('-', $fecha);
$fecha_display = isset($fecha_parts[2]) ? $fecha_parts[2].'/'.$fecha_parts[1].'/'.$fecha_parts[0] : $fecha;
?>
<div class="results-label">
    Resultados para: <span><?= htmlspecialchars($fecha_display) ?></span>
</div>

<?php if (!$busqueda_activa): ?>
<div style="text-align:center; padding:80px 30px; opacity:0.7;">
    <i class="fas fa-search" style="font-size:3rem; color:var(--corp-red); margin-bottom:20px; display:block;"></i>
    <h2 style="font-size:1.3rem; font-weight:800; margin-bottom:10px;">Seleccione algún filtro para poder arrojar resultados</h2>
    <p style="font-size:0.95rem; color:var(--text-color); opacity:0.7;">Configure la Fecha y Orden, y presione <strong>"APLICAR"</strong> para mostrar resultados.</p>
</div>
<?php else: ?>

<?php if (empty($programas)): ?>
<div class="empty-hist">
    <i class="fas fa-calendar-times"></i>
    <h2>Sin registros</h2>
    <p>No hay transmisiones para la fecha seleccionada.</p>
</div>
<?php else: ?>
    <?php foreach ($programas as $prog_name => $records): ?>
        <details class="details" name="historial_acordeon">
            <summary class="details__summary">
                <div style="display:flex; align-items:center; gap:15px;">
                    <i class="fas fa-history" style="color:var(--corp-red); font-size:1.4rem;"></i>
                    <?= htmlspecialchars($prog_name) ?>
                    <span style="font-size: 0.8rem; font-weight: 600; padding: 4px 12px; background: rgba(0,159,227,0.1); color: var(--corp-blue); border-radius: 20px; margin-left: 10px;">
                        <?= count($records) ?> registros
                    </span>
                </div>
            </summary>
            
            <div class="details__content">
                <div class="record-grid">
                    <?php foreach($records as $item): 
                        $hasText = !empty($item['id']);
                        $hasAudio = !empty($item['rutamp3']) && strlen(trim($item['rutamp3'])) > 5;
                        $status = strtolower($item['status']);
                        $isError = (strpos($status, 'no ') !== false || strpos($status, 'cancel') !== false);
                    ?>
                        <div class="record-card">
                            <div class="record-col">
                                <span class="col-label">Orden</span>
                                <span class="col-value val-id">#<?= htmlspecialchars($item['id'] ?: $item['trorden']) ?></span>
                            </div>
                            <div class="record-col">
                                <span class="col-label">Producto</span>
                                <span class="col-value val-prod"><?= htmlspecialchars($item['idTR']) ?></span>
                            </div>
                            <div class="record-col col-client">
                                <span class="col-label">Cliente</span>
                                <span class="col-value"><?= htmlspecialchars($item['client'] ?: '---') ?></span>
                            </div>
                            <div class="record-col">
                                <span class="col-label">Hora Real</span>
                                <span class="col-value"><i class="far fa-clock" style="opacity:0.5; margin-right:4px;"></i><?= htmlspecialchars(substr($item['hrt'], 0, 5) ?: '--:--') ?></span>
                            </div>
                            <div class="record-col">
                                <span class="col-label">Estatus</span>
                                <span class="col-value val-status <?= $isError ? 'status-err' : '' ?>">
                                    <?php if($isError): ?><i class="fas fa-times-circle"></i>
                                    <?php elseif($hasAudio): ?><i class="fas fa-paperclip" style="color: var(--corp-blue);"></i><?php endif; ?>
                                    <?= htmlspecialchars($item['status']) ?>
                                </span>
                            </div>
                            <div class="record-col col-obs">
                                <span class="col-label">Observaciones</span>
                                <span class="col-value" style="font-size:0.95rem; opacity:0.8;"><?= htmlspecialchars($item['obs'] ?: 'Sin observaciones') ?></span>
                            </div>
                            <div class="actions-col">
                                <a href="text2.php?action=pi&id=<?= $item['id'] ?>&nom=<?= urlencode($item['idTR']) ?>" target="mainIframe" class="btn-action text <?= !$hasText ? 'disabled' : '' ?>" title="Ver Nota">
                                    <svg class="svg-icon-i" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="50" cy="50" r="45" />
                                        <circle cx="50" cy="32" r="7" fill="#E30613" stroke="none" />
                                        <rect x="44" y="48" width="12" height="28" rx="3" fill="currentColor" stroke="none" />
                                    </svg>
                                </a>
                                <a href="player.php?audio=<?= urlencode($item['rutamp3']) ?>&prog=<?= urlencode($prog_name) ?>" target="mainIframe" class="btn-action audio <?= !$hasAudio ? 'disabled' : '' ?>" title="Escuchar Audio">
                                    <i class="fas fa-headphones" style="font-size: 1.4rem;"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </details>
    <?php endforeach; ?>
<?php endif; ?>
<?php endif; // fin del candado busqueda_activa ?>

</body>
</html>
