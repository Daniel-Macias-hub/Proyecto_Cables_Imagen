<?php
$page_title = "Cables AFPCUL";
$query = "SELECT titulo,age,cat,fecha,hora,path FROM cables WHERE cat='10' OR cat='08' OR cat ='05' AND age='AFP' ORDER BY fecha DESC,hora DESC ;";
include('layout/grid_template.php');
?>
