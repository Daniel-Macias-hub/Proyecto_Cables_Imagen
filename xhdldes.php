<? include("langsettings.php"); ?>
<html>
<head>
<!--  Creado por miguel mendoza     -->
<title>Sistema de cables en la Red Grupo Imagen</title>
<link href="xampp.css" rel="stylesheet" type="text/css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<meta http-equiv="Refresh" content="520,xhdl.php">
</head>
<body>
<a id='rogg' class=n target=programasFrame > CONSULTAR

<table border=2 cellpadding=2 cellspacing=2>
	<tr bgcolor=#f87820>
		<td class=tabhead><img src=img/blank.gif width=80 height=8><br><b>Consulta por Fecha</b></td>
		<td>
			<input type="Date" id="fechxhdla" class="form-control" value="" style="background-color: #99CCFF; font-size: 10px;">
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
		
		<td class=tabhead><img src=img/blank.gif width=80 height=8><br><b>Menciones Programadas </b></td>
		<td class=tabval><a class=n target=text href=nuevo.php?action=pi&id=0000000&nom=9999999><img src=img/button-mas.png width=50 height=50> </td>
	</tr>
</table>
<table border=2 cellpadding=2 cellspacing=2  id="respuesta">

<br/>



<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
    

    <script type="text/javascript"></script>
	<script>
		const selectElement = document.getElementById('fechxhdla');
		selectElement.addEventListener('change', (event) => {
			
			
			//alert(selectElement.value);
			handelProgress();
			//handlerData();
			LoadProgramas();
		});
		
		
		function LoadProgramas()
		{
			//alert(selectElement.value);
			$('#rogg').attr("href", "programas.php?dateT="+selectElement.value+'&station=10000000001')
			$('#rogg').click();
		}
		
		
		function handlerData(){
			$.ajax(
                {
					type: 'POST',
                    url: './data_pixhda.php',
					data:selectElement.value,
                    success: function( data ) {
						handelProgress();
                        var viewresponse = document.getElementById('respuesta');
						viewresponse.innerHTML = data;
                    }
                }
            )
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
</table>

</body>
</html>
