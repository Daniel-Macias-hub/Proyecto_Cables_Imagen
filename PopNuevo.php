<?
	include("langsettings.php");
?>
<html>
<head>
<meta name="author" content="MMP">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
<link href="ccsPop.css" rel="stylesheet" type="text/css">
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
		   mywindow = window.close("http://10.29.128.184/imagen/PopNuevo.php","directories=no, location=no, menubar=no, scrollbars=yes, statusbar=no, tittlebar=no, width=400, height=400");

        }
       });

$('#myModal').modal('hide');
}

	function cargar() {
	
$('#myModal').modal('show');


 document.getElementById("num").value = "MAM00"+ document.getElementById("random").value;


}
	</script>
	
	
<script type="text/javascript">
		function close() {
	
 open(location, '_self').close();


}
	</script>
	
	
	
</head>

<body onload="cargar();" leftmargin=0 topmargin=0 class=navi>

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
        <option value="10000000001">XHDL</option>
        <option value="10000000002">XEDA</option>
       
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
<input type="button" class="btn btn-primary" onclick="enviar_datos();" align="left" value="Agregar Mencion"  >
   

</fieldset>

 <?php

  $d=rand(2,1000000);
 
  echo"<input type=\"hidden\" id=\"random\" value=\"$d\" />";
?>
        </div>
        <div class="modal-footer">
          <button type="button" onclick="close();"  class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
</div>

</body>
</html>

