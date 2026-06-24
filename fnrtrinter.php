<?php
if(!session_id()) session_start();
include_once('db.php');
$page_title = "Galería de FNRTRINTER";
$sql_query = "SELECT id,age,cat,tit,aut,fec,path,capt2 FROM fotos WHERE age='REUTERS' and (cat='MCC:I' OR cat='N2:CWP') ORDER BY fec DESC ";
include('layout/grid_fotos.php');
?>

