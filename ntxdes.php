<?php
$page_title = "Cables NTXDES";
$query = "SELECT titulo, age, cat, fecha, hora, path, urge FROM cables WHERE age='NTX' ORDER BY fecha DESC, hora DESC LIMIT 150;";
include('layout/grid_template.php');
?>
