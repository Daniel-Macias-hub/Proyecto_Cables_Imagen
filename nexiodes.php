
<? include("langsettings.php"); ?>
<html>
<head>
<!--  Creado por miguel mendoza     -->
<title>Sistema de cables en la Red Grupo Imagen</title>
<link href="xampp.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
// Configure refresh interval (in seconds)
var refreshinterval=120
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


<table border=0 cellpadding=0 cellspacing=0>
<tr bgcolor=#f87820>
<td><img src=img/blank.gif width=10 height=25></td>

<td class=tabhead><img src=img/blank.gif width=50 height=8><br><b>Titulo </b></td>
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
$result=mysql_query("SELECT id,titulo,fecha,path,ext,hora,dur FROM forks ORDER BY fecha DESC,hora DESC;");    
    $i=0;
    while( $row=mysql_fetch_array($result) )
	{
	if($i>0)
	{
	echo "<tr valign=bottom>";
	echo "<td bgcolor=#f87820 backgroaund='img/strichel.gif' colspan=7><img src=img/blank.gif width=1 height=1></td>";
	echo "</tr>";
	}
     
        $corto=substr($row['ext'],0,20);
       	echo "<tr valign=center>";
        echo "<td class=tabval><img src=img/blank.gif width=5 height=10></td>";
        echo "<td class=tabval><b>".$row['titulo']."<BR>".$corto."</b></td>";
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
