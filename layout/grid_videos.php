<?php
if(!session_id()) session_start();
include_once('db.php');

$perPage = 20;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $perPage;

$title = isset($page_title) ? $page_title : "Archivo de Videos";

$totalRecords = 0;
if (!isset($sql_query)) {
    $sql_count = "SELECT COUNT(*) as total FROM cables WHERE cat='video'";
    $res_count = @mysql_query($sql_count, $conn);
    if ($res_count && $row_count = mysql_fetch_assoc($res_count)) {
        $totalRecords = isset($row_count['total']) ? $row_count['total'] : 0;
    }
    $sql_data  = "SELECT id, age, titulo, fecha, hora, path FROM cables WHERE cat='video' ORDER BY fecha DESC, hora DESC LIMIT $offset, $perPage";
} else {
    // Bypass the heavy COUNT(*) query completely to speed up loading
    $totalRecords = 200;
    
    // Clean any existing LIMIT from the extracted query to prevent SQL syntax errors
    $base_query = preg_replace('/(?i)\s*LIMIT\s+\d+/', '', $sql_query);
    
    // Append pagination LIMIT to the specific query
    $sql_data = $base_query . " LIMIT $offset, $perPage";
}

$result_data = mysql_query($sql_data, $conn);
$totalPages = ceil($totalRecords / $perPage);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
    :root { --card-bg: #ffffff; --text: #1a1a1a; --border: rgba(0,0,0,0.08); }
    html[data-bs-theme="dark"] { --card-bg: #1a1d21; --text: #f0f0f0; --border: rgba(255,255,255,0.05); }
    body { background: transparent; padding: 20px; font-family: 'Outfit', sans-serif; color: var(--text); }
    .gallery-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; border-bottom: 2px solid #E30613; padding-bottom: 10px; }
    .video-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem; }
    .video-card { background: var(--card-bg); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; text-decoration: none !important; color: inherit; transition: transform 0.2s; display: flex; flex-direction: column; height: 100%; position: relative; }
    .video-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); color: inherit; }
    .thumb-wrapper { position: relative; width: 100%; aspect-ratio: 16/9; background: #000; display: flex; align-items: center; justify-content: center; }
    .video-thumb { width: 100%; height: 100%; object-fit: cover; opacity: 0.8; }
    .play-btn { position: absolute; font-size: 2.5rem; color: #fff; z-index: 2; opacity: 0.8; }
    .agency-tag { position: absolute; top: 10px; left: 10px; background: var(--ag-color, #333); color: #fff; font-size: 0.65rem; font-weight: 800; padding: 3px 8px; border-radius: 4px; z-index: 3; }
    .card-body { padding: 12px; flex-grow: 1; }
    .card-title { font-size: 0.9rem; font-weight: 600; margin-bottom: 8px; line-height: 1.3; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
    .card-meta { font-size: 0.75rem; color: #888; display: flex; gap: 10px; }
    .pagination-bar { display: flex; justify-content: center; align-items: center; gap: 8px; margin-top: 30px; padding: 20px 0; border-top: 1px solid var(--border); }
    .page-btn { padding: 8px 16px; border-radius: 8px; border: 1px solid var(--border); background: var(--card-bg); color: var(--text); text-decoration: none; font-weight: 600; font-size: 0.85rem; }
    .page-btn:hover, .page-btn.active { background: #E30613; color: #fff; border-color: #E30613; }
    .page-btn.disabled { opacity: 0.4; pointer-events: none; }
    </style>
</head>
<body>
<div class="gallery-header">
    <h3 class="m-0" style="color: #E30613; font-weight: 700;"><i class="fas fa-video me-2"></i> <?= htmlspecialchars($title) ?></h3>
    <span class="badge bg-danger rounded-pill">Total: <?= $totalRecords ?></span>
</div>
<?php
if (!$result_data || mysql_num_rows($result_data) == 0) {
    $empty_state_text = "Por el momento no se encuentran videos<br>disponibles en esta categoría";
    include 'layout/empty_state.php';
} else {
    echo '<div class="video-grid">';
    while ($row = mysql_fetch_array($result_data)) {
        $age = strtoupper($row['age']);
        $agColor = '#555';
        if($age == 'AFP') $agColor = '#009fe3';
        if($age == 'NTX' || $age == 'NOTIMEX') $agColor = '#e30613';
        if($age == 'RTR' || $age == 'REUTERS') $agColor = '#f08100';
        $path = $row['path'];
        if (strpos($path, '/') !== 0) $path = '/' . ltrim($path, '/');
        $thumb = "thumb.php?src=" . urlencode(str_replace("/foto", "/afpv", $path)) . "&w=400";
        echo "
        <a href='text.php?action=vid&id={$row['id']}' class='video-card' style='--ag-color: $agColor;' target='contentFrame'>
            <div class='agency-tag'>$age</div>
            <div class='thumb-wrapper'>
                <img src='$thumb' class='video-thumb' loading='lazy'>
                <div class='play-btn'><i class='fas fa-play-circle'></i></div>
            </div>
            <div class='card-body'>
                <h4 class='card-title'>".htmlspecialchars($row['titulo'])."</h4>
                <div class='card-meta'>
                    <span><i class='far fa-calendar-alt'></i> {$row['fecha']}</span>
                    <span><i class='far fa-clock'></i> " . substr($row['hora'], 0, 5) . "</span>
                </div>
            </div>
        </a>";
    }
    echo '</div>';
}
?>
<?php if ($totalPages > 1): ?>
<div class="pagination-bar">
    <a href="?section=video&page=1" class="page-btn <?= ($page <= 1) ? 'disabled' : '' ?>"><i class="fas fa-angles-left"></i></a>
    <?php
    for ($i = max(1, $page-2); $i <= min($totalPages, $page+2); $i++) {
        $active = ($i == $page) ? 'active' : '';
        echo "<a href='?section=video&page=$i' class='page-btn $active'>$i</a>";
    }
    ?>
    <a href="?section=video&page=<?= $totalPages ?>" class="page-btn <?= ($page >= $totalPages) ? 'disabled' : '' ?>"><i class="fas fa-angles-right"></i></a>
</div>
<?php endif; ?>
<script>
function syncTheme() {
    const t = localStorage.getItem('theme') || (window.parent && window.parent.document.documentElement.getAttribute('data-bs-theme')) || 'light';
    document.documentElement.setAttribute('data-bs-theme', t);
}
syncTheme();
if(window.parent) { new MutationObserver(() => syncTheme()).observe(window.parent.document.documentElement, { attributes: true }); }
</script>
</body>
</html>
