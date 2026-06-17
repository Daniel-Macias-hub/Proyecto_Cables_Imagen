
<? include("langsettings.php"); ?>
<html>
<head>
<!--  Creado por miguel mendoza     -->
<title>Sistema de cables en la Red Grupo Imagen</title>
<link href="xampp.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
// Configure refresh interval (in seconds)
var refreshinterval=90
// Shall the coundown be displayed inside your status bar? Say "yes" or "no" below:
var displaycountdown="yes"
// Do not edit the code below
var starttime
var nowtime
var timer
var reloadseconds=0
var secondssinceloaded=0
function starttime() {
starttime=new Date()
starttime=starttime.getTime()
countdown()
}
function countdown() {
nowtime= new Date()
nowtime=nowtime.getTime()
secondssinceloaded=(nowtime-starttime)/1000
reloadseconds=Math.round(refreshinterval-secondssinceloaded)
if (refreshinterval>=secondssinceloaded) {
timer=setTimeout("countdown()",1000)
if (displaycountdown=="yes") {
window.status="Proximo Refresh En "+reloadseconds+ " segundos"
}
}
else {
clearTimeout(timer)
window.location.reload(true)
}}
window.onload=starttime
function enableDisableRefresh(disabledState){
    if (disabledState){
       clearTimeout(timer);
    }
    else {
     window.location.reload(true);
    }
}
</script>

</head>
<body>
<input type="checkbox" id="chk" onclick="enableDisableRefresh(this.checked)" /><label for="chk">Deshabilitar Auto-Refresh</label>

<?
	if(!mysql_connect("localhost","root","d1nosauri0Z"))
	{
		echo "<h2>".$TEXT['cds-error']."</h2>";
		die();
	}
	mysql_select_db("cdcol");
?>


<table border=0 cellpadding=0 cellspacing=0 >
<tr bgcolor=#f87820>
<td><img src=img/blank.gif width=2 height=25></td>

<td class=tabhead><img src=img/blank.gif width=15 height=5><b>Titulo </b></td>
<td class=tabhead><img src=img/blank.gif width=20 height=5><b>Ver fecha</b></td>
</tr>


<?
//    $result=mysql_query("SELECT id,titulo,age,cat,fecha,hora,path FROM cables WHERE fecha = CURRENT_DATE ORDER BY hora DESC;");
$result=mysql_query("SELECT id,st,age,cat,tit,aut,fec,path,capt2 FROM fotos WHERE age=\"AFP\" AND capt2 = \"POL\" ORDER BY fec DESC LIMIT 1000 ;"); 
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
	$mm = str_replace("/foto","/foto/Tumb",$row['path']);
        echo "<td class=tabval><img src=img/blank.gif width=1 height=2></td>";
        echo "<td class=tabval><b>".$row['st']."</b></td>";
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
