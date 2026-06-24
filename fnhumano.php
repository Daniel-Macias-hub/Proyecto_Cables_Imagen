<?php
if(!session_id()) session_start();
include_once('db.php');
$page_title = "Galería de FNHUMANO";
$sql_query = "SELECT id,age,cat,tit,aut,fec,path,capt2 FROM fotos WHERE age='NOTIMEX' and (capt2='HUM' or capt2='HTH' or capt2='REL' or capt2='LIF') ORDER BY fec DESC ";
include('layout/grid_fotos.php');
?>

