<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<!--  Creado por miguel mendoza     -->
<link href="xampp.css" rel="stylesheet" type="text/css">
<meta http-equiv="Refresh" content="90,ini.php">
</head>
<body>
<table border=0 cellpadding=0 cellspacing=0>
<tr bgcolor=#E91C3B>
<td><img src=img/blank.gif width=20 height=40></td>
<td class=tabhead><img src=img/blank.gif width=300 height=20><br><b>Titulo </b></td>
<td style="width: 2px; background-color: White; margin: 1px;"><img src=img/blank.gif width=5 height=20><br><b></b></td>
<td class=tabhead><img src=img/blank.gif width=150 height=20><br><b>fecha-hora</b></td>
<td><img src=img/blank.gif width=1 height=20></td>
</tr>
<?
if(!session_id()) session_start();
$server = $_SESSION['server'];

   if(!mysql_connect("localhost","root","d1nosauri0Z"))
           {
            echo "<h2>".$TEXT['cds-error']."</h2>";
            die();
           }
       mysql_select_db("cdcol");

 mysql_query("set names 'utf8'");
//$result=mysql_query("SELECT titulo,age,cat,fecha,hora,path FROM cables WHERE fecha = CURRENT_DATE ORDER BY hora DESC;");
$result=mysql_query("SELECT titulo,age,cat,fecha,hora,path,urge FROM cables ORDER BY fecha DESC,hora DESC LIMIT 150;");    
$i=0;
if(!session_id()) session_start();
$server = $_SESSION['server'];

    while( $row=mysql_fetch_array($result) )
	{
	if($i>0)
	{
	echo "<tr class=tr_mmp valign=bottom>";
	echo "<td bgcolor=#f87820 backgroaund='img/strichel.gif' colspan=7><img src=img/blank.gif width=1 height=5></td>";
	echo "</tr>";
	}
        $httpm=$server . $row['path'];
       	echo "<tr class=tr_mmp valign=center >";
        if($row['urge']=="3")  echo "<tr class=tr_mmpa valign=center >"; 
        if($row['urge']=="2")   echo "<tr class=tr_mmpu valign=center >";
        if($row['urge']=="1")  echo "<tr class=tr_mmpu valign=center >"; 
        if ($row['age']=="AFP") echo "<td><a class=n target=text href= $httpm><img src=img/lafp.JPG width=30 height=30></td>";
        if ($row['age']=="AP") echo "<td><a class=n target=text href= $httpm><img src=img/lap.JPG width=30 height=30></td>";
        if ($row['age']=="RTR") echo "<td><a class=n target=text href= $httpm><img src=img/lrtr.JPG width=30 height=30></td>";
        if ($row['age']=="NTX") echo "<td><a class=n target=text href= $httpm><img src=img/NTX.JPG width=30 height=30></td>";
        if ($row['age']=="DPA") echo "<td><a class=n target=text href= $httpm><img src=img/dpa.jpg width=30 height=30></td>";
        echo "<td><a class=n target=text href= $httpm><b>".$row['age']."-".$row['titulo']."</b></td>";
        echo "<td class=tabval><img src=img/blank.gif width=5 height=10></td>";
        echo "<td><a class=n target=text href= $httpm> <small>".$row['fecha']."<BR>".$row['hora']."</small></td>";
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
