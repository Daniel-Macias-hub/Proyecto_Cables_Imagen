<?php
if(!session_id()) session_start();
include_once('db.php');
$page_title = "Galería de FNAPESP";
$sql_query = "SELECT id,age,cat,tit,aut,fec,path,capt2 FROM fotos WHERE age='NOTIMEX'  AND (tit LIKE '%esp%' OR tit LIKE '%cul%') ORDER BY fec DESC ";
include('layout/grid_fotos.php');
?>


