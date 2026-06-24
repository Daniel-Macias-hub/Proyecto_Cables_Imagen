<?php
if(!session_id()) session_start();
include_once('db.php');
$page_title = "Galería de FNECOS";
$sql_query = "SELECT id,age,cat,tit,aut,fec,path,capt2 FROM fotos WHERE age='NOTIMEX' and capt2='EBF' ORDER BY fec DESC ";
include('layout/grid_fotos.php');
?>

