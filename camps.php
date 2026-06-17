
<? include("langsettings.php"); ?>
<html>
<head>
<!--  Creado por miguel mendoza     -->
<title>Sistema de cables en la Red Grupo Imagen</title>
<link href="xampp.css" rel="stylesheet" type="text/css">
<meta http-equiv="Refresh" content="90,cams.php">
</head>
<body>


<table border=0 cellpadding=0 cellspacing=0>
<tr bgcolor=#f87820>
<td><img src=img/blank.gif width=10 height=25></td>

<td class=tabhead><img src=img/blank.gif width=80 height=8><br><b>Relacion de Ingestado </b></td>
<td><img src=img/blank.gif width=10 height=25></td>
</tr>


<?

  if(!mysql_connect("localhost","root","d1nosauri0Z"))
          {
          echo "<h2>".$TEXT['cds-error']."</h2>";
          die();
	         }
          mysql_select_db("cdcol");

$result=mysql_query("SELECT id,eve,lugar,cam,rep,fec,hora FROM mats ORDER BY fec DESC,hora DESC;");
$i=0;
while( $row=mysql_fetch_array($result) )
	{
	if($i>0)
	{
	echo "<tr valign=bottom>";
	echo "<td bgcolor=#f87820 backgroaund='img/strichel.gif' colspan=7><img src=img/blank.gif width=300 height=1></td>";
	echo "</tr>";
	}
      	echo "<tr valign=center>";
        echo "<td class=tabval><img src=img/blank.gif width=4 height=5></td>";
        echo "<td class=tabval><b><font color=\"green\"> Evento:</font>".$row['eve']."<BR><font color=\"green\"> Camara: </font>".$row['cam']."<BR><font color=\"green\"> Lugar: </font> ".$row['lugar']."<BR><font color=\"green\"> Reportero:</font> ".$row['rep']."<BR><font color=\"red\"> Fecha: </font>".$row['fec']."-".$row['hora']."</b></td>";
         
        echo "<td class=tabval></td>";
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
