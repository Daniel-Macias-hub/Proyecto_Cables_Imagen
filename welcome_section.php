<?php
if(!session_id()) session_start();
include_once('db.php');

$sec = isset($_GET['sec']) ? strtolower(trim($_GET['sec'])) : 'cables';

// ─── SECTION METADATA ────────────────────────────────────────────────────
$sections = array(
    'cables'  => array('title' => 'Bienvenido a Cables', 'icon' => 'fas fa-file-alt',         'color' => '#E30613'),
    'fotos'   => array('title' => 'Bienvenido a Fotos',  'icon' => 'fas fa-camera-retro',   'color' => '#009FE3'),
    'video'   => array('title' => 'Bienvenido a Video',  'icon' => 'fas fa-video',           'color' => '#E30613'),
    'temas'   => array('title' => 'Bienvenido a X-Temas','icon' => 'fas fa-hashtag',         'color' => '#f7941d'),
    'turbina' => array('title' => 'Bienvenido a Turbina','icon' => 'fas fa-bolt',             'color' => '#FFC107'),
    'pi'      => array('title' => 'Bienvenido a Pi',     'icon' => 'fas fa-broadcast-tower', 'color' => '#009FE3'),
    'prueba'  => array('title' => 'Bienvenido a Prueba', 'icon' => 'fas fa-vial',            'color' => '#6c757d'),
    'k4'      => array('title' => 'Bienvenido a K4',     'icon' => 'fas fa-server',          'color' => '#8b5cf6'),
);

$meta  = isset($sections[$sec]) ? $sections[$sec] : $sections['cables'];
$title = $meta['title'];
$icon  = $meta['icon'];
$color = $meta['color'];

// ─── LIVE COUNTERS ────────────────────────────────────────────────────────
$counters  = array();
$has_stats = false;

// Helper: safe count query
function safeCount($conn, $sql) {
    $r = @mysql_query($sql, $conn);
    if ($r && $row = mysql_fetch_assoc($r)) return (int)$row['t'];
    return 0;
}

function agencyCountFotos($conn, $age) {
    return safeCount($conn, "SELECT COUNT(*) as t FROM fotos WHERE age='$age' AND fec >= CURDATE()");
}

function agencyCountCables($conn, $age, $extra = '') {
    return safeCount($conn, "SELECT COUNT(*) as t FROM cables WHERE age='$age' $extra AND fecha >= CURDATE()");
}

if ($sec === 'fotos') {
    $has_stats = true;
    $counters['total'] = safeCount($conn, "SELECT COUNT(*) as t FROM fotos WHERE fec >= CURDATE()");
    $counters['noun']  = 'Fotografía';
    $counters['nounp'] = 'Fotografías';
    $counters['chips'] = array(
        array('label' => 'AFP',  'val' => agencyCountFotos($conn,'AFP'),     'cls' => 'afp'),
        array('label' => 'RTR',  'val' => agencyCountFotos($conn,'RTR'),     'cls' => 'rtr'),
        array('label' => 'DPA',  'val' => agencyCountFotos($conn,'DPA'),     'cls' => 'dpa'),
        array('label' => 'NTX',  'val' => agencyCountFotos($conn,'NOTIMEX'), 'cls' => 'ntx'),
        array('label' => 'AP',   'val' => agencyCountFotos($conn,'AP'),      'cls' => 'ap'),
    );
}

if ($sec === 'video') {
    $has_stats = true;
    $counters['total'] = safeCount($conn, "SELECT COUNT(*) as t FROM cables WHERE cat='video' AND fecha >= CURDATE()");
    $counters['noun']  = 'Video';
    $counters['nounp'] = 'Videos';
    $counters['chips'] = array(
        array('label' => 'AFP',  'val' => agencyCountCables($conn,'AFP',"AND cat='video'"),     'cls' => 'afp'),
        array('label' => 'RTR',  'val' => agencyCountCables($conn,'RTR',"AND cat='video'"),     'cls' => 'rtr'),
        array('label' => 'NTX',  'val' => agencyCountCables($conn,'NOTIMEX',"AND cat='video'"), 'cls' => 'ntx'),
    );
}

if ($sec === 'cables') {
    $has_stats = true;
    $counters['total'] = safeCount($conn, "SELECT COUNT(*) as t FROM cables WHERE fecha >= CURDATE()");
    $counters['noun']  = 'Cable';
    $counters['nounp'] = 'Cables';
    $counters['chips'] = array(
        array('label' => 'AFP',  'val' => agencyCountCables($conn,'AFP'),     'cls' => 'afp'),
        array('label' => 'RTR',  'val' => agencyCountCables($conn,'RTR'),     'cls' => 'rtr'),
        array('label' => 'DPA',  'val' => agencyCountCables($conn,'DPA'),     'cls' => 'dpa'),
        array('label' => 'NTX',  'val' => agencyCountCables($conn,'NOTIMEX'), 'cls' => 'ntx'),
        array('label' => 'AP',   'val' => agencyCountCables($conn,'AP'),      'cls' => 'ap'),
    );
}

if ($sec === 'temas') {
    // X-Temas no tiene tabla propia — no se muestran contadores
    $has_stats = false;
}

if ($sec === 'turbina') {
    // Turbina no tiene tabla propia — no se muestran contadores
    $has_stats = false;
}

if ($sec === 'pi') {
    $has_stats = true;
    $r_pi = @mysql_query("SELECT COUNT(*) as t FROM pi WHERE fec >= CURDATE()", $conn);
    $pi_total = ($r_pi && $row_pi = mysql_fetch_assoc($r_pi)) ? (int)$row_pi['t'] : 0;
    $counters['total'] = $pi_total;
    $counters['noun']  = 'Elemento Pi';
    $counters['nounp'] = 'Elementos Pi';
    $counters['chips'] = array();
}

if ($sec === 'prueba') {
    $has_stats = true;
    $counters['total'] = safeCount($conn, "SELECT COUNT(*) as t FROM cables WHERE fecha >= CURDATE()");
    $counters['noun']  = 'Registro';
    $counters['nounp'] = 'Registros en Sistema';
    $counters['chips'] = array(
        array('label' => 'Fotos', 'val' => safeCount($conn,"SELECT COUNT(*) as t FROM fotos WHERE fec >= CURDATE()"), 'cls' => 'afp'),
        array('label' => 'Cables','val' => safeCount($conn,"SELECT COUNT(*) as t FROM cables WHERE fecha >= CURDATE()"), 'cls' => 'rtr'),
    );
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800;900&display=swap" rel="stylesheet">
    <style>
    :root {
        --bg: #f8f9fa; --text: #1a1a1a; --muted: #666;
        --card: #ffffff; --border: rgba(0,0,0,0.07);
        --stat-bg: rgba(0,0,0,0.03);
        --gimm-scale: 1;
    }
    @media (min-width: 1400px) { :root { --gimm-scale: 1.1; } }
    @media (min-width: 1900px) { :root { --gimm-scale: 1.25; } }
    
    html { font-size: calc(16px * var(--gimm-scale)); }

    html[data-bs-theme="dark"] {
        --bg: #0a0a0a; --text: #ffffff; --muted: #888;
        --card: #141414; --border: rgba(255,255,255,0.06);
        --stat-bg: rgba(255,255,255,0.04);
    }
    body {
        background: var(--bg); color: var(--text);
        font-family: 'Outfit', sans-serif;
        min-height: 100vh; margin: 0;
        display: flex; align-items: center; justify-content: center;
        overflow: hidden;
        font-size: 1rem;
    }
    .welcome-container {
        text-align: center; background: var(--card);
        padding: 36px 56px; border-radius: 24px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.08);
        border: 1px solid var(--border);
        display: flex; flex-direction: column;
        align-items: center; gap: 18px;
        max-width: 580px; width: 92%;
        animation: slideUp 0.7s cubic-bezier(0.16,1,0.3,1) both;
    }
    html[data-bs-theme="dark"] .welcome-container { box-shadow: 0 20px 60px rgba(0,0,0,0.55); }
    @keyframes slideUp { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

    /* ── Logo ── */
    .logo-container { display: flex; align-items: center; gap: 10px; }
    .logo-icon { display: flex; flex-direction: column; gap: 4px; }
    .logo-dot  { width: 13px; height: 13px; background: #009FE3; border-radius: 50%; }
    .logo-body { width: 13px; height: 17px; background: #E30613; border-radius: 2px; }
    .logo-text { display: flex; flex-direction: column; align-items: flex-start; line-height: 0.9; }
    .logo-text-top    { font-family: 'Arial Black', Impact, sans-serif; font-size: 22px; font-weight: 900; letter-spacing: -0.5px; }
    .logo-text-bottom { font-size: 10px; font-weight: 600; letter-spacing: 2px; color: var(--muted); }

    /* ── Section icon ── */
    .section-icon-wrapper {
        width: 84px; height: 84px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 2.4rem;
        position: relative;
    }
    .section-icon-wrapper::after {
        content: ''; position: absolute; inset: -10px; border-radius: 50%;
        animation: spin 14s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    h1 {
        font-size: 2rem; font-weight: 800; margin: 0; letter-spacing: -0.8px;
        background: linear-gradient(135deg, var(--text) 0%, var(--muted) 100%);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }
    p.instruction { color: var(--muted); font-size: 0.95rem; max-width: 340px; line-height: 1.5; margin: 0; }

    /* ── Stats panel ── */
    .stats-panel {
        width: 100%; background: var(--stat-bg);
        border-radius: 14px; padding: 14px 18px;
        border: 1px solid var(--border);
        animation: slideUp 0.9s cubic-bezier(0.16,1,0.3,1) both;
        animation-delay: 0.15s;
    }
    .stats-label {
        font-size: 0.68rem; text-transform: uppercase; letter-spacing: 1.5px;
        color: var(--muted); font-weight: 700; margin-bottom: 8px;
        display: flex; align-items: center; gap: 6px;
    }
    .live-dot {
        width: 7px; height: 7px; border-radius: 50%;
        background: #22c55e; box-shadow: 0 0 6px #22c55e;
        animation: pulse 2s infinite; flex-shrink: 0;
    }
    @keyframes pulse { 0%,100%{opacity:1;} 50%{opacity:0.3;} }
    .stats-total {
        font-size: 1.6rem; font-weight: 800; margin-bottom: 10px;
    }
    .agency-chips { display: flex; flex-wrap: wrap; gap: 7px; justify-content: center; }
    .chip {
        padding: 4px 13px; border-radius: 20px;
        font-size: 0.78rem; font-weight: 700;
        border: 1px solid currentColor; opacity: 0.9;
    }
    .chip-afp { color: #009FE3; }
    .chip-rtr { color: #FF8000; }
    .chip-ntx { color: #E30613; }
    .chip-dpa { color: #00d1b2; }
    .chip-ap  { color: #888; }

    /* ── Arrow hint ── */
    .arrow-indicator {
        color: var(--muted); font-size: 0.78rem; font-weight: 600;
        letter-spacing: 1px; text-transform: uppercase;
        display: flex; align-items: center; gap: 8px;
        animation: bounceL 2s infinite;
    }
    @keyframes bounceL { 0%,100%{transform:translateX(0);} 40%{transform:translateX(-8px);} }

    /* Dynamic section color applied via inline style on parent */
    </style>
</head>
<body style="position: relative;">

<div class="welcome-container">

    <!-- Logo Imagen TV -->
    <div class="logo-container">
        <div class="logo-icon">
            <div class="logo-dot"></div>
            <div class="logo-body"></div>
        </div>
        <div class="logo-text">
            <div class="logo-text-top">IMAGEN</div>
            <div class="logo-text-bottom">TELEVISIÓN</div>
        </div>
    </div>

    <!-- Section icon with dynamic color -->
    <div class="section-icon-wrapper" style="background:<?php echo $color; ?>18; color:<?php echo $color; ?>; box-shadow: 0 0 28px <?php echo $color; ?>22;">
        <style>.section-icon-wrapper::after { border: 2px dashed <?php echo $color; ?>45; }</style>
        <i class="<?php echo $icon; ?>"></i>
    </div>

    <!-- Title -->
    <h1><?php echo htmlspecialchars($title); ?></h1>

    <!-- Live counter stats panel -->
    <?php if ($has_stats && isset($counters['total'])): ?>
    <div class="stats-panel">
        <div class="stats-label">
            <span class="live-dot"></span>
            Publicado en las últimas 24 horas
        </div>
        <div class="stats-total" style="color: <?php echo $color; ?>">
            <?php
            $t = $counters['total'];
            $noun = ($t === 1) ? $counters['noun'] : $counters['nounp'];
            echo number_format($t) . ' ' . $noun;
            ?>
        </div>
        <?php if (!empty($counters['chips'])): ?>
        <div class="agency-chips">
            <?php foreach ($counters['chips'] as $chip): ?>
                <span class="chip chip-<?php echo $chip['cls']; ?>">
                    <i class="fas fa-circle" style="font-size:0.45rem;vertical-align:middle;margin-right:4px;"></i>
                    <?php echo $chip['label']; ?> <?php echo number_format($chip['val']); ?>
                </span>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- Instruction -->
    <p class="instruction">Selecciona una categoría en el menú lateral para comenzar.</p>

    <!-- Arrow hint -->
    <div class="arrow-indicator">
        <i class="fas fa-arrow-left"></i>
        <span>Usa el menú lateral</span>
    </div>

</div>

<script>
(function(){
    function syncTheme(){
        try {
            var t = localStorage.getItem('theme') ||
                (window.parent && window.parent.document.documentElement.getAttribute('data-bs-theme')) || 'dark';
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
