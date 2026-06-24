<?php
$page_title = "Últimos Cables Recibidos";
$query = "SELECT titulo, age, cat, fecha, hora, path, urge FROM cables ORDER BY fecha DESC, hora DESC LIMIT 150;";
include('layout/grid_template.php');
?>
