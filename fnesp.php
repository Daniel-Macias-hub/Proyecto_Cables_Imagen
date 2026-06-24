<?php
if(!session_id()) session_start();
include_once('db.php');
$page_title = "Galería de FNESP";
$sql_query = "SELECT id,age,cat,tit,aut,fec,path,capt2 FROM fotos WHERE age='NOTIMEX' AND (cat='  ACE' OR cat='  HUM') ORDER BY fec DESC ";
include('layout/grid_fotos.php');
?>

