<?php
// API para Autocompletado (Sugerencias de Búsqueda)
header('Content-Type: application/json');

if(!session_id()) session_start();
include_once('db.php');

$q = isset($_GET['q']) ? trim($_GET['q']) : '';

if (strlen($q) < 3) {
    echo json_encode([]);
    exit;
}

$safe_q = mysql_real_escape_string($q, $conn);
$suggestions = [];

// Buscar Cables
$query_cables = "SELECT titulo, path, age FROM cables WHERE titulo LIKE '%$safe_q%' ORDER BY fecha DESC, hora DESC LIMIT 5";
$r_cables = mysql_query($query_cables, $conn);
if ($r_cables) {
    while($row = mysql_fetch_array($r_cables)) {
        $suggestions[] = [
            'type' => 'cable',
            'title' => $row['titulo'], // Quitamos la doble conversion
            'agency' => $row['age'],
            'url' => "visor.php?path=" . urlencode($row['path'])
        ];
    }
}

// Buscar Videos
$query_videos = "SELECT titulo, ext, id FROM videos WHERE titulo LIKE '%$safe_q%' ORDER BY fecha DESC LIMIT 2";
$r_videos = mysql_query($query_videos, $conn);
if ($r_videos) {
    while($row = mysql_fetch_array($r_videos)) {
        $suggestions[] = [
            'type' => 'video',
            'title' => $row['titulo'],
            'agency' => $row['ext'],
            'url' => "text.php?action=vid&id=" . urlencode($row['id'])
        ];
    }
}

// Devolver resultados
echo json_encode($suggestions);
?>
