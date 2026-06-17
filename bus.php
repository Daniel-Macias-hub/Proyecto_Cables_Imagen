<?
	include("langsettings.php");
?>
<html>
<head>
<meta name="author" content="MMP">
<link href="xampp.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="xampp.js">
</script>
</head>

<body leftmargin=0 topmargin=0 class=n>
<table border=0 cellpadding=0 cellspacing=0>
<tr valign=top>
<td align=right class=navi>
<img src=img/blank.gif width=15 height=1><br>
<tr><td bgcolor=#fb7922 colspan=1 background="img/strichel.gif" class=white><img src=img/blank.gif width=1 height=1></td></tr>
<tr valign=top><td align=right class=navi>
</td></tr>
<td bgcolor=#fb7922 colspan=1 background="img/strichel.gif" class=white><img src=img/blank.gif width=1 height=1></td>
<span class=nh>.</span><br>
<span class=nh>. Buscar :</span><br>
</td></tr>
<SCRIPT LANGUAGE=JavaScript>

function going()
{

var alertString ,st2 ;
alertString ="buscar.php?action=get&id=" ;
st2=alertString + document.e1c.B1.value;

window.open(st2, "select", "height=300,width=600,toolbar,scrollbars,resizable");


}

function handleKeyPress(e,form){
	var key=e.keyCode || e.which;
	if (key==13){
	going();
	}
}

</SCRIPT>

<tr><td align = right>
<BR>
</td>
<td>
<FORM NAME="e1c">
<INPUT TYPE="text" NAME="B1" SIZE= 12 VALUE="" onkeypress="handleKeyPress(event,this.form)">
<INPUT TYPE="submit" NAME="B4" VALUE="Ir" onClick="going()">
</FORM>
</td>
</tr>

</table>
</body>
</html>

