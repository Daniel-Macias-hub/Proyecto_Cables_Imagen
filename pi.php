<?
	date_default_timezone_set('America/Mexico_City');
	include("langsettings.php");
//ho "<a class=n target=text href=".$ruta."><img src=".$iclip." width=40 height=20> <br>"; 
	$today = date("Y-m-d");
	$cadena="programas.php?dateT=".$today.'&station=10000000001';
?>
<html>
<!DOCTYPE html>
<head>
<meta name="author" content="MMP">
<link href="xampp.css" rel="stylesheet" type="text/css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
<style>
.Programas {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 10px 10px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}

 
</style>

<script>
      function load() {
		   
				document.querySelector('#initPi').click();	 	 
      }
      window.onload = load;
    </script>

 
</head>

<body leftmargin=0 topmargin=10 class=navi>
	<table border=0 cellpadding=0 cellspacing=2>
		<tr valign=top>
			<td align=right class=navi>
				<img src=img/blank.gif width=110 height=15><br>
				<span class=red>ESTACION</span><br>
				<br>
				<br>
			</td>
		</tr>
		<tr>
			<td bgcolor=#fb7922 colspan=1 background="img/strichel.gif" class=white><img src=img/blank.gif width=1 height=1>
			</td>
		</tr>
		<!--
		<tr valign=top>
			<td align=right class=navi>
				<a class=n target=select href=xhdldes.php><img src=img/calendr.png width=25 height=15>
				<a class=n target=select href=xhdldes.php>.  XHDL </a>	
				
				<br><br><br>
			</td>
		</tr>
		-->
		<tr>
			<td bgcolor=#fb7922 colspan=1 background="img/strichel.gif" class=white><img src=img/blank.gif width=1 height=1>
			</td>
		</tr>
		<tr valign=top>
			<td align=right class=navi>
				<a class=n  target=select href=xhdldes.php><img src=img/calendar-icon.png width=45 height=45>
				<a class=n target=text href=nuevo.php?action=pi&id=0000000&nom=9999999><img src=img/button-mas.png width=50 height=50>
				<a id="initPi" class=n target=programasFrame href=<? echo $cadena; ?>> XEDA </a>
				<br><br><br>   
			</td> 
		</tr>
		 
		
		<tr valign=top>
			 
			<td align=right class=navi>
				<iframe   id='programasFrame' border = 0
				name='programasFrame' height ='1300'
				class=n scrolling="yes" width='143'>
				</iframe>
				 
				<br><br><br>   
			</td> 
		</tr>
		
	</table>
</body>
</html>

