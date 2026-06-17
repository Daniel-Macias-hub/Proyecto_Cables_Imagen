<? include("langsettings.php"); ?>
<html>
<head>


     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
	
	<!--========================================================AJAX  =======================================================-->
    <script type="text/javascript" src="http://ajax.microsoft.com/ajax/jQuery/jquery-1.4.2.min.js"></script>
    <!--==============================JQUERY====================================-->
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	
	<!--=============Exportar tabla a excel=================================-->	
	<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/jquery.table2excel.min.js"></script>
	
	
	 <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.4.1.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous">
        </script>
    <!-- DATATABLES -->
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js">
    </script>
    <!-- BOOTSTRAP -->
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js">
    </script>

<!--  Creado por miguel mendoza     -->
<title>Sistema de cables en la Red Grupo Imagen</title>
<link href="xampp.css" rel="stylesheet" type="text/css">

			<script>
					$(document).ready(function () {
						$('#mydatatable').DataTable({

							language: {
								processing: "Tratamiento en curso...",
								search: "Buscar&nbsp;:",
								lengthMenu: "Agrupar de _MENU_ items",
								info: "Mostrando del registro_START_ al _END_ de un total de _TOTAL_ registros",
								infoEmpty: "No existen datos.",
								infoFiltered: "(filtrado de _MAX_ elementos en total)",
								infoPostFix: "",
								loadingRecords: "Cargando...",
								zeroRecords: "No se encontraron registros con tu busqueda",
								emptyTable: "No hay registros disponibles en la tabla.",
								paginate: {
									first: "Primero",
									previous: "Anterior",
									next: "Siguiente",
									last: "Ultimo"
								},
								aria: {
									sortDescending: ": active para ordenar la columna en orden descendente",
									sortAscending: ": active para ordenar la columna en orden ascendente"
									
								}
							
							},
							scrollY: 700,
							lengthMenu: [ [10, 25, -1], [10, 25, "All"] ],
							
						});
								
					});
			   
				</script>
			<script language="JavaScript">
			// Configure refresh interval (in seconds)
			var refreshinterval=190
			// Shall the coundown be displayed inside your status bar? Say "yes" or "no" below:
			var displaycountdown="yes"
			// Do not edit the code below
			var starttime
			var nowtime
			var timer
			var reloadseconds=0
			var secondssinceloaded=0
			function starttime() {
			starttime=new Date()
			starttime=starttime.getTime()
			countdown()
			}
			function countdown() {
			nowtime= new Date()
			nowtime=nowtime.getTime()
			secondssinceloaded=(nowtime-starttime)/1000
			reloadseconds=Math.round(refreshinterval-secondssinceloaded)
			if (refreshinterval>=secondssinceloaded) {
			timer=setTimeout("countdown()",1000)
			if (displaycountdown=="yes") {
			window.status="Proximo Refresh En: "+reloadseconds+ " segundos"
			}
			}
			else {
			clearTimeout(timer)
			window.location.reload(true)
			}}
			window.onload=starttime
			function enableDisableRefresh(disabledState){
				if (disabledState){
				   clearTimeout(timer);
				}
				else {
				 window.location.reload(true);
				}
			}
			</script>


</head>
<body>
<input type="checkbox" id="chk" onclick="enableDisableRefresh(this.checked)" /><label for="chk">Deshabilitar Auto-
Refresh</label>

<?
	if(!mysql_connect("localhost","root","d1nosauri0Z"))
	{
		echo "<h2>".$TEXT['cds-error']."</h2>";
		die();
	}
	mysql_select_db("cdcol");
?>


	<table id='mydatatable' border=1 cellpadding=0 cellspacing=0>
	<thead>
		<tr bgcolor=#f87820>
			<th class=tabhead><img src=img/blank.gif width=25 height=5><br><b>Titulo </b></th>
			<th class=tabhead><img src=img/blank.gif width=20 height=5><br><b>Ver - fecha</b></th>
		</tr>
	</thead>
	<tbody>
<?
//    $result=mysql_query("SELECT id,titulo,age,cat,fecha,hora,path FROM cables WHERE fecha = CURRENT_DATE ORDER BY hora DESC;");
		$result=mysql_query("SELECT id,st,age,cat,tit,aut,fec,path FROM fotos WHERE age=\"REUTERS\" ORDER BY fec DESC LIMIT 50;"); 
		$i=0;
		$mm="";
    while( $row=mysql_fetch_array($result) )
	{
		 
			echo "<tr valign=center>";
				$mm = str_replace("/fotor","/fotor/Tumb",$row['path']);
				echo "<td class=tabval><b>".$row['st']."</b></td>";
				echo "<td class=tabval><a class=n target=text onclick=\"h(this);\" href=text.php?action=ft&id=".$row['id']."><img src=$mm> <br>";
				echo "<small>".$row['fec']."</small></td>";
			echo "</tr>";
		$i++;
	}

	   

?>
<tbody>
</table>



</body>
</html>
