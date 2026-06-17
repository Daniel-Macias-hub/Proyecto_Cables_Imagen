<?
	if($_REQUEST['action']=="getpdf")
	{
		mysql_connect("localhost","root","");
		mysql_select_db("cdcol");

		include ('class.ezpdf.php');
		$pdf = new Cezpdf();
		$pdf->selectFont('/opt/lampp/lib/fonts/Helvetica.afm');

		$pdf->ezText('CD Collection',14);
		$pdf->ezText('© 2002/2003 Kai Seidler, oswald@apachefriends.org, GPL',10);
		$pdf->ezText('',12);

		$result=mysql_query("SELECT id,titel,interpret,jahr FROM cds ORDER BY interpret;");
		
		$i=0;
		while( $row=mysql_fetch_array($result) )
		{
			$data[$i]=array('interpret'=>$row['interpret'],'titel'=>$row['titel'],'jahr'=>$row['jahr']);
			$i++;
		}

		$pdf->ezTable($data,"","",array('width'=>500));

		$pdf->ezStream();
		exit;
	}
?>
<? include("langsettings.php"); ?>
<html>
<head>
<title>Sistema de cables en la Red Grupo Imagen</title>
<link href="xampp.css" rel="stylesheet" type="text/css">
</head>

<body>

&nbsp;<p>
<h1><?=$TEXT['cds-head']?></h1>

<?=$TEXT['cds-text1']?><p>
<?=$TEXT['cds-text2']?><p>

<?
	if(!mysql_connect("localhost","root","d1nosauri0Z"))
	{
		echo "<h2>".$TEXT['cds-error']."</h2>";
		die();
	}
	mysql_select_db("cdcol");
?>

<h2>"Tabla de Cables"</h2>

<table border=0 cellpadding=0 cellspacing=0>
<tr bgcolor=#f87820>
<td><img src=img/blank.gif width=10 height=25></td>
<td class=tabhead><img src=img/blank.gif width=150 height=6><br><b>    Titulo </b></td>
<td class=tabhead><img src=img/blank.gif width=100 height=6><br><b>    agencia   </b></td>
<td class=tabhead><img src=img/blank.gif width=50 height=6><br><b>     fecha</b></td>
<td class=tabhead><img src=img/blank.gif width=50 height=6><br><b>     extra</b></td>
<td><img src=img/blank.gif width=10 height=25></td>
</tr>

<?
    $result=mysql_query("SELECT titulo,age,cat FROM cables ORDER BY age;");
    $i=0;
    while( $row=mysql_fetch_array($result) )
	{
		if($i>0)
		{
			echo "<tr valign=bottom>";
			echo "<td bgcolor=#ffffff background='img/strichel.gif' colspan=6><img src=img/blank.gif width=1 height=1></td>";
			echo "</tr>";
		}
		echo "<tr valign=center>";
		echo "<td class=tabval><img src=img/blank.gif width=5 height=10></td>";
		echo "<td class=tabval><b>".$row['titulo']."</b></td>";
		echo "<td class=tabval>".$row['age']."&nbsp;</td>";
		echo "<td class=tabval>".$row['cat']."&nbsp;</td>";

		echo "<td class=tabval><a onclick=\"return confirm('".$TEXT['cds-sure']."');\" href=cds.php?action=del&id=".$row['id']."><span class=red>[".$TEXT['cds-button1']."]</span></a></td>";
		echo "<td class=tabval></td>";
		echo "</tr>";
		$i++;

	}

	echo "<tr valign=bottom>";
        echo "<td bgcolor=#fb7922 colspan=6><img src=img/blank.gif width=1 height=8></td>";
        echo "</tr>";


?>

</table>

<h2><?=$TEXT['cds-head2']?></h2>

<form action=cds.php method=get>
<table border=0 cellpadding=0 cellspacing=0>
<tr><td><?=$TEXT['cds-attrib1']?>:</td><td><input type=text size=30 name=interpret></td></tr>
<tr><td><?=$TEXT['cds-attrib2']?>:</td><td> <input type=text size=30 name=titel></td></tr>
<tr><td><?=$TEXT['cds-attrib3']?>:</td><td> <input type=text size=5 name=jahr></td></tr>
<tr><td></td><td><input type=submit border=0 value="<?=$TEXT['cds-button2']?>"></td></tr>
</table>
</form>
<? include("showcode.php"); ?>

</body>
</html>
