
<? include("langsettings.php"); ?>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Sistema de cables en la Red Grupo Imagen</title>
<link href="xampp.css" rel="stylesheet" type="text/css">
</head>

<body>

&nbsp;<p>
<h1>Basse de Datos  de cables en el sistema</h1>


<h2>Buscar</h2>

<form action=cds.php method=get>
<table border=0 cellpadding=0 cellspacing=0>
<tr><td>Buscar :</td><td><input type=text size=30 name=titulo></td></tr>
<tr><td></td><td><input type=submit border=0 value="<?=$TEXT['cds-button2']?>"></td></tr>
</table>
</form>
<?
	if(!mysql_connect("localhost","root","d1nosauri0Z"))
	{
		echo "<h2>".$TEXT['cds-error']."</h2>";
		die();
	}
	mysql_select_db("cdcol");
?>

<h2>"Cables en el sistema"</h2>

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
		echo "<td bgcolor=#ffffff background='img/strichel.gif' colspan=7><img src=img/blank.gif width=1 height=1></td>";
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

<!-- fin html IA -->
<script>
    function toggleGIMMChat() {
        var container = document.getElementById('gimm-chat-container');
        var icon = document.getElementById('gimm-icon');

        const chatIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 21 1.9-5.7a8.5 8.5 0 1 1 3.8 3.8z"/></svg>`;
    const closeIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>`


        if (container.style.display === 'none' || container.style.display === '') {
            container.style.display = 'block';
            icon.innerHTML = closeIcon
        } else {
            container.style.display = 'none';
            icon.innerHTML = chatIcon
        }
    }
</script>
<!-- JS IA -->
</body>
</html>
