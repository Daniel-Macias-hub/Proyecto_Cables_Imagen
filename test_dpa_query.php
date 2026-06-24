<?php
require 'mysql_shim.php'; // or just connect
mysql_connect("localhost","root","");
mysql_select_db("cdcol");

$q1 = 'SELECT titulo,age,cat,fecha,hora,path FROM cables WHERE cat="r i" AND age="DPA" ORDER BY fecha DESC,hora DESC LIMIT 5';
$res1 = mysql_query($q1);
if (!$res1) {
    echo "ERROR: " . mysql_error() . "\n";
} else {
    echo "DPA INT ROWS:\n";
    while ($row = mysql_fetch_assoc($res1)) {
        print_r($row);
    }
}
?>
