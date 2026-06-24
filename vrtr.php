<?php
if(!session_id()) session_start();
include_once('db.php');
$page_title = "Videos REUTERS";
$sql_query = "SELECT id,titulo,age,fecha,path,ext,hora,pathv FROM videos ORDER BY fecha DESC, hora DESC";
include('layout/grid_videos.php');
?>
