<?
	include("langsettings.php");
?>
<html>
<head>
<meta name="author" content="MMP">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
<link href="xampp.css" rel="stylesheet" type="text/css">
 <link rel="stylesheet" href="css/bootstrap.min.css">
 <link rel="stylesheet" href="js/bootstrap.min.js"> 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- ClockPicker Stylesheet -->
<link rel="stylesheet" type="text/css" href="clockpicker/dist/bootstrap-clockpicker.min.css">
<link rel="stylesheet" type="text/css" href="clockpicker/assets/css/github.min.css">
<!-- jQuery and Bootstrap scripts -->
<script type="text/javascript" src="clockpicker/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="clockpicker/assets/js/bootstrap.min.js"></script>
<!-- ClockPicker script -->
<script type="text/javascript" src="clockpicker/dist/bootstrap-clockpicker.min.js"></script>

<script type="text/javascript">

function enviar_datos(){
 
 	 var num = document.getElementById("num").value ;
 	 var estacion = document.getElementById("estacion").value ;
 	 var cliente = document.getElementById("cliente").value ;
 	 var producto = document.getElementById("producto").value ;
 	 var fecha = document.getElementById("fecha").value ;
 	 var hrt = document.getElementById("hrt").value ;
 	 var obs = document.getElementById("obs").value ;
         var parametro={"num": num, "estacion": estacion, "cliente": cliente, "producto": producto, "fecha": fecha, "hrt": hrt, "obs": obs};
 $.ajax({
        data : parametro,
        url: 'subirpi.php',
        type: 'post',
        beforSend: function(){
          alert("procesando");
        },

        success: function (response){
        
          alert(response);
        location.reload();
        }
       });

$('#myModal').modal('hide');

}

	function cargar() {
	
$('#myModal').modal('show');


 document.getElementById("num").value = "MAN00"+ document.getElementById("random").value;


}
	</script>
	
	<script>
      function load() {
        //alert("evento load detectado!");
		document.getElementById("nuevox").click();
      }
      window.onload = load;
    </script>
	
</head>

<body leftmargin=0 topmargin=0 class=navi>
<table border=0 cellpadding=0 cellspacing=0>
<tr valign=top>
<td align=right class=navi>
<img src=img/blank.gif width=110 height=15><br>
<span class=red>Nuevo Registro</span><br>
</td></tr>
</tr>
<tr><td bgcolor=#fb7922 colspan=1 background="img/strichel.gif" class=white><img src=img/blank.gif width=1 height=1></td></tr>
<tr valign=top><td align=right class=navi>
<a class=b id=nuevox target=select onclick="cargar();"> <b>Agregar +</b><img src="img/documenting.png" width="25" height="25" alt="Los Tejos" /></a><br><br><br>    

</tr>


</table>
<div class="container">
 <h2>Modal Example</h2>
  <!-- Trigger the modal with a button -->
 <!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>-->
<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Programaci&oacuten de Menciones</h4>
        </div>
        <div class="modal-body">

       <fieldset>
    

    <div>
    	<label for="comment">Numero</label>
    	<input type="text"  id="num" class="form-control" readonly />
    	<label for="comment">Estaci&oacuten</label>
    	<select id="estacion" type="text" class="form-control" >
    		<option value="0">Seleccione...</option>
        <!--<option value="10000000002">XHDL</option>-->
        <option selected value="10000000001">XEDA</option>
       
    </select>
    	<label for="comment">Producto</label>
    	<input type="text"  id="producto" class="form-control" />
    	 <label for="comment">Cliente:</label>
      <input type="text" id="cliente"  class="form-control" />
        <label for="comment">Fecha y hora de Programaci&oacuten</label>
        <table>
	<tr>
<td><input type="Date" id="fecha" class="form-control"/></td>
<td><div class="input-group clockpicker" data-placement="right" data-align="top" data-autoclose="true">
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
    </div>
<br/><br/><br/>
<input type="button" class="btn btn-primary"  align="left" value="Agregar Mencion" onclick="enviar_datos();" >
   

</fieldset>

 <?php

  $d=rand(2,1000000);
 
  echo"<input type=\"hidden\" id=\"random\" value=\"$d\" />";
?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
</div>

</body>
</html>

