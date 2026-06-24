<?php
$page_title = "Cables AFPDES";
$query = "SELECT id,titulo,age,cat,fecha,hora,path FROM cables WHERE age='AFP' ORDER BY fecha DESC,hora DESC;";
include('layout/grid_template.php');
?>
