
<? include("langsettings.php"); ?>
<html>
<head>
<!--  Creado por miguel mendoza     -->
<title>Sistema de cables en la Red Grupo Imagen</title>
<link href="xampp.css" rel="stylesheet" type="text/css">
<meta http-equiv="Refresh" content="120,mesat.php">
</head>
<body>

<table border=0 cellpadding=0 cellspacing=0>
<tr bgcolor=#f87820>
<td><img src=img/blank.gif width=10 height=25></td>

<td class=tabhead><img src=img/blank.gif width=80 height=8><br><b>Inews Mesa internacional </b></td>
<td><img src=img/blank.gif width=10 height=25></td>
</tr>
<?
  if(!mysql_connect("localhost","root","d1nosauri0Z"))
          {
          echo "<h2>".$TEXT['cds-error']."</h2>";
          die();
	         }
          mysql_select_db("cdcol");

$result=mysql_query("SELECT id,num,cola,tit,rep,cam,form,foto,vid,link,estat,edo,ftp,age,idAvid,adela,aprov,modi,fmod,creby,credate,fechact FROM mesaint WHERE cola=\"MESA-INFORMACION.ORDENDELDIA.INTERNACIONAL\" ORDER BY id ASC ;");
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
        echo "<td class=tabval><b><font color=\"green\"> NUM:</font>".$row['num'].
"<BR><font color=\"green\"> Titulo: </font>".$row['tit'].
"<BR><font color=\"green\"> Reporter: </font>".$row['rep'].
"<BR><font color=\"green\"> Cam: </font> ".$row['cam'].
"<font color=\"green\"> form:</font> ".$row['form'].
"<BR><font color=\"green\"> foto </font>".$row['foto'].
"<font color=\"green\"> Video </font>".$row['vid']. 
"<font color=\"green\"> Link </font> ".$row['link'].
"<font color=\"green\"> Estatus: </font> ".$row['estat'].
"<BR><font color=\"green\"> Estado: </font> ".$row['edo'].
"<font color=\"green\"> FTP: </font> ".$row['ftp'].
"<font color=\"green\"> Agencia: </font> ".$row['age'].
"<BR><font color=\"green\"> ID: </font> ".$row['idAvid'].
"<font color=\"green\"> ADELANTO: </font> ".$row['adela'].
"<BR><font color=\"green\"> APROBADO: </font> ".$row['aprov'].
"<font color=\"green\"> Actualizado: </font> ".$row['fechact']." </b></td>";       
        echo "<td class=tabval></td>";
echo "<td class=tabval><a class=n target=text href=text.php?action=ineint&id=".$row['id']."><img src=img/inews.JPG width=50 height=50> <br>";
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
