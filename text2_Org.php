<html>
<head>

<title>Sistema de Envio de Archivos</title>
<meta name="author" content="Miguel MENDOZA">
<link href="xampp.css" rel="stylesheet" type="text/css">
<link href="style1.css" rel="stylesheet" type="text/css">
 <link rel="stylesheet" href="css/bootstrap.min.css">
 <link rel="stylesheet" href="js/bootstrap.min.js">
<!-- Bootstrap stylesheet -->
<link rel="stylesheet" type="text/css" href="clockpicker/assets/css/bootstrap.min.css">

<!-- ClockPicker Stylesheet -->
<link rel="stylesheet" type="text/css" href="clockpicker/dist/bootstrap-clockpicker.min.css">
<link rel="stylesheet" type="text/css" href="clockpicker/assets/css/github.min.css">
<!-- jQuery and Bootstrap scripts -->
<script type="text/javascript" src="clockpicker/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="clockpicker/assets/js/bootstrap.min.js"></script>

<!-- ClockPicker script -->
<script type="text/javascript" src="clockpicker/dist/bootstrap-clockpicker.min.js"></script>

<!-- Sweet Alertt -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.19.1/dist/sweetalert2.all.min.js" integrity="sha256-pYQrGA6LI+iNqLNslfPObC8AbGjVAQIZzGbRBgzHApc=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.19.1/dist/sweetalert2.min.css" integrity="sha256-J8SXTq+SCSrJ+GSCNWSoO3ef8idzOhhNAJRulSUr6mg=" crossorigin="anonymous">

<script type="text/javascript">

function signEvaluate()
{
 /*
	Swal.fire({
  title: "Submit your Github username",
  input: "text",
  inputAttributes: {
    autocapitalize: "off"
  },
  showConfirmButton: true,
  allowOutsideClick: false,
  allowEscapeKey: false,
  confirmButtonText: "Look up",
  showLoaderOnConfirm: true,
  preConfirm: async (login) => {
    try {
      const githubUrl = `
        https://api.github.com/users/${login}
      `;
      const response = await fetch(githubUrl);
      if (!response.ok) {
        return Swal.showValidationMessage(`
          ${JSON.stringify(await response.json())}
        `);
      }
      return response.json();
    } catch (error) {
      Swal.showValidationMessage(`
        Request failed: ${error}
      `);
    }
  },
  allowOutsideClick: () => !Swal.isLoading()
}).then((result) => {
  if (result.isConfirmed) {
    Swal.fire({
      title: `${result.value.login}'s avatar`,
      imageUrl: result.value.avatar_url
    });
  }
});*/
	
	
	swal.fire({
	title: "Login Firma",
	type: "warning",
	html: "Por favor, Ingresa tu Firma",
	allowOutsideClick: false,
	//showCancelButton: true,
	//closeOnConfirm: true,
	//closeOnCancel: true,
	confirmButtonColor: "#DD6B55",
	cancelButtonText: "No",
	confirmButtonText: "Yes",
	input: "text",
	inputAttributes: {
    autocapitalize: "off"
	},
	preConfirm: (name) => {
        if (!name || name.trim() === "") {
            Swal.showValidationMessage("Firma Vacia!");
        }
    },
	confirmButtonText: "VALIDAR",
	}).then(function (result) 
	{
	 
					$.ajax({
                            url: 'EvaluateFirma.php?Firma='+result.value,
							type: 'post',
							
                            success: function(response)
                            {
								//alert(response);
                                //console.log(response);
                                //window.location = self.location;
								//Swal.fire('Seguimiento Agregado!', '', 'success')
								if(response == 1)
								{
									Swal.fire('Firma Encontrada!', '', 'success')
								}
								else
								{
									location.reload();
								}
								
                            },
                            error: function() {
                                Swal.fire('Error, contactar al administrador',
                                    '', 'error');
									 location.reload();
                            }
                        });
	 });
}

function _(el){
        return document.getElementById(el);

}

 
function uploadFile(){
      
         var dbids = '<? echo $_REQUEST['id'];  ?>';
         var nombre = '<? echo $_REQUEST['nom'];  ?>';
         var file = _("file1").files[0];
         //alert(file.name+" | "+file.size+" | "+file.type);
        var formdata = new FormData();
        formdata.append("file1", file);
        formdata.append("dbid", dbids);
		formdata.append("nombre", nombre);
		if(file != null){
        document.getElementById("status").style.display="inline";
        document.getElementById("status").style.display="inline";
        document.getElementById("loaded_n_total").style.display="inline";

        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.addEventListener("load", completeHandler, false);
        ajax.addEventListener("error", errorHandler, false);
        ajax.addEventListener("abort", abortHandler, false);
        ajax.open("POST", "subir.php");
        ajax.send(formdata);
        setTimeout("ocultar();", 5000);
    }else{
     document.getElementById("status2").style.display="inline";
       document.getElementById("status2").innerHTML= "<b>WARNING</b> : No ha seleccionado ningun archivo...Por favor, seleccione un archivo";  
       setTimeout("ocultar();", 5000);

    }
         
}

function progressHandler(event){
        _("loaded_n_total").innerHTML = "Uploaded "+event.loaded+" bytes of "+event.total;
        var percent = (event.loaded / event.total) * 100;
        _("progressBar").value = Math.round(percent);
        _("status").innerHTML = Math.round(percent)+"% uploaded... please wait";

        
}
function completeHandler(event){
           _("status").innerHTML = event.target.responseText;
        _("progressBar").value = 0;
        

        
}
function errorHandler(event){
        _("status").innerHTML = "Upload Failed";
       
}
function abortHandler(event){
        _("status").innerHTML = "Upload Aborted";
       
        
}
//Agrego Ramses para validaciones 
function ocultar(){
   document.getElementById("status").style.display = "none";
   document.getElementById("status2").style.display = "none";
   document.getElementById("loaded_n_total").style.display = "none";

}
function ocultarvalid(){
   document.getElementById("valid").style.display = "none";
}
function enviar_formulario(){ 
	 

	hora = document.getElementById("hrt").value;
	progra = document.getElementById("stat").value;
	obs = document.getElementById("obs").value;
	firma=document.getElementById("firma").value;

    var val= true;
    if (progra == "0"){
		 document.getElementById("valid").style.display = "inline";
		 document.getElementById("valid").innerHTML= "<b>WARNING</b> : Debe seleccionar una opción de <b> programaci&oacuten</b>";
		val=false;
	}
	if(hora == '' ){
		 document.getElementById("valid").style.display = "inline";
		 document.getElementById("valid").innerHTML= "<b>WARNING</b> : Debe asignar una hora de <b>transmisi&oacuten</b>";

		val=false;
	}
	
	if (obs == ''){
		document.getElementById("valid").style.display = "inline";
		 document.getElementById("valid").innerHTML= "<b>WARNING</b> : Debe anotar tus <b>observaciones</b>";
		val=false;
	}
	if (firma == ''){
		document.getElementById("valid").style.display = "inline";
		 document.getElementById("valid").innerHTML= "<b>WARNING</b> : Debe introducir una <b>firma</b> ";
		val=false;
	}
	 setTimeout("ocultarvalid();", 5000);
	if(val== true){


   document.formulario1.submit();
}

} 
</script>

</head>

<!-- <body onload="signEvaluate()">-- >

<?

if($_REQUEST['action']=="pi")
         {
$file=$_REQUEST['id'];
$nom=$_REQUEST['nom'];

echo"<fieldset class=\"scheduler-border\">";
echo" <legend class=\"scheduler-border\">Detalles de la Menci&oacuten</legend>";

echo "<table width= \"300\">";
echo "<form action=\"output.php\" name= \"formulario1\" method=\"get'\">";

echo "<tr style=\"height: 60px;\">";
echo "<td>";
echo " <input name=\"dbid\" class=\"form-control\" value=\"$file\"readonly></td>";
echo "<td colspan=\"2\"><input name=\"nom\" class=\"form-control\" value=\"$nom\"readonly></td>";
echo "</tr>";
echo "<tr style=\"height: 40px;\">";
echo "<td> <label for=\"comment\">Programaci&oacuten:</label></td>";
echo "<td><select name=\"stat\" id=\"stat\" >";
echo"<option value=\"0\" selected>Selecciona...</option>";
echo"<option value=\"Trasmitida\">Transmitida</option>";
echo"<option value=\"No Trasmitida\">No Transmitida</option>";
echo"</select></td>";
echo "<td ><label for=\"comment\">Hora de Transmisi&oacuten</label></td>";
//echo "<td> <input type=\"time\" class=\"form-control\" id=\"hrt\" name=\"hrt\" value=\"00:00\" max=\"23:59\"  step=\"1\" style=\"width: 150px;\"  maxlength=\"50\" ><br>";

echo "<td><div class=\"input-group clockpicker\" data-placement=\"left\" data-align=\"top\" data-autoclose=\"true\">";
echo" <input type=\"text\"  id=\"hrt\" name=\"hrt\"   maxlength=\"10\" >";
echo " <span class=\"input-group-addon\">";
echo" <span class=\"glyphicon glyphicon-time\"></span>";
echo"</span>";
echo"</div>";
echo "<script type='text/javascript'>$('.clockpicker').clockpicker(); </script>";

echo "</td>";
echo"</tr>";
echo "<tr style=\"height: 60px;\">";
echo "<td colspan =\"4\">";
echo "<div class=\"form-group\">";
echo"  <label for=\"comment\">Observaciones:</label>";
echo" <textarea  name=\"obs\" class=\"form-control\" id=\"obs\" rows=\"5\" id=\"comment\"></textarea>";
echo" </div>";
echo"</td>";
echo"</tr>";
echo"<tr style=\"height: 45px;\">";
echo"<td colspan=\"4\">";
echo"<label for=\"comment\">Firma</label> <input type=\"password\" id =\"firma\" class=\"form-control\" name=\"firma\"><br>";
echo"</td>";
echo"</tr>";
echo"<tr>";
echo"<td colspan=\"4\">";
echo "<div class=\"alert alert-danger\" id=\"valid\" role=\"alert\"  style=\"display:none;\"></div>";
echo"</td>";
echo"</tr>";
echo"<tr>";
echo"<td colspan=\"4\" align=\"right\">";
echo"<input type=\"button\" class=\"btn btn-primary\"  value=\"Subir Datos\" onclick=\"enviar_formulario();\" > <br><br>";
echo"</form>";
echo"</td>";
echo"</tr>";

echo"</table>";



  }

?>


       <form id="upload_form" enctype="multipart/form-data" method="post">
  <?$_POST['id2'] = "68"  ?>
<input type="file"   class="form-control" name="file1" id="file1"><br>
  <input type="button" class="btn btn-default" value="Subir Testigo" onclick="uploadFile()">
  <progress id="progressBar" value="0" max="100" style="width:300px;"></progress>
  <div class="progress"> </div>
<div class="alert alert-danger" id="status2" role="alert"  style="display:none;"></div>
<div class="alert alert-success" id="status" role="alert"  style="display:none;"></div></br></br></br>
<div class="alert alert-warning" id="loaded_n_total" role="alert" style="display:none;"></div>
  
</form>
</fieldset>
</body>
</html>                     
		
