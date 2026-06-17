
<? include("langsettings.php"); ?>
<html>
<head>
<!--  Creado por miguel mendoza     -->
<title>Sistema de cables en la Red Grupo Imagen</title>
<link href="xampp.css" rel="stylesheet" type="text/css">
<meta http-equiv="Refresh" content="90,0red.php">
</head>
<body>

<table border=1 cellpadding=1 cellspacing=2>
<tr bgcolor=#f87820>
<td></td>

<td class=tabhead><img src=img/blank.gif width=100 height=8><br><b>Titulo </b></td>

<td class=tabhead><img src=img/blank.gif width=60 height=8><br><b>fecha</b></td>

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
$result=mysql_query("SELECT id,st,cat,tit,fec,path FROM tnews WHERE cat=\"0.Redaccion\" ORDER BY fec DESC;");
//$result=mysql_query("SELECT id,st,cat,tit,fec,path FROM tnews WHERE cat=\"ordenx\" ORDER BY fec DESC;");
$i=0;
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
        echo "<td><a class=n target=text href= $httpm><img src=img/dalet.jpg width=30 height=30></td>";
        echo "<td><a class=n target=text href= $httpm><b>".$row['tit']."</b></td>";  
        echo "<td align='center'><a class=n target=text href= $httpm> <small>".$row['fec']."</small></td>";
        
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
