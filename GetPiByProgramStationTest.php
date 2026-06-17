<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

 
 

<table class="table table-bordered" border=1 cellpadding=1 cellspacing=1>

<?php
date_default_timezone_set('America/Mexico_City');
 if(isset($_GET['Programa']) && isset($_GET['Station']))
{
  
		//echo $_GET['Date'].' '.$_GET['Station'];
		
		//$today = date("Y-m-d");
		$today = $_GET['Date'];
		
	   
		if(!mysql_connect("localhost","root","d1nosauri0Z"))
		{
			echo "<h2>".$TEXT['cds-error']."</h2>";
			die();
		}
		mysql_select_db("cdcol");

		//$result=mysql_query("SELECT id,idTR,Nombre,estacion,fecha,status,obs,hrt,client,rutamp3 FROM pi WHERE estacion = 10000000002 AND fecha >= '".$fecha."' ORDER BY fecha DESC ;");
// original  regrsar este cuando toño hay checado
//              $result=mysql_query('SELECT id,idTR,Nombre,estacion,fecha,status,obs,hrt,client,rutamp3,trorden,siglas from pi where programa="'.$_GET['Programa'].'" and fecha between "'.$today.' 00:00:00" and "'.$today.' 23:00:00" a$

		$result=mysql_query('SELECT id,idTR,Nombre,estacion,fecha,status,obs,hrt,client,rutamp3,trorden,siglas from pi where programa="'.$_GET['Programa'].'" and siglas<>"XEDA" and fecha between "'.$today.' 00:00:00" and "'.$today.' 23:00:00" and estacion ='.$_GET['Station'].' ORDER BY fecha DESC');
		
		$i=0;
		while( $row=mysql_fetch_array($result) )	
			{
					if($i>0)
					{
					echo "<tr valign=bottom>";
					echo "<td bgcolor=#08888A colspan=2></td>";
					echo "</tr>";
					}

					$iclip= "img/clipcito.png";
					if ( $row['rutamp3'] == '') $iclip= "img/noclipcito.png";
					echo "<tr valign=center>";
					
					echo "<td class=tabval><b><font color=\"green\"> I:</font>".$row['siglas']."_".$row['idTR']."<font color=\"green\">  _  Ord:</font>".$row['trorden'].
					"<BR><font color=\"green\"> Producto: </font>".$row['Nombre'].
					"<BR><font color=\"green\"> Fecha y Hora Programada: </font>".$row['fecha'].
					"<BR><font color=\"green\"> Cliente: </font>".$row['client'].
					"<BR><font color=\"DarkBlue\"> Estatus    </font> ".$row['status'].
					"<BR><font color=\"DarkBlue\"> Hora Real de Transmision:  </font> ".$row['hrt'].
					"<BR><font color=\"DarkBlue\"> Observacion    </font> ".$row['obs']." </b></td>";

					$ruta = $row['rutamp3'];

					if( strlen($row['rutamp3']) < 3 )
					{
					$ruta='null';
					}

					echo "<td class=tabval><a class=n target=text href=text2.php?action=pi&id=".$row['id']."&nom=".$row['idTR']."><img src=img/tikachico.png width=50 height=50> <br>";
					echo "<a class=n target=text href=".$ruta."><img src=".$iclip." width=40 height=20> <br>"; 




					echo "</tr>";
				
					$i++;

			}
				echo "<tr valign=bottom>";
				echo "<td bgcolor=#08888A colspan=6></td>";
				echo "</tr>";
}
?>
