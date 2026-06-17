
<? include("langsettings.php"); ?>
<html>
<head>
<!--  Creado por miguel mendoza     -->
<title>Sistema de cables en la Red Grupo Imagen</title>
<link href="xampp.css" rel="stylesheet" type="text/css">
<meta http-equiv="Refresh" content="180,fndes.php">
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
<td><img src=img/blank.gif width=2 height=25></td>

<td class=tabhead><img src=img/blank.gif width=25 height=5><br><b>Titulo </b></td>
<td class=tabhead><img src=img/blank.gif width=20 height=5><br><b>Ver - fecha</b></td>
</tr>


<?
//    $result=mysql_query("SELECT id,titulo,age,cat,fecha,hora,path FROM cables WHERE fecha = CURRENT_DATE ORDER BY hora DESC;");
$result=mysql_query("SELECT id,st,age,cat,tit,aut,fec,path,capt2 FROM fotos WHERE age=\"AP\" and (cat=\" SPANFILE\" or cat = \" FILE\" or cat LIKE \" SPAN\") ORDER BY fec DESC;"); 
    $i=0;
    $mm="";
    while( $row=mysql_fetch_array($result) )
	{
	if($i>0)
	{
	echo "<tr valign=bottom>";
	echo "<td bgcolor=#f87820 backgroaund='img/strichel.gif' colspan=7><img src=img/blank.gif width=1 height=1></td>";
	echo "</tr>";
	}
     
       	echo "<tr valign=center>";

	$mm = str_replace("/foto","/tumb",$row['path']);
        echo "<td class=tabval><img src=img/blank.gif width=1 height=2></td>";
	echo "<td class=tabval><b>".$row['tit']."</b></td>";
        echo "<td class=tabval><a class=n target=text href=text.php?action=ft&id=".$row['id']."><img class=imgWidth src=$mm> <br>";
	echo "<small>".$row['fec']."</small></td>";
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
