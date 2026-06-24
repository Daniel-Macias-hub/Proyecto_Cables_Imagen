<?php
if(!session_id()) session_start();
include_once('db.php');
$page_title = "Temas Especiales - Todos";
$query = "SELECT titulo, age, cat, fecha, hora, path, urge FROM cables WHERE cat LIKE '%-S-%' OR cat LIKE '%T%' ORDER BY fecha DESC, hora DESC LIMIT 100;";
include('layout/grid_template.php');
?>
