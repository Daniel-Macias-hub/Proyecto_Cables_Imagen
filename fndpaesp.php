<?php
if(!session_id()) session_start();
include_once('db.php');
$page_title = "Galería de FNDPAESP";
$sql_query = "SELECT id,age,cat,tit,aut,fec,path,capt2 FROM fotos WHERE age='DPA' AND (capt2 = 'ACE' OR capt2 = 'HUM') ORDER BY fec DESC ";
include('layout/grid_fotos.php');
?>

