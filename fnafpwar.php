<?php
if(!session_id()) session_start();
include_once('db.php');
$page_title = "Galería de FNAFPWAR";
$sql_query = "SELECT id,age,cat,tit,aut,fec,path,capt2 FROM fotos WHERE age='AFP' AND capt2 = 'WAR' ORDER BY fec DESC ";
include('layout/grid_fotos.php');
?>

