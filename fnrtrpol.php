<?php
if(!session_id()) session_start();
include_once('db.php');
$page_title = "Galería de FNRTRPOL";
$sql_query = "SELECT id,age,cat,tit,aut,fec,path,capt2 FROM fotos WHERE age='REUTERS' and cat='MCC:A' ORDER BY fec DESC ";
include('layout/grid_fotos.php');
?>

