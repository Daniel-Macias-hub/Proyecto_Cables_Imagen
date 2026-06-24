<?php
if(!session_id()) session_start();
include_once('db.php');
$page_title = "Galería DPA — Economía";
$sql_query = "SELECT id,age,cat,tit,aut,fec,path,capt2 FROM fotos WHERE age='DPA' AND (cat LIKE '%eco%' OR cat LIKE '%fin%' OR cat LIKE '%neg%' OR tit LIKE '%econ%') ORDER BY fec DESC ";
include('layout/grid_fotos.php');
?>



