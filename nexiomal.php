
<? include("langsettings.php"); ?>
<html>
<head>
<!--  Creado por miguel mendoza     -->
<title>Sistema de cables en la Red Grupo Imagen</title>
<link href="xampp.css" rel="stylesheet" type="text/css">
<meta http-equiv="Refresh" content="290,nexiomal.php">
</head>
<body>

<table border=0 cellpadding=0 cellspacing=0>
<tr bgcolor=#f87820>
<td><img src=img/blank.gif width=10 height=25></td>

<td class=tabhead><img src=img/blank.gif width=80 height=8><br><b>Titulo </b></td>
<td class=tabhead><img src=img/blank.gif width=5 height=8><br><b></b></td>
<td class=tabhead><img src=img/blank.gif width=50 height=8><br><b>Duracion</b></td>
<td class=tabhead><img src=img/blank.gif width=5 height=8><br><b></b></td>
<td class=tabhead><img src=img/blank.gif width=50 height=8><br><b>Fecha</b></td>
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

//$result=mysql_query("SELECT titulo,age,cat,fecha,hora,path FROM cables WHERE fecha = CURRENT_DATE ORDER BY hora DESC;");
$result=mysql_query("SELECT id,titulo,fecha,path,ext,hora,dur FROM forks WHERE ext != 'TRANFER COMPLETO' ORDER BY fecha DESC,hora DESC;");    
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
        echo "<td class=tabval><b>".$row['titulo']."<BR>".$row['ext']."</b></td>";
        echo "<td class=tabval><img src=img/blank.gif width=5 height=10></td>";
        echo "<td class=tabval><b>".$row['dur']."</b></td>";
        echo "<td class=tabval><img src=img/blank.gif width=5 height=10></td>";
        echo "<td class=tabval><small>".$row['fecha']."-".$row['hora']."</small></td>";
if ( $row['ext'] != "TRANFER COMPLETO")
{
echo "<td class=tabval><a class=n target=text href=http://10.29.128.184".$row['path']."><span class = red >[ver]</span></td>";
} 
 if ( $row['ext'] == "TRANFER COMPLETO")
{       
echo "<td class=tabval><a class=n target=text href=http://10.29.128.184".$row['path']."><span class = green >[ver]</span></td>";}       

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
