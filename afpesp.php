<?php
$page_title = "Cables AFPESP";
$query = "SELECT id,titulo,age,cat,fecha,hora,path FROM cables WHERE fecha = CURRENT_DATE ORDER BY hora DESC;";
include('layout/grid_template.php');
?>
