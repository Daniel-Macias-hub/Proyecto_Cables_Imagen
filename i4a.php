
<? include("langsettings.php"); ?>
<html>
<head>
<!--  Creado por miguel mendoza     -->
<title>Sistema de cables en la Red Grupo Imagen</title>
<link href="xampp.css" rel="stylesheet" type="text/css">
<meta http-equiv="Refresh" content="60,i4a.php">
</head>
<body>


<table border=0 cellpadding=0 cellspacing=0>
<tr bgcolor=#f87820>
<td><img src=img/blank.gif width=10 height=25></td>

<td class=tabhead><img src=img/blank.gif width=80 height=8><br><b>Titulo </b></td>
<td class=tabhead><img src=img/blank.gif width=5 height=8><br><b></b></td>
<td class=tabhead><img src=img/blank.gif width=50 height=8><br><b>fecha</b></td>
<td class=tabhead><img src=img/blank.gif width=5 height=8><br><b>ver</b></td>
<td><img src=img/blank.gif width=10 height=25></td>
</tr>


<?

  if(!mysql_connect("localhost","root","d1nosauri0Z"))
          {
          echo "<h2>".$TEXT['cds-error']."</h2>";
          die();
	         }
          mysql_select_db("cdcol");
$result=mysql_query("SELECT id,st,cat,tit,fec,path FROM tnews WHERE cat=\"0.Redaccion\" ORDER BY fec DESC;");
//$result=mysql_query("SELECT id,st,cat,tit,fec,path FROM tnews WHERE cat=\"ordenx\" ORDER BY fec DESC;");
$i=0;
while( $row=mysql_fetch_array($result) )
	{
	if($i>0)
	{
	echo "<tr valign=bottom>";
	echo "<td bgcolor=#f87820 backgroaund='img/strichel.gif' colspan=7><img src=img/blank.gif width=1 height=1></td>";
	echo "</tr>";
	}
      	echo "<tr valign=center>";
        echo "<td class=tabval><img src=img/blank.gif width=5 height=10></td>";
        echo "<td class=tabval><b>".$row['tit']."</b></td>";
        echo "<td class=tabval><img src=img/blank.gif width=5 height=10></td>";
        echo "<td class=tabval><small>".$row['fec']."</small></td>";
	echo "<td class=tabval><a class=n target=text onclick=\"h(this);\" href=text.php?action=ver&id=".$row['path']."><span class = red >[ver]</span></td>";
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
