<?php
if(!session_id()) session_start();
include_once('db.php');
$page_title = "Galería de FNRTRECO";
$sql_query = "SELECT id,age,cat,tit,aut,fec,path,capt2 FROM fotos WHERE age='REUTERS' and cat='N2:PIA' ORDER BY fec DESC ";
include('layout/grid_fotos.php');
?>

