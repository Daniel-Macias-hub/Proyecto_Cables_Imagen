<? include("langsettings.php"); ?>
<html>
<head>
<!--  Creado por miguel mendoza     -->
<title>Sistema de cables en la Red Grupo Imagen</title>
<link href="xampp.css" rel="stylesheet" type="text/css">
<meta http-equiv="Refresh" content="520,XEDA.php">
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
		<td class=tabhead><img src=img/blank.gif width=80 height=8><br><b>Consulta por Fecha</b></td>
		<td style="width: 50px !important;">
			<input type="Date" id="fechxeda" class="form-control" value="" style="background-color: #99CCFF; font-size: 10px;">
			</input>
		</td>
    <td class=tabhead>
			<div id="progress">
				<!-- <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div> -->
				<div style="font-size: 10px; border:1px solid black;" >Buscando...</div>
			</div>
		</td>
		<!-- <td><button onClick="handlerData()" class="btn btn-primary">Consulta</button></td> -->
	</tr>
<tr bgcolor=#f87820>
  <td><img src=img/blank.gif width=10 height=25></td>
  <td class=tabhead><img src=img/blank.gif width=80 height=8><br><b>Menciones Programadas En XEDA<br> </b></td> 
  <td ><img src=img/button-mas.png width=50 height=50 onclick= 'cargar();')> </td>
</tr>
</table>

<table border=2 cellpadding=2 cellspacing=2 id="respuesta">


</table>

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script type="text/javascript"></script>
	<script>
		const selectElement = document.getElementById('fechxeda');
		selectElement.addEventListener('change', (event) => {
			//alert(selectElement.value);
      handelProgress();
			handlerData();
		});
		
		function handlerData(){
			$.ajax(
                {
					          type: 'POST',
                    url: './data_pixeda.php',
					          data:selectElement.value,
                    success: function( data ) {
                        handelProgress();
                        var viewresponse = document.getElementById('respuesta');
						            viewresponse.innerHTML = data;
                    }
                }
            )
		}

    function myFunction() {
      var x = document.getElementById("myDIV");
      if (x.style.display === "none") {
          x.style.display = "block";
      } else {
          x.style.display = "none";
      }
    }

    function handelProgress(){
			var progress = document.getElementById('progress')
			if(progress.style.display === "none"){
				progress.style.display = "block";
			}else{
				progress.style.display = "none";
			}
		}
</script>

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
    		<option value="10000000001" selected>XEDA</option>
        
       
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
</div>


</body>
</html>
