<?php
if(!session_id()) session_start();
include_once('db.php');
$page_title = "Galería de FNDPAINT";
$sql_query = "SELECT id,age,cat,tit,aut,fec,path,capt2 FROM fotos WHERE age='DPA' AND (capt2 = 'CLJ' OR capt2='WAR') ORDER BY fec DESC ";
include('layout/grid_fotos.php');
?>

