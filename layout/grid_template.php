<?php
if(!session_id()) session_start();
if(!isset($_SESSION['server'])) {
    $_SESSION['server'] = "http://10.29.128.198";
}
$server = $_SESSION['server'];

// Conexión temprana necesaria para sanitización de filtros
include_once(dirname(__FILE__) . '/../db.php');

// --- INTELLIGENT SQL OVERRIDE ---
// Para solucionar el problema de consultas globales en cada archivo, interceptamos aquí
$script_name = basename($_SERVER['SCRIPT_NAME'], '.php');
$sql_agency = '';
$sql_keywords = [];

// 1. Determinar Agencia
if (strpos($script_name, 'afp') === 0 || strpos($script_name, 'fnafp') === 0 || $script_name == 'vafpdes' || $script_name == 'fafpdes') $sql_agency = 'AFP';
elseif (strpos($script_name, 'rtr') === 0 || strpos($script_name, 'fnrtr') === 0 || $script_name == 'frtrdes' || $script_name == 'vrtr') $sql_agency = 'RTR';
elseif (strpos($script_name, 'ntx') === 0) $sql_agency = 'NTX';
elseif (strpos($script_name, 'ap') === 0 && strpos($script_name, 'afp') === false) $sql_agency = 'AP';
elseif (strpos($script_name, 'dpa') === 0 || strpos($script_name, 'fndpa') === 0) $sql_agency = 'DPA';

// 2. Determinar Categoría (Palabras Clave)
if (strpos($script_name, 'dep') !== false) {
    $sql_keywords = ['deporte', 'sport', 'futbol', 'liga', 'nba', 'mlb', 'tenis', 'campeonato', 'torneo', 'atleta', 'SPO', 'R S', '3 s'];
} elseif (strpos($script_name, 'eco') !== false || strpos($script_name, 'neg') !== false) {
    $sql_keywords = ['econ', 'finan', 'negocios', 'mercado', 'bolsa', 'dólar', 'peso', 'inflación', 'banco', 'OEC', 'R F', '4 e'];
} elseif (strpos($script_name, 'esp') !== false || strpos($script_name, 'cul') !== false) {
    $sql_keywords = ['espectáculo', 'cultura', 'cine', 'música', 'arte', 'actor', 'actriz', 'show', 'concierto', 'ESP', 'R W', 'R E', '4 s'];
} elseif (strpos($script_name, 'int') !== false || strpos($script_name, 'mun') !== false) {
    $sql_keywords = ['internacional', 'mundo', 'global', 'exterior', 'OVR', 'R I', 'R V'];
} elseif (strpos($script_name, 'pol') !== false) {
    $sql_keywords = ['politic', 'gobierno', 'elecciones', 'congreso', 'presidente', 'diputado', 'senador'];
} elseif (strpos($script_name, 'cli') !== false) {
    $sql_keywords = ['clima', 'tiempo', 'meteorol', 'huracán', 'tormenta', 'R O'];
} elseif (strpos($script_name, 'met') !== false) {
    $sql_keywords = ['metrópoli', 'cdmx', 'ciudad de méxico', 'R D'];
} elseif (strpos($script_name, 'nac') !== false) {
    $sql_keywords = ['nacional', 'república', 'R A'];
} elseif (strpos($script_name, 'edos') !== false) {
    $sql_keywords = ['estado', 'provincia', 'R N'];
} elseif (strpos($script_name, 'tec') !== false) {
    $sql_keywords = ['tecnolog', 'ciencia', 'científic', 'espacio', 'digital'];
} elseif (strpos($script_name, 'seg') !== false || strpos($script_name, 'jus') !== false || strpos($script_name, 'fin') !== false) {
    // Nota: AFP usa afpfin para policia y justicia
    $sql_keywords = ['seguridad', 'justicia', 'policía', 'crimen', 'corte', 'juez', 'fiscal'];
} elseif (strpos($script_name, 'elect') !== false) {
    $sql_keywords = ['electoral', 'elección', 'voto', 'ine'];
}

// 3. Sobrescribir $query si estamos en un script de agencia
if ($script_name != 'ini' && $script_name != 'urgentes' && !empty($sql_agency)) {
    // Rango de fechas: por defecto últimos 7 días
    $date_from = isset($_GET['date_from']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET['date_from']) ? $_GET['date_from'] : date('Y-m-d', strtotime('-6 days'));
    $date_to   = isset($_GET['date_to'])   && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET['date_to'])   ? $_GET['date_to']   : date('Y-m-d');
    // Whitelist para agencia: solo valores conocidos
    $allowed_agencies = array('AFP','RTR','NTX','AP','DPA');
    $filt_age_raw = isset($_GET['filt_age']) ? strtoupper(trim($_GET['filt_age'])) : $sql_agency;
    $filt_age = in_array($filt_age_raw, $allowed_agencies) ? $filt_age_raw : $sql_agency;

    // Sección: elimina caracteres peligrosos sin necesitar conexión DB
    $filt_sec_raw = isset($_GET['filt_sec']) ? $_GET['filt_sec'] : '';
    $filt_sec = preg_replace("/['\";\\\\%_<>]/", '', substr(trim($filt_sec_raw), 0, 80));

    // filt_ord se resuelve via order_map abajo; esta línea ya no construye el ORDER BY

    $where_sql = "WHERE fecha BETWEEN '$date_from' AND '$date_to' AND age = '$filt_age'";

    // Filtro por sección via GET sobrescribe keywords
    if (!empty($filt_sec)) {
        $where_sql .= " AND (titulo LIKE '%$filt_sec%' OR cat LIKE '%$filt_sec%')";
    } elseif (!empty($sql_keywords)) {
        $likes = [];
        foreach ($sql_keywords as $kw) {
            $likes[] = "titulo LIKE '%$kw%' OR cat LIKE '%$kw%'";
        }
        $where_sql .= " AND (" . implode(' OR ', $likes) . ")";
    }

    // Mapa de orden: fecha DESC siempre como clave primaria para evitar mezcla de días
    $order_map = array(
        'reciente'  => 'fecha DESC, hora DESC',
        'antiguo'   => 'fecha ASC, hora ASC',
        'titulo_az' => 'titulo ASC',
        'titulo_za' => 'titulo DESC',
    );
    $filt_ord_key = isset($_GET['filt_ord']) && array_key_exists($_GET['filt_ord'], $order_map) ? $_GET['filt_ord'] : 'reciente';
    $order_sql    = $order_map[$filt_ord_key];

    $query = "SELECT id,titulo,age,cat,fecha,hora,path FROM cables $where_sql ORDER BY $order_sql;";

    // Exponer variables para el formulario de filtros
    $filter_context = array(
        'agency'   => $filt_age,
        'date_from'=> $date_from,
        'date_to'  => $date_to,
        'filt_sec' => $filt_sec,
        'filt_ord' => $filt_ord_key,
    );
}
// --- FIN INTELLIGENT SQL OVERRIDE ---
if (!isset($filter_context)) {
    $filter_context = array(
        'agency'   => '',
        'date_from'=> date('Y-m-d', strtotime('-6 days')),
        'date_to'  => date('Y-m-d'),
        'filt_sec' => '',
        'filt_ord' => 'reciente',
    );
}

// Usamos la nueva conexión DRY (ya incluida al inicio para sanitización)
// include_once('db.php'); // << ya se incluyó arriba

// Título de la página que puede ser sobreescrito
if (!isset($page_title)) $page_title = "Cables Recibidos";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --imagen-red: #E30613; }
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background-color: transparent;
            font-family: 'Segoe UI', Roboto, sans-serif;
            height: 100vh;
            overflow: hidden;
        }

        /* ===== LAYOUT DIVIDIDO ===== */
        .split-view {
            display: flex;
            height: 100vh;
            width: 100%;
        }

        /* -- Panel izquierdo: Lista -- */
        .list-panel {
            width: 35%;
            height: 100%;
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(128,128,128,0.15);
            transition: width 0.3s ease;
        }
        .list-panel.full-width { width: 100%; }

        .list-panel-header {
            padding: 10px 16px;
            border-bottom: 1px solid rgba(128,128,128,0.15);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
            gap: 8px;
        }
        .list-panel-header h5 {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            color: var(--imagen-red);
            margin: 0;
            font-size: 1rem;
            white-space: nowrap;
        }
        .header-actions { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
        .action-btn {
            font-size: 0.75rem;
            background: none;
            border: 1px solid rgba(128,128,128,0.3);
            border-radius: 20px;
            padding: 4px 12px;
            cursor: pointer;
            transition: all 0.2s;
            color: inherit;
            font-family: 'Outfit', sans-serif;
            white-space: nowrap;
        }
        .action-btn:hover { border-color: var(--imagen-red); color: var(--imagen-red); }
        .action-btn.pause-active {
            background: rgba(220,53,69,0.12);
            border-color: #dc3545;
            color: #dc3545;
        }
        /* Panel de filtros */
        .filter-bar {
            padding: 10px 16px;
            border-bottom: 2px solid var(--imagen-red);
            display: none;
            flex-wrap: wrap;
            gap: 8px;
            align-items: flex-end;
            background: rgba(227,6,19,0.03);
        }
        .filter-bar.open { display: flex; }
        .filter-bar label { font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #888; display: block; margin-bottom: 3px; }
        .filter-bar input, .filter-bar select {
            font-size: 0.78rem;
            border: 1px solid rgba(128,128,128,0.25);
            border-radius: 8px;
            padding: 5px 8px;
            background: transparent;
            color: inherit;
            font-family: 'Outfit', sans-serif;
            outline: none;
            width: 100%;
        }
        .filter-bar input:focus, .filter-bar select:focus { border-color: var(--imagen-red); }
        .filter-group { min-width: 110px; flex: 1; }
        .filter-group-wide { min-width: 140px; flex: 2; }
        .btn-apply-filter {
            padding: 6px 18px;
            background: var(--imagen-red);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 0.78rem;
            font-weight: 700;
            cursor: pointer;
            font-family: 'Outfit', sans-serif;
            transition: filter 0.2s;
            white-space: nowrap;
            align-self: flex-end;
        }
        .btn-apply-filter:hover { filter: brightness(1.15); }
        .btn-reset-filter {
            padding: 6px 12px;
            background: transparent;
            color: inherit;
            border: 1px solid rgba(128,128,128,0.3);
            border-radius: 8px;
            font-size: 0.75rem;
            cursor: pointer;
            font-family: 'Outfit', sans-serif;
            white-space: nowrap;
            align-self: flex-end;
        }
        .counter-badge {
            font-size: 0.7rem;
            background: rgba(0,0,0,0.08);
            padding: 2px 8px;
            border-radius: 20px;
            font-family: 'Outfit', sans-serif;
            white-space: nowrap;
        }
        html[data-bs-theme="dark"] .counter-badge { background: rgba(255,255,255,0.08); }

        /* -- Tabla de cables -- */
        .cables-scroll {
            flex: 1;
            overflow-y: auto;
            scrollbar-width: thin;
        }
        .cables-scroll::-webkit-scrollbar { width: 4px; }
        .cables-scroll::-webkit-scrollbar-thumb { background: rgba(128,128,128,0.3); border-radius: 2px; }

        table { width: 100%; border-collapse: collapse; }
        thead th {
            position: sticky;
            top: 0;
            z-index: 10;
            padding: 10px 14px;
            font-size: 0.75rem;
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background: #1a1a1a;
            color: #ccc;
            border-bottom: 2px solid var(--imagen-red);
        }
        html[data-bs-theme="light"] thead th {
            background: #f4f4f4;
            color: #555;
        }

        tbody tr {
            cursor: pointer;
            transition: background 0.15s;
            border-bottom: 1px solid rgba(128,128,128,0.08);
        }
        tbody tr:hover { background: rgba(227,6,19,0.06) !important; }
        tbody tr.active-row { background: rgba(227,6,19,0.12) !important; border-left: 3px solid var(--imagen-red); }

        td { padding: 9px 14px; font-size: 0.88rem; vertical-align: middle; }

        /* Colores de urgencia mejorados */
        .row-urge-3 { background: rgba(227, 6, 19, 0.08) !important; border-left: 5px solid #e30613 !important; }
        .row-urge-2 { background: rgba(255, 128, 0, 0.08) !important; border-left: 5px solid #ff8000 !important; }
        .row-urge-1 { background: rgba(255, 215, 0, 0.12) !important; border-left: 5px solid #ffd700 !important; }

        html[data-bs-theme="dark"] .row-urge-3 { background: rgba(227, 6, 19, 0.18) !important; }
        html[data-bs-theme="dark"] .row-urge-2 { background: rgba(255, 128, 0, 0.18) !important; }
        html[data-bs-theme="dark"] .row-urge-1 { background: rgba(255, 215, 0, 0.18) !important; }

        /* Insignias */
        .agency-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 5px;
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-family: 'Outfit', sans-serif;
        }
        .bg-afp { background: #009fe3; color: #fff; }
        .bg-rtr { background: #333; color: #fff; border: 1px solid #555; }
        .bg-ntx { background: var(--imagen-red); color: #fff; }
        .bg-ap  { background: #000; color: #fff; border: 1px solid #444; }
        .bg-dpa { background: #f7941d; color: #fff; }
        .bg-gen { background: #555; color: #fff; }

        .cable-title { 
            font-weight: 700; 
            color: #222; 
            line-height: 1.4; 
            font-size: 0.95rem;
            margin-bottom: 2px;
        }
        html[data-bs-theme="dark"] .cable-title { color: #f0f0f0; }
        
        .cable-cat { font-size: 0.72rem; color: #777; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        
        .cable-date { 
            font-size: 0.8rem; 
            text-align: right; 
            color: #666; 
            white-space: nowrap; 
            font-family: 'Outfit', sans-serif;
        }
        .cable-date strong { 
            display: block; 
            color: #222; 
            font-size: 0.88rem; 
            font-weight: 700; 
            margin-bottom: 2px;
        }
        html[data-bs-theme="dark"] .cable-date strong { color: #ddd; }

        /* -- Panel derecho: Visor de nota -- */
        .note-panel {
            width: 65%;
            height: 100%;
            display: none;
            flex-direction: column;
            position: relative;
        }
        .note-panel.visible { display: flex; }

        .note-panel-header {
            padding: 8px 14px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            border-bottom: 1px solid rgba(128,128,128,0.15);
            flex-shrink: 0;
        }
        .close-note-btn {
            background: none;
            border: 1px solid rgba(128,128,128,0.3);
            border-radius: 20px;
            padding: 4px 14px;
            font-size: 0.78rem;
            cursor: pointer;
            color: inherit;
            font-family: 'Outfit', sans-serif;
            transition: all 0.2s;
        }
        .close-note-btn:hover { background: var(--imagen-red); border-color: var(--imagen-red); color: #fff; }

        #note-iframe {
            flex: 1;
            width: 100%;
            border: none;
        }

        /* Sin cables */
        .no-cables { padding: 40px; text-align: center; color: #888; font-size: 0.9rem; }
    </style>
</head>
<body>

<div class="split-view">

    <!-- ===== PANEL IZQUIERDO: LISTA ===== -->
    <div class="list-panel full-width" id="list-panel">
        <div class="list-panel-header">
            <h5><span style="color:var(--imagen-red)">●</span> &nbsp;<?= htmlspecialchars($page_title) ?>
                <?php if (!empty($filter_context['filt_sec']) || $filter_context['date_from'] != date('Y-m-d', strtotime('-6 days'))): ?>
                <span style="font-size:0.65rem; background:rgba(227,6,19,0.12); color:var(--imagen-red); border-radius:10px; padding:2px 8px; margin-left:6px; vertical-align:middle; font-weight:600;">FILTRADO</span>
                <?php endif; ?>
            </h5>
            <div class="header-actions">
                <span class="counter-badge" id="cables-counter"></span>
                <button class="action-btn" id="btn-filters" onclick="toggleFilters()" title="Filtros de búsqueda">
                    ⚙ Filtros
                </button>
                <button class="action-btn" id="btn-pause" onclick="toggleRefresh()" title="Pausa el auto-refresh para no perder el cable que estás leyendo">
                    ⏸ Pausar
                </button>
                <button class="action-btn" onclick="window.location.reload()" title="Recargar ahora">
                    ↻ Refrescar
                </button>
            </div>
        </div>
        <!-- Panel de Filtros -->
        <form class="filter-bar" id="filter-bar" method="GET" action="">
            <div class="filter-group">
                <label>Desde</label>
                <input type="date" name="date_from" value="<?= htmlspecialchars($filter_context['date_from']) ?>" max="<?= date('Y-m-d') ?>">
            </div>
            <div class="filter-group">
                <label>Hasta</label>
                <input type="date" name="date_to" value="<?= htmlspecialchars($filter_context['date_to']) ?>" max="<?= date('Y-m-d') ?>">
            </div>
            <div class="filter-group">
                <label>Sección / Palabra</label>
                <input type="text" name="filt_sec" placeholder="ej: econom, deport..." value="<?= htmlspecialchars($filter_context['filt_sec']) ?>">
            </div>
            <div class="filter-group">
                <label>Orden</label>
                <select name="filt_ord">
                    <option value="reciente"<?= $filter_context['filt_ord'] == 'reciente' ? ' selected' : '' ?>>Más reciente primero</option>
                    <option value="antiguo"<?= $filter_context['filt_ord'] == 'antiguo'   ? ' selected' : '' ?>>Más antiguo primero</option>
                    <option value="titulo_az"<?= $filter_context['filt_ord'] == 'titulo_az' ? ' selected' : '' ?>>Título A–Z</option>
                    <option value="titulo_za"<?= $filter_context['filt_ord'] == 'titulo_za' ? ' selected' : '' ?>>Título Z–A</option>
                </select>
            </div>
            <?php if (!empty($filter_context['agency'])): ?>
            <input type="hidden" name="filt_age" value="<?= htmlspecialchars($filter_context['agency']) ?>">
            <?php endif; ?>
            <button type="submit" class="btn-apply-filter">🔍 Aplicar</button>
            <button type="button" class="btn-reset-filter" onclick="window.location.href=window.location.pathname">✕ Limpiar</button>
        </form>

        <?php
        $result = null;
        $num_rows = 0;
        $query_error = "";
        if (!isset($query) || empty($query)) {
            $query_error = "Error: Consulta no definida.";
        } else {
            $result = mysql_query($query, $conn);
            if (!$result) {
                $query_error = "Error en la base de datos: " . mysql_error();
            } else {
                $num_rows = mysql_num_rows($result);
            }
        }
        ?>

        <div class="cables-scroll" <?= ($num_rows == 0) ? 'style="display:flex; align-items:center; justify-content:center;"' : '' ?>>
            <?php if ($num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th style="width:44px;">Ag.</th>
                        <th>Título del Cable</th>
                        <th style="width:145px;">Fecha y Hora</th>
                    </tr>
                </thead>
                <tbody>
            <?php else: ?>
            <table style="height: 100%; border: none;">
                <tbody>
            <?php endif; ?>
<?php
if ($query_error) {
    echo "<tr><td colspan='3' class='no-cables text-danger'>$query_error</td></tr>";
} elseif ($num_rows == 0) {
    echo "<tr><td style='padding: 0; border: none;'>";
    $empty_state_text = "Por el momento no se encuentran cables<br>disponibles en esta categoría";
    include 'empty_state.php';
    echo "</td></tr>";
    } else {
        while ($row = mysql_fetch_array($result)) {
            $path   = isset($row['path'])   ? $row['path']   : '';
            $age    = isset($row['age'])    ? strtoupper($row['age']) : 'N/A';
            $titulo = isset($row['titulo']) ? $row['titulo'] : 'Sin Título';
            $cat    = isset($row['cat'])    ? $row['cat']    : '';
            $fecha  = isset($row['fecha'])  ? $row['fecha']  : '';
            $hora   = isset($row['hora'])   ? $row['hora']   : '';
            $urge   = isset($row['urge'])   ? $row['urge']   : '';

            $urgeClass = '';
            if ($urge == '3')      $urgeClass = 'row-urge-3';
            elseif ($urge == '2')  $urgeClass = 'row-urge-2';
            elseif ($urge == '1')  $urgeClass = 'row-urge-1';

            $logoHtml = '';
            if ($age == 'AFP') { 
                $logoHtml = "
                <svg viewBox=\"0 0 120 50\" width=\"65\" height=\"28\" style=\"filter: drop-shadow(0px 2px 3px rgba(0,0,0,0.2));\">
                  <rect width=\"120\" height=\"50\" fill=\"#0072b9\" rx=\"6\" />
                  <text x=\"60\" y=\"37\" font-family=\"'Arial Black', Impact, sans-serif\" font-size=\"36\" font-weight=\"900\" font-style=\"italic\" fill=\"#ffffff\" text-anchor=\"middle\" letter-spacing=\"-1.5\">AFP</text>
                </svg>";
            } elseif (in_array($age, ['RTR','REUTERS'])) { 
                $logoHtml = "
                <div style='display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 3px;'>
                  <svg viewBox=\"0 0 100 100\" width=\"28\" height=\"28\">
                    <g fill=\"#f08100\">
                      <circle cx=\"50\" cy=\"50\" r=\"6\"/>
                      <circle cx=\"50\" cy=\"30\" r=\"4.5\"/><circle cx=\"50\" cy=\"70\" r=\"4.5\"/>
                      <circle cx=\"30\" cy=\"50\" r=\"4.5\"/><circle cx=\"70\" cy=\"50\" r=\"4.5\"/>
                      <circle cx=\"36\" cy=\"36\" r=\"4.5\"/><circle cx=\"64\" cy=\"64\" r=\"4.5\"/>
                      <circle cx=\"36\" cy=\"64\" r=\"4.5\"/><circle cx=\"64\" cy=\"36\" r=\"4.5\"/>
                      <circle cx=\"50\" cy=\"14\" r=\"5.5\"/><circle cx=\"50\" cy=\"86\" r=\"5.5\"/>
                      <circle cx=\"14\" cy=\"50\" r=\"5.5\"/><circle cx=\"86\" cy=\"50\" r=\"5.5\"/>
                      <circle cx=\"24\" cy=\"24\" r=\"5.5\"/><circle cx=\"76\" cy=\"76\" r=\"5.5\"/>
                      <circle cx=\"24\" cy=\"76\" r=\"5.5\"/><circle cx=\"76\" cy=\"24\" r=\"5.5\"/>
                    </g>
                  </svg>
                  <div style='font-family: Arial, sans-serif; font-size: 10px; font-weight: 800; color: #555; letter-spacing: 0.5px;'>REUTERS</div>
                </div>";
            } elseif ($age == 'NTX') { 
                $logoHtml = "
                <div style='display: flex; flex-direction: column; align-items: center;'>
                  <svg viewBox=\"0 0 160 60\" width=\"65\" height=\"24\">
                    <text x=\"0\" y=\"48\" font-family=\"'Arial Black', Impact, sans-serif\" font-size=\"60\" font-weight=\"900\" fill=\"#cc141d\" letter-spacing=\"-3\">NTX</text>
                    <circle cx=\"124\" cy=\"30\" r=\"7\" fill=\"#cc141d\"/>
                    <path d=\"M 124 16 A 14 14 0 0 1 124 44\" stroke=\"#cc141d\" stroke-width=\"4.5\" fill=\"none\" stroke-linecap=\"round\"/>
                    <path d=\"M 124 4 A 26 26 0 0 1 124 56\" stroke=\"#cc141d\" stroke-width=\"4.5\" fill=\"none\" stroke-linecap=\"round\"/>
                  </svg>
                  <div style='font-family: \"Arial Black\", Arial, sans-serif; font-size: 9px; font-weight: 900; color: #555; letter-spacing: 1px; margin-top: 1px;'>NOTIMEX</div>
                </div>";
            } elseif ($age == 'AP')  { 
                $logoHtml = "
                <div style='display: flex; flex-direction: column; align-items: center;'>
                  <svg viewBox=\"0 0 100 60\" width=\"42\" height=\"25\">
                    <text x=\"50\" y=\"55\" font-family=\"'Times New Roman', Times, serif\" font-size=\"68\" font-weight=\"bold\" fill=\"#e31837\" text-anchor=\"middle\" letter-spacing=\"-4\">AP</text>
                  </svg>
                  <div style='font-family: \"Arial Black\", Impact, sans-serif; font-size: 7.5px; font-weight: 900; color: #000; letter-spacing: 0px; margin-top: -2px;'>Associated Press</div>
                </div>";
            } elseif ($age == 'DPA') { 
                $logoHtml = "
                <div style='display: flex; align-items: center; justify-content: center; padding-bottom: 4px;'>
                  <span style='font-family: \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 32px; font-weight: 800; color: #00d1b2; letter-spacing: -2px; line-height: 1;'>dpa</span>
                  <div style='display: flex; margin-left: 5px; gap: 3px; margin-top: 5px;'>
                    <span style='width: 7px; height: 7px; background-color: #00d1b2; border-radius: 50%;'></span>
                    <span style='width: 7px; height: 7px; background-color: #00d1b2; border-radius: 50%;'></span>
                    <span style='width: 7px; height: 7px; background-color: #00d1b2; border-radius: 50%;'></span>
                  </div>
                </div>";
            } else {
                $logoHtml = "<div style='background:#555; color:white; font-family:Arial, sans-serif; font-weight:bold; padding:4px 8px; border-radius:3px; font-size:12px; text-align:center;'>$age</div>";
            }

            $safe_path  = htmlspecialchars($path, ENT_QUOTES);
            $safe_titulo = htmlspecialchars($titulo);
            $safe_cat   = htmlspecialchars($cat);

            echo "<tr class=\"$urgeClass\" data-path=\"$safe_path\" onclick=\"openNote(this)\">";
            echo "  <td class='text-center' style='vertical-align: middle; padding: 12px 10px; width: 100px;'>";
            echo "    <div style='display:flex; justify-content:center;'>$logoHtml</div>";
            echo "  </td>";
            echo "  <td style='padding: 12px 14px;'>";
            echo "    <div class='cable-title'>$safe_titulo</div>";
            if (!empty($safe_cat)) echo "    <div class='cable-cat'>$safe_cat</div>";
            echo "  </td>";
            echo "  <td class='cable-date'><strong>$fecha</strong>$hora</td>";
            echo "</tr>";
        }
    }
?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ===== PANEL DERECHO: VISOR DE NOTA ===== -->
    <div class="note-panel" id="note-panel">
        <div class="note-panel-header">
            <button class="close-note-btn" onclick="closeNote()">✕ Cerrar Nota</button>
        </div>
        <iframe id="note-iframe" src="" title="Cable"></iframe>
    </div>

</div>

<script>
const listPanel  = document.getElementById("list-panel");
const notePanel  = document.getElementById("note-panel");
const noteIframe = document.getElementById("note-iframe");

function openNote(row) {
    const path = row.getAttribute("data-path");
    if (!path) return;

    // Marcar fila activa
    document.querySelectorAll("tbody tr").forEach(r => r.classList.remove("active-row"));
    row.classList.add("active-row");

    // Cargar el contenido en el iframe
    noteIframe.src = "visor.php?path=" + encodeURIComponent(path);

    // Mostrar la vista dividida
    listPanel.classList.remove("full-width");
    notePanel.classList.add("visible");
}

function closeNote() {
    // Volver a la lista completa
    listPanel.classList.add("full-width");
    notePanel.classList.remove("visible");
    noteIframe.src = "";
    document.querySelectorAll("tbody tr").forEach(r => r.classList.remove("active-row"));
}

// Sincronización de tema con el padre
function syncTheme() {
    try {
        const t = localStorage.getItem('theme') ||
                  (window.parent && window.parent.document.documentElement.getAttribute('data-bs-theme')) ||
                  'light';
        document.documentElement.setAttribute('data-bs-theme', t);
    } catch(e) {}
}
syncTheme();
if (window.parent) {
    new MutationObserver(() => syncTheme())
        .observe(window.parent.document.documentElement, { attributes: true });
}

// ===== AUTO-REFRESH CON PAUSA =====
let refreshInterval = null;
let refreshPaused = false;
const REFRESH_MS = 90000;

function startRefresh() {
    if (refreshInterval) clearInterval(refreshInterval);
    refreshInterval = setInterval(() => {
        if (!refreshPaused) window.location.reload();
    }, REFRESH_MS);
}

function toggleRefresh() {
    refreshPaused = !refreshPaused;
    const btn = document.getElementById('btn-pause');
    if (refreshPaused) {
        btn.textContent = '▶ Reanudar';
        btn.classList.add('pause-active');
        btn.title = 'Auto-refresh pausado. La página no se recargará automáticamente.';
    } else {
        btn.textContent = '⏸ Pausar';
        btn.classList.remove('pause-active');
        btn.title = 'Pausa el auto-refresh para no perder el cable que estás leyendo';
    }
}

function toggleFilters() {
    const bar = document.getElementById('filter-bar');
    const btn = document.getElementById('btn-filters');
    bar.classList.toggle('open');
    btn.style.borderColor = bar.classList.contains('open') ? 'var(--imagen-red)' : '';
    btn.style.color       = bar.classList.contains('open') ? 'var(--imagen-red)' : '';
}

// Mostrar filtros si hay parámetros activos en la URL
(function() {
    const params = new URLSearchParams(window.location.search);
    if (params.has('filt_sec') || params.has('date_from') || params.has('date_to') || params.has('filt_ord')) {
        document.getElementById('filter-bar').classList.add('open');
    }
})();

// Contador de resultados en el header
(function() {
    const rows = document.querySelectorAll('tbody tr');
    const counter = document.getElementById('cables-counter');
    if (counter && rows.length > 0) {
        counter.textContent = rows.length + ' cables';
    }
})();

startRefresh();
</script>

</body>
</html>
