<?php
if(!session_id()) session_start();
include_once('db.php');
$title = isset($page_title) ? $page_title : "Galería Multimedia";

// ─── FILTERS FROM GET ────────────────────────────────────────────────
$filter_agency  = isset($_GET['filter_age'])  ? trim($_GET['filter_age'])  : '';
$filter_date    = isset($_GET['filter_date'])  ? trim($_GET['filter_date'])  : '';
$filter_hour    = isset($_GET['filter_hour'])  ? trim($_GET['filter_hour'])  : '';

// ─── PAGINATION ────────────────────────────────────────────────────────
$perPage = 40;
$page    = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset  = ($page - 1) * $perPage;

// ─── BUILD QUERY ───────────────────────────────────────────────────────
// Start from the base query provided by the caller file
if (!isset($sql_query)) {
    $base_query = "SELECT id,age,cat,tit,fec,path FROM fotos ORDER BY fec DESC";
} else {
    // Strip any trailing LIMIT already baked in
    $base_query = trim(preg_replace('/\s+LIMIT\s+\d+.*/i', '', $sql_query));
}

// Apply optional filters on top of the base query
$filter_clauses = array();
if (!empty($filter_agency)) {
    $safe_age = mysql_real_escape_string($filter_agency, $conn);
    $filter_clauses[] = "age='$safe_age'";
}
if (!empty($filter_date)) {
    $safe_date = mysql_real_escape_string($filter_date, $conn);
    $filter_clauses[] = "DATE(fec)='$safe_date'";
}
if (!empty($filter_hour)) {
    $filter_clauses[] = "HOUR(fec)=" . intval($filter_hour);
}

if (!empty($filter_clauses)) {
    if (stripos($base_query, ' WHERE ') !== false) {
        $base_query .= ' AND ' . implode(' AND ', $filter_clauses);
    } else {
        $base_query = preg_replace('/\s+ORDER\s+BY/i', ' WHERE ' . implode(' AND ', $filter_clauses) . ' ORDER BY', $base_query);
        if (stripos($base_query, ' WHERE ') === false) {
            $base_query .= ' WHERE ' . implode(' AND ', $filter_clauses);
        }
    }
}

// ─── COUNT TOTAL (reliable separate COUNT query) ───────────────────────
// Extract the WHERE clause from base_query to build a lean COUNT
$count_query = preg_replace('/^SELECT .+ FROM /i', 'SELECT COUNT(*) as total FROM ', $base_query);
// Remove the ORDER BY from count query for speed
$count_query = preg_replace('/\s+ORDER\s+BY.+$/i', '', $count_query);
$res_count    = @mysql_query($count_query, $conn);
$totalRecords = ($res_count && $row_c = mysql_fetch_assoc($res_count)) ? (int)$row_c['total'] : 0;
$totalPages   = ($totalRecords > 0) ? (int)ceil($totalRecords / $perPage) : 1;

// ─── DATA QUERY ────────────────────────────────────────────────────────
$sql_data = $base_query . " LIMIT $offset, $perPage";
$result   = @mysql_query($sql_data, $conn);
if (!$result) {
    error_log("GRID_FOTOS ERROR: " . mysql_error($conn) . " | Q: " . $sql_data);
}

// ─── BUILD FILTER URL HELPER ───────────────────────────────────────────
$base_url_params = $_GET;
unset($base_url_params['page']);
$base_url = '?' . http_build_query($base_url_params);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
    :root {
      --card-fg: #1a1a1a;
      --card-bg: #ffffff;
      --card-border: rgba(0,0,0,0.08);
      --filter-bg: #f1f3f5;
    }
    html[data-bs-theme="dark"] {
      --card-fg: #f0f0f0;
      --card-bg: #1e1e1e;
      --card-border: rgba(255,255,255,0.06);
      --filter-bg: #2a2a2a;
    }

    /* Body: natural flow — iframe handles the scroll */
    body {
      margin: 0;
      padding: 8px 14px 80px; /* Increased bottom padding for pagination clearance */
      font-family: 'Outfit', sans-serif;
      color: var(--card-fg);
      background: transparent;
      box-sizing: border-box;
    }

    /* ── FILTER BAR ── */
    .filter-bar {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      gap: 8px;
      padding: 10px 14px;
      background: var(--filter-bg);
      border-radius: 12px;
      margin-bottom: 16px;
      border: 1px solid var(--card-border);
    }
    .filter-bar label { font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #888; white-space: nowrap; }
    .filter-bar input, .filter-bar select {
      font-size: 0.85rem;
      padding: 5px 10px;
      border-radius: 8px;
      border: 1px solid var(--card-border);
      background: var(--card-bg);
      color: var(--card-fg);
      min-width: 0;
    }
    .filter-bar .btn-filter {
      background: #E30613; color: #fff; border: none;
      padding: 5px 16px; border-radius: 8px;
      font-size: 0.85rem; font-weight: 700; cursor: pointer;
      white-space: nowrap;
    }
    .filter-bar .btn-clear {
      background: transparent; color: #888; border: 1px solid var(--card-border);
      padding: 5px 12px; border-radius: 8px;
      font-size: 0.85rem; cursor: pointer;
      white-space: nowrap;
    }
    .filter-active-badge { background: rgba(227,6,19,0.1); color: #E30613; border: 1px solid rgba(227,6,19,0.2); padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; }

    /* ── GALLERY HEADER ── */
    .gallery-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; padding-bottom: 10px; border-bottom: 2px solid #E30613; }
    .gallery-header h3 { font-weight: 700; font-size: 1.3rem; color: #E30613; margin: 0; display: flex; align-items: center; gap: 8px; }
    .total-badge { background: rgba(227,6,19,0.1); color: #E30613; border: 1px solid rgba(227,6,19,0.2); padding: 4px 12px; border-radius: 20px; font-size: 0.82rem; font-weight: 700; }

    /* ── PHOTO GRID (5 cols) ── */
    .photo-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 1rem; }
    @media (max-width: 1100px) { .photo-grid { grid-template-columns: repeat(4, 1fr); } }
    @media (max-width: 900px)  { .photo-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 600px)  { .photo-grid { grid-template-columns: repeat(2, 1fr); } }

    /* ── PHOTO CARD ── */
    .photo-card {
      display: flex; flex-direction: column;
      background: var(--card-bg); border-radius: 10px;
      border: 1px solid var(--card-border); overflow: hidden;
      text-decoration: none !important; color: var(--card-fg);
      box-shadow: 0 2px 6px rgba(0,0,0,0.04);
      transition: transform 0.18s ease, box-shadow 0.18s ease;
      position: relative;
    }
    .photo-card:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.1); color: var(--card-fg); }
    .photo-card-img {
      width: 100%; height: 130px; object-fit: cover;
      border-bottom: 1px solid var(--card-border);
      background: #111;
    }
    /* Placeholder while image loads */
    .photo-card-img[src=""] { background: #222; }

    .photo-card-category {
      position: absolute; top: 8px; left: 8px;
      background: var(--agency-color, #333); color: #fff;
      font-size: 0.65rem; font-weight: 800;
      padding: 3px 8px; border-radius: 5px;
      text-transform: uppercase; letter-spacing: 0.5px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }
    .photo-card-body { padding: 10px 12px; flex-grow: 1; display: flex; flex-direction: column; }
    .photo-card-title {
      font-size: 0.88rem; font-weight: 600; margin: 0 0 8px;
      line-height: 1.3; color: var(--card-fg);
      display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;
    }
    .photo-card-meta { margin-top: auto; font-size: 0.75rem; color: #888; display: flex; gap: 10px; }

    /* ── PAGINATION ── */
    .pagination-bar {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-wrap: wrap;
      gap: 6px;
      margin-top: 14px;
      padding: 10px 0 8px;
      border-top: 2px solid #E30613;
    }
    .page-btn {
      padding: 4px 12px; border-radius: 7px;
      background: var(--card-bg); color: var(--card-fg);
      text-decoration: none; font-weight: 600; font-size: 0.82rem;
      border: 1px solid var(--card-border);
      transition: all 0.15s;
      white-space: nowrap;
    }
    .page-btn:hover, .page-btn.active { background: #E30613; color: #fff; border-color: #E30613; }
    .page-btn.disabled { opacity: 0.35; pointer-events: none; cursor: default; }
    .pag-info { color: var(--card-fg); font-size: 0.78rem; opacity: 0.5; padding: 0 6px; }
    </style>
</head>
<body>

<!-- ── FILTER BAR ── -->
<form method="GET" action="" class="filter-bar">
    <!-- Preserve caller-specific params (section, etc.) -->
    <?php foreach ($_GET as $k => $v): ?>
        <?php if (!in_array($k, ['filter_age','filter_date','filter_hour','page'])): ?>
            <input type="hidden" name="<?= htmlspecialchars($k) ?>" value="<?= htmlspecialchars($v) ?>">
        <?php endif; ?>
    <?php endforeach; ?>

    <label><i class="fas fa-filter me-1"></i>Filtros</label>

    <label>Agencia</label>
    <select name="filter_age">
        <option value="">Todas</option>
        <?php foreach (['AFP','RTR','DPA','NOTIMEX','AP'] as $ag): ?>
            <option value="<?= $ag ?>" <?= ($filter_agency === $ag) ? 'selected' : '' ?>><?= $ag ?></option>
        <?php endforeach; ?>
    </select>

    <label>Fecha</label>
    <input type="date" name="filter_date" value="<?= htmlspecialchars($filter_date) ?>" max="<?= date('Y-m-d') ?>">

    <label>Hora</label>
    <select name="filter_hour">
        <option value="">Cualquier hora</option>
        <?php for ($h = 0; $h < 24; $h++): ?>
            <option value="<?= $h ?>" <?= ($filter_hour !== '' && (int)$filter_hour === $h) ? 'selected' : '' ?>><?= sprintf('%02d:00', $h) ?></option>
        <?php endfor; ?>
    </select>

    <button type="submit" class="btn-filter"><i class="fas fa-search me-1"></i>Filtrar</button>
    <?php if (!empty($filter_agency) || !empty($filter_date) || $filter_hour !== ''): ?>
        <a href="<?= $base_url ?>" class="btn-clear"><i class="fas fa-times me-1"></i>Limpiar</a>
        <span class="filter-active-badge">Filtros activos</span>
    <?php endif; ?>
</form>

<!-- ── GALLERY HEADER ── -->
<div class="gallery-header">
    <h3><i class="fas fa-images"></i> <?= htmlspecialchars($title) ?></h3>
    <span class="total-badge">
        <?= number_format($totalRecords) ?> foto<?= $totalRecords !== 1 ? 's' : '' ?>
        &nbsp;·&nbsp; Pág. <?= $page ?> / <?= $totalPages ?>
    </span>
</div>

<?php
if (!$result || mysql_num_rows($result) == 0):
    $empty_state_text = "No se encontraron fotos<br>con los filtros seleccionados";
    include 'layout/empty_state.php';
else:
    echo "<div class='photo-grid'>";
    while ($row = mysql_fetch_assoc($result)) {
        $id   = (int)$row['id'];
        $age  = strtoupper(isset($row['age']) ? $row['age'] : 'N/A');
        $raw_tit = isset($row['tit']) ? $row['tit'] : (isset($row['titulo']) ? $row['titulo'] : 'Sin título');
        $tit  = htmlspecialchars($raw_tit);
        $path = isset($row['path']) ? $row['path'] : '';

        // Date / time
        if (!empty($row['fec'])) {
            $fecorta = substr($row['fec'], 0, 10);
            $hora    = substr($row['fec'], 11, 5);
        } else {
            $fecorta = isset($row['fecha']) ? $row['fecha'] : '';
            $hora    = isset($row['hora']) ? substr($row['hora'], 0, 5) : '';
        }

        // Agency colour
        $accentColor = '#555';
        $ageLabel    = $age;
        if ($age === 'AFP')                            { $accentColor = '#009FE3'; }
        if ($age === 'NOTIMEX' || $age === 'NTX')     { $accentColor = '#E30613'; $ageLabel = 'NTX'; }
        if ($age === 'REUTERS'  || $age === 'RTR')    { $accentColor = '#FF8000'; $ageLabel = 'RTR'; }
        if ($age === 'DPA')                            { $accentColor = '#00d1b2'; }
        if ($age === 'AP')                             { $accentColor = '#333'; }

        // Thumbnail via thumb.php (server-side resize → cache)
        if (!empty($path)) {
            $cleanPath = (strpos($path, '/') !== 0) ? '/' . ltrim($path, '/') : $path;
            $imgSrc    = 'thumb.php?src=' . urlencode($cleanPath) . '&w=280';
        } else {
            $imgSrc    = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='360' height='200' style='background:%23222'%3E%3Ctext x='50%25' y='50%25' fill='%23555' font-family='sans-serif' font-size='13' text-anchor='middle' dy='.35em'%3ESin imagen%3C/text%3E%3C/svg%3E";
        }

        $link = "text.php?action=ft&id=$id";

        echo "
        <a href='$link' class='photo-card' style='--agency-color:$accentColor;' target='mainIframe'>
          <div class='photo-card-category'>$ageLabel</div>
          <img src='$imgSrc' class='photo-card-img' alt='Foto' loading='lazy' decoding='async'>
          <div class='photo-card-body'>
            <p class='photo-card-title' title='$tit'>$tit</p>
            <div class='photo-card-meta'>
              <span><i class='fas fa-calendar-alt'></i> $fecorta</span>
              <span><i class='fas fa-clock'></i> $hora</span>
            </div>
          </div>
        </a>";
    }
    echo "</div>"; // close .photo-grid
endif;
?>

<!-- ── PAGINATION (fixed bottom, always visible) ── -->
<div class="pagination-bar">
    <?php
    function pageUrl($pg) {
        $p = $_GET;
        $p['page'] = $pg;
        return '?' . http_build_query($p);
    }

    // First + Prev
    if ($page > 1) {
        echo '<a href="'.pageUrl(1).'" class="page-btn" title="Primera página"><i class="fas fa-angles-left"></i></a>';
        echo '<a href="'.pageUrl($page-1).'" class="page-btn"><i class="fas fa-chevron-left"></i> Ant</a>';
    } else {
        echo '<span class="page-btn disabled"><i class="fas fa-angles-left"></i></span>';
        echo '<span class="page-btn disabled"><i class="fas fa-chevron-left"></i> Ant</span>';
    }

    // Numbered pages (window of 5)
    $start = max(1, $page - 2);
    $end   = min($totalPages, $page + 2);
    for ($i = $start; $i <= $end; $i++) {
        $cls = ($i === $page) ? 'active' : '';
        echo "<a href='".pageUrl($i)."' class='page-btn $cls'>$i</a>";
    }

    // Next + Last
    if ($page < $totalPages) {
        echo '<a href="'.pageUrl($page+1).'" class="page-btn">Sig <i class="fas fa-chevron-right"></i></a>';
        echo '<a href="'.pageUrl($totalPages).'" class="page-btn" title="Última página"><i class="fas fa-angles-right"></i></a>';
    } else {
        echo '<span class="page-btn disabled">Sig <i class="fas fa-chevron-right"></i></span>';
        echo '<span class="page-btn disabled"><i class="fas fa-angles-right"></i></span>';
    }
    ?>
    <span class="pag-info">
        P&aacute;g.&nbsp;<?php echo $page; ?>&nbsp;/&nbsp;<?php echo $totalPages; ?>
        &nbsp;&middot;&nbsp;<?php echo number_format($totalRecords); ?>&nbsp;fotos
    </span>
</div>

<script>
(function(){
    // Sync dark/light theme from parent iframe
    function syncTheme(){
        try {
            const t = localStorage.getItem('theme') ||
                (window.parent && window.parent.document.documentElement.getAttribute('data-bs-theme')) || 'light';
            document.documentElement.setAttribute('data-bs-theme', t);
        } catch(e){}
    }
    syncTheme();
    if (window.parent) {
        new MutationObserver(syncTheme)
            .observe(window.parent.document.documentElement, { attributes: true, attributeFilter: ['data-bs-theme'] });
    }
})();
</script>
</body>
</html>
