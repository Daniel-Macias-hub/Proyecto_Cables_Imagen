<?php
if(!session_id()) session_start();
$server = "http://10.29.128.184";
if(!isset($_SESSION['server'])) {
    $_SESSION['server'] = $server;
}
?>

<html>
<!-- style IA -->
<style>
    #gimm-chat-container {
        position: fixed !important;
        top: 80px;
        right: 20px;
        width: 400px;
        height: 600px;
        z-index: 9999 !important;
        display: none; /* Oculto al inicio */
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.5);
        overflow: hiddeni;
	transform-origin: top rigth;
	transition: all 0.3 ease;
    }

    #gimm-toggle-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 40px;
        height: 40px;
        background-color: #2563eb; /* Azul corporativo */
        color: white;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        z-index: 10000 !important;
        transition: transform 0.3s;
    }

    #gimm-toggle-btn:hover { transform: scale(1.1); }
</style>
<!-- fin style IA -->
<body style="background: #999999; margin-top: -2px; margin-left: -2px;">
<link href="xampp.css" rel="stylesheet" type="text/css">
<table>
<td><img src="img/logoinicio.JPG"></td>
<td><h4> <font color="white">.    Sistema de Recepcion de Cables </h4> 
<img src="img/blank.gif" width=20 height=4>
<a class=n target=navi href=cablesmenu.php> Cables</a>
<img src="img/blank.gif" width=20 height=4>
<a class=n target=navi href=temasmenu.php> x-Temas</a>
<img src="img/blank.gif" width=20 height=4>

<a class=n target=navi href=tnmenu.php> Turbina</a>
<img src="img/blank.gif" width=20 height=4>
<a class=n target=new href=http://10.29.120.16:8181/K4Overview/>K4</a>
<img src="img/blank.gif" width=20 height=4>
<a class=n target=navi href=foto.php>Fotos</a>
<img src="img/blank.gif" width=1 height=1>
<img src="img/blank.gif" width=1 height=1>
<img src="img/blank.gif" width=20 height=4>
<a class=n target=navi href=video.php>Video</a>
<img src="img/blank.gif" width=1 height=1>
<img src="img/blank.gif" width=20 height=4>

<a class=n target=navi href=pi.php>Pi</a>
<img src="img/blank.gif" width=1 height=1>
<img src="img/blank.gif" width=20 height=4>

<a class=n target=navi href=pitest.php>Prueba</a>
<img src="img/blank.gif" width=1 height=1>
<img src="img/blank.gif" width=20 height=4>

</td>
<td>
<h4>.Buscar :</h4>
<FORM NAME="e1c">
<INPUT TYPE="text" NAME="B1" SIZE= 20 VALUE="" onkeypress="handleKeyPress(event,this.form)">
<INPUT TYPE="submit" NAME="B4" style="width:40px; height:40px;" VALUE="Ir" onClick="going()">
</FORM>
</td>

<SCRIPT LANGUAGE=JavaScript>

function going()
{
var alertString ,st2 ;
alertString ="buscar.php?action=get&id=" ;
st2=alertString + document.e1c.B1.value;
window.open(st2, "select", "height=400,width=600,toolbar,scrollbars,resizable");

}

function handleKeyPress(e,form){
        var key=e.keyCode || e.which;
        if (key==13){
        going();
        }
}

</SCRIPT>

<script>
    function toggleGIMMChat() {
        var container = document.getElementById('gimm-chat-container');
        var icon = document.getElementById('gimm-icon');

        const chatIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 21 1.9-5.7a8.5 8.5 0 1 1 3.8 3.8z"/></svg>`;
    const closeIcon = `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>`


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



</table>
</body>
</html>



