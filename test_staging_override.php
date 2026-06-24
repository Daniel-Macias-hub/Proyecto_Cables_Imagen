<?php
mysql_connect("localhost","root","");
mysql_select_db("cdcol");

$q = "SELECT count(*) as c FROM cables WHERE fecha = CURRENT_DATE AND age = 'DPA' AND (titulo LIKE '%internacional%' OR cat LIKE '%internacional%' OR cat LIKE '%OVR%' OR cat LIKE '%R I%' OR cat LIKE '%R V%')";
$res = mysql_query($q);
$row = mysql_fetch_assoc($res);
echo "DPA INT staging override rows: " . $row['c'] . "\n";

$q2 = "SELECT count(*) as c FROM cables WHERE fecha = CURRENT_DATE AND age = 'DPA'";
$res2 = mysql_query($q2);
$row2 = mysql_fetch_assoc($res2);
echo "DPA TODOS staging override rows: " . $row2['c'] . "\n";

?>
