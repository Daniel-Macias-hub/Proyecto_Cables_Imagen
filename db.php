<?php
$host   = "localhost";
$user   = "root";
$pass   = "d1nosauri0Z";
$dbname = "cdcol";

$conn = @mysql_connect($host, $user, $pass);
if(!$conn) {
    echo "<div style='background:#f8d7da; color:#721c24; padding:15px; border-radius:5px;'>";
    echo "<h2>Error crítico: No se pudo conectar a la base de datos.</h2>";
    echo "Contacta a Sistemas: Ext. 9096 | it@gimm.com.mx";
    echo "</div>";
    die();
}

if(!mysql_select_db($dbname, $conn)) {
    echo "<h2>Error: La base de datos '$dbname' no existe.</h2>";
    die();
}

mysql_query("set names 'utf8'", $conn);
?>
