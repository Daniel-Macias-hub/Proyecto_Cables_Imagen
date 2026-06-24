<?php
mysql_connect("localhost","root","");
mysql_select_db("cdcol");

$queries = [
    "DPA Todos" => "SELECT count(*) as c FROM cables WHERE age=\"DPA\"",
    "DPA Int" => "SELECT count(*) as c FROM cables WHERE cat=\"r i\" AND age=\"DPA\"",
    "DPA Dep" => "SELECT count(*) as c FROM cables WHERE cat=\"r s\" AND age=\"DPA\"",
    "DPA Cul" => "SELECT count(*) as c FROM cables WHERE cat=\"r v\" AND age=\"DPA\"",
    "DPA Esp" => "SELECT count(*) as c FROM cables WHERE cat=\"r e\" AND age=\"DPA\"",
    "DPA Eco" => "SELECT count(*) as c FROM cables WHERE cat=\"r f\" AND age=\"DPA\""
];

foreach ($queries as $name => $q) {
    $r = mysql_query($q);
    $row = mysql_fetch_assoc($r);
    echo "$name : " . $row['c'] . " rows\n";
}
?>
