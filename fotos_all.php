<?php
if(!session_id()) session_start();
include_once('db.php');
$page_title = "Banco de Fotos - Todos";

// Corregimos los nombres de las columnas: 'tit' y 'fec' son las correctas para la tabla 'fotos'
$sql_query = "SELECT id, age, tit, fec, path FROM fotos ORDER BY fec DESC ";

include('layout/grid_fotos.php');
?>


