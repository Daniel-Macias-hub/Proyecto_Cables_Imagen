<?php
mysql_connect("localhost","root","");
mysql_select_db("cdcol");

$query = "SELECT id, age, cat, titulo, fecha, hora FROM cables WHERE age LIKE '%DPA%' ORDER BY fecha DESC, hora DESC LIMIT 50;";
$result = mysql_query($query);

$data = array();
if ($result) {
    while($row = mysql_fetch_assoc($result)) {
        // Enclose strings in quotes to see exact whitespace
        $row['age'] = "'" . $row['age'] . "'";
        $row['cat'] = "'" . $row['cat'] . "'";
        $data[] = $row;
    }
} else {
    $data['error'] = mysql_error();
}

echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>
