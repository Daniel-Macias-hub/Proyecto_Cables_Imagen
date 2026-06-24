<?php
mysql_connect("localhost","root","");
mysql_select_db("cdcol");

$q = "SELECT id, age, cat, titulo, fecha, hora FROM cables WHERE age LIKE '%DPA%' ORDER BY fecha DESC, hora DESC LIMIT 50;";
$res = mysql_query($q);
while ($row = mysql_fetch_assoc($res)) {
    if ($row['age'] !== "DPA") {
        echo "MISMATCH in age! Raw value: '" . $row['age'] . "' (Length: " . strlen($row['age']) . ")\n";
    }
}
echo "Done checking trailing spaces in age.\n";
?>
