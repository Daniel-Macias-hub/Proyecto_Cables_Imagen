<?php
if(!session_id()) session_start();
include_once('db.php');
$page_title = "Galería de FNFUTBOL";
$sql_query = "SELECT id,age,cat,tit,aut,fec,path,capt2 FROM fotos WHERE age='NOTIMEX' and cat=' FUTBOL ' ORDER BY fec DESC ";
include('layout/grid_fotos.php');
?>

