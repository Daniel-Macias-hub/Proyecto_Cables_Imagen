<?php
mysql_connect("localhost","root","");
mysql_select_db("cdcol");

$q = "SELECT count(*) as c FROM cables WHERE fecha = CURRENT_DATE AND age = 'DPA' AND cat LIKE '%R I%'";
$res = mysql_query($q);
$row = mysql_fetch_assoc($res);
echo "Result LIKE '%R I%': " . $row['c'] . "\n";

$q2 = "SELECT count(*) as c FROM cables WHERE fecha = CURRENT_DATE AND age = 'DPA' AND cat = 'r i'";
$res2 = mysql_query($q2);
$row2 = mysql_fetch_assoc($res2);
echo "Result cat='r i': " . $row2['c'] . "\n";

?>
