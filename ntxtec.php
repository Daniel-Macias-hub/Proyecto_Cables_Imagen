<?php
$page_title = "Cables NTX - Tecnología";
$query = "SELECT titulo, age, cat, fecha, hora, path, urge FROM cables WHERE age='NTX' AND cat='Tecnologia' ORDER BY fecha DESC, hora DESC LIMIT 150";
include('layout/grid_template.php');
?>
