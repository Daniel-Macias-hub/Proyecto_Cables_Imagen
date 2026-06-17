<? include("langsettings.php"); ?>
<html>
<head>
<!--  Creado por miguel mendoza     -->
<title>Sistema de cables en la Red Grupo Imagen</title>
<link href="xampp.css" rel="stylesheet" type="text/css">
<meta http-equiv="Refresh" content="520,xhdl.php">
<link rel="stylesheet" href="css/bootstrap.min.css">
 <link rel="stylesheet" href="js/bootstrap.min.js">




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- ClockPicker Stylesheet -->
<link rel="stylesheet" type="text/css" href="clockpicker/dist/bootstrap-clockpicker.min.css">
<link rel="stylesheet" type="text/css" href="clockpicker/assets/css/github.min.css">
<!-- jQuery and Bootstrap scripts -->
<script type="text/javascript" src="clockpicker/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="clockpicker/assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="clockpicker/assets/js/bootstrap.min.js"></script>

<!-- ClockPicker script -->
<script type="text/javascript" src="clockpicker/dist/bootstrap-clockpicker.min.js"></script>
<script type="text/javascript" src="js/validacion.js"></script>
</head>
<body>

<table border=2 cellpadding=2 cellspacing=2>
<tr bgcolor=#f87820>
<td><img src=img/blank.gif width=10 height=25></td>

<td class=tabhead><img src=img/blank.gif width=80 height=8><br><b>Menciones Programadas En XHDL</b></td>
<td ><img src=img/button-mas.png width=50 height=50 onclick= 'cargar();')> </td>
</tr>


<?
$fecha=date('Y-m-d',time() - 60 * 60 * 48);
echo date('Y-m-d',time() - 60 * 60 * 48);
//$fecha = "2018-10-4";
$fecha = "2022-4-08 00:00:00";

  if(!mysql_connect("localhost","root","d1nosauri0Z"))
          {
          echo "<h2>".$TEXT['cds-error']."</h2>";
          die();
	         }
          mysql_select_db("cdcol");


$result=mysql_query("SELECT id,idTR,Nombre,estacion,fecha,status,obs,hrt,client,rutamp3 FROM pi WHERE estacion = 10000000002 AND fecha >= '".$fecha."' ORDER BY fecha DESC ;");

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

</table>
<div class="container">

  <!-- Trigger the modal with a button -->
 <!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>-->
<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 class="modal-title">
<font color="#35a6ff"><b> Agregar nueva Menci&oacuten</b> </font> <img src=img/calendr.png width=25 height=15></h3>
        </div>
        <div class="modal-body">

       <fieldset>


    <div>
        <label for="comment">N&uacutemero</label>
        <input type="text"  id="num" class="form-control" readonly />
        <label for="comment">Estaci&oacuten</label>
        <select id="estacion" type="text" class="form-control" >
                <option value="10000000002" selected>XHDL</option>


    </select>
        <label for="comment">Producto</label>
        <input type="text"  id="producto" class="form-control" />
         <label for="comment">Cliente:</label>
      <input type="text" id="cliente"  class="form-control" />
        <label for="comment">Fecha y hora de Transmisi&oacuten</label>
        <table>
        <tr>
<td><input type="Date" id="fecha" class="form-control" value=""/></td>
<td><div class="input-group clockpicker" data-placement="top" data-align="top" data-autoclose="true">
 <input type="text"  id="hrt" name="hrt" class="form-control"  maxlength="10" >
 <span class="input-group-addon" >
 <span style="background-image:url('img/reloj.png');"> <img src="img/reloj.png" width="20" height="20" alt="Los Tejos" /></span>
</span>
</div>
<script type='text/javascript'>$('.clockpicker').clockpicker(); </script>
</td>
</tr>
</table>
<label for="comment">Observaciones </label>

        <textarea  name="obs" class="form-control" id="obs" rows="5" id="comment"></textarea>

         <label for="comment">Firma </label>
 <input type="password" id="password"  class="form-control" />
    </div></br>
    <div class="alert alert-success" id="validSuccess" role="alert"  style="display:none;"></div></br></br></br>
    <div class="alert alert-danger" id="valid" role="alert"  style="display:none;"></div>
<br/><br/><br/>
<input type="button" class="btn btn-primary"  align="left" value="Agregar Mencion" onclick="enviar_datos();" >


</fieldset>

 <?php

  $d=rand(2,1000000);

  echo"<input type=\"hidden\" id=\"random\" value=\"$d\" />";
?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        </div>
      </div>

    </div>
  </div>
</body>
</html>
