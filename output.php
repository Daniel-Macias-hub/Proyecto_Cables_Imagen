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

<body style="background-color:#e6e9e5;"> 

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL ^ E_DEPRECATED);

$servername = "10.29.128.184";
$username = "mike";
$password = "mikemmp";
$dbname = "cdcol";
 

if(!mysql_connect("localhost","root","d1nosauri0Z"))
 { echo "<h2>".$TEXT['cds-error']."</h2>";
   die();
     }
 mysql_select_db("cdcol");

				 
				// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname);
				// Check connection
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				} 

				$sql = "UPDATE pi SET status='".$_GET["stat"]."', obs='".$_GET["obs"]."', hrt='".$_GET["hrt"]."' WHERE id=".$_GET["dbid"] ;

				if ($conn->query($sql) === TRUE) {
					
					echo'<script>
					Swal.fire({
					  title: "Registro PI Actualizado Exitosamente!",
					  icon: "success"
					});
					</script>';
					
					//echo "Gracias, Se Actualizo el estado <br>";
					//header("Location: text2.php");
					//die();
					
				} else {
					
					//echo "Hubo Un error con la base de datos " . $conn->error;
					echo'<script>
					Swal.fire({
					  title: "Ups!!, Algo salio mal!",
					  icon: "error"
					});
					</script>';
				}

				$conn->close();
				$ruta = "/data2/audios/";

				$nomfile = $ruta."XHDLM".date("Y-m-d").".BCR";

				$myfile = fopen($nomfile, "a") or die("Error Abriendo Archivo LOG!");
				$txt =  date("Y/m/d - h:i:sa")."   ".$_GET["nom"]."  ".$_GET["stat"]."  ".$_GET["obs"]."\r"."\n" ;
				fwrite($myfile, $txt);
				fclose($myfile);

?>

</body>
</html> 
