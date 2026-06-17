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
$fecha;

// echo $fechaaa;


if(!mysql_connect("localhost","root","d1nosauri0Z"))
{
    echo "<h2>".$TEXT['cds-error']."</h2>";
    die();
}
mysql_select_db("cdcol");


if(isset($_POST['fechxhdla'])){
    $fechaaa = $_POST['fechxhdla'];
    $fecha = $fechaaa." 00:00:00";
    $result=mysql_query("SELECT id,idTR,Nombre,estacion,fecha,status,obs,hrt,client,rutamp3 FROM pi WHERE estacion = 10000000002 AND fecha >= '".$fecha."' ORDER BY fecha DESC ;");
}else{
    $result=mysql_query("SELECT id,idTR,Nombre,estacion,fecha,status,obs,hrt,client,rutamp3 FROM pi WHERE estacion = 10000000002  ORDER BY fecha DESC ;");
}
//$result=mysql_query("SELECT id,idTR,Nombre,estacion,fecha,status,obs,hrt,client,rutamp3 FROM pi WHERE estacion = 10000000002  ORDER BY fecha DESC ;");

$i=0;
while( $row=mysql_fetch_array($result) )	
	{
			if($i>0)
			{
			echo "<tr valign=bottom>";
			echo "<td bgcolor=#f87820 backgroaund='img/strichel.gif' colspan=7><img src=img/blank.gif width=300 height=1></td>";
			echo "</tr>";
			}

			$iclip= "img/clipcito.png";
			if ( $row['rutamp3'] == '') $iclip= "img/noclipcito.png";
			echo "<tr valign=center>";
			echo "<td class=tabval><img src=img/blank.gif width=4 height=5></td>";
			echo "<td class=tabval><b><font color=\"green\"> NUM:</font>".$row['idTR'].
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
        echo "<td bgcolor=#fb7922 colspan=6><img src=img/blank.gif width=1 height=8></td>";
        echo "</tr>";
        
?>