
<? include("langsettings.php"); ?>
<html>
<head>
<!--  Creado por miguel mendoza     -->
<title>Sistema de cables en la Red Grupo Imagen</title>
<link href="xampp.css" rel="stylesheet" type="text/css">
<meta http-equiv="Refresh" content="60,afpinter.php">
</head>
<body>



<?
	if(!mysql_connect("localhost","root","d1nosauri0Z"))
	{
		echo "<h2>".$TEXT['cds-error']."</h2>";
		die();
	}
	mysql_select_db("cdcol");
?>


<table border=0 cellpadding=0 cellspacing=0>
<tr bgcolor=#f87820>
<td><img src=img/blank.gif width=10 height=25></td>

<td class=tabhead><img src=img/blank.gif width=80 height=8><br><b>Titulo </b></td>
<td class=tabhead><img src=img/blank.gif width=50 height=8><br><b>fecha</b></td>
<td><img src=img/blank.gif width=10 height=25></td>
</tr>


<?
//  $result=mysql_query("SELECT id,titulo,age,cat,fecha,hora,path FROM cables WHERE fecha = CURRENT_DATE ORDER BY hora DESC;");
$result=mysql_query("SELECT id,titulo,age,cat,fecha,hora,path FROM cables WHERE cat=\"16\" OR cat=\"NTX-I-\" OR cat=\"i\" OR cat = cat=\"r i\" ORDER BY fecha DESC ,hora DESC LIMIT 550 ;");    
$i=0;
if(!session_id()) session_start();
$server = $_SESSION['server'];

    while( $row=mysql_fetch_array($result) )
        {
        if($i>0)
        {
        echo "<tr class=tr_mmp valign=bottom>";
        echo "<td bgcolor=#f87820 backgroaund='img/strichel.gif' colspan=7><img src=img/blank.gif width=1 height=1></td>";
        echo "</tr>";
        }
        $httpm=$server . $row['path'];
        echo "<tr class=tr_mmp valign=center >";
        if ($row['age']=="AFP") echo "<td><a class=n target=text href= $httpm><img src=img/lafp.JPG width=30 height=30></td>";
        if ($row['age']=="AP") echo "<td><a class=n target=text href= $httpm><img src=img/lap.JPG width=30 height=30></td>";
        if ($row['age']=="RTR") echo "<td><a class=n target=text href= $httpm><img src=img/lrtr.JPG width=30 height=30></td>";
        if ($row['age']=="NTX") echo "<td><a class=n target=text href= $httpm><img src=img/NTX.JPG width=30 height=30></td>";
        if ($row['age']=="DPA") echo "<td><a class=n target=text href= $httpm><img src=img/dpa.jpg width=30 height=30></td>";
        echo "<td><a class=n target=text href= $httpm><b>".$row['age']."-".$row['titulo']."</b></td>";
        echo "<td align='center'><a class=n target=text href= $httpm> <small>".$row['fecha']."<BR>".$row['hora']."</small></td>";
        echo "<td></td>";
        echo "</tr>";

        $i++;
        }

        echo "<tr valign=bottom>";
        echo "<td bgcolor=#fb7922 colspan=6><img src=img/blank.gif width=1 height=8></td>";
        echo "</tr>";
?>

</table>



</body>
</html>
