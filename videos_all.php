<?php
if(!session_id()) session_start();
include_once('db.php');
$page_title = "Archivo de Videos - Todos";

// Consulta base para videos
$sql_query = "SELECT id, age, titulo, fecha, hora, path FROM cables WHERE cat='video' ORDER BY fecha DESC, hora DESC";

include('layout/grid_videos.php');
?>
