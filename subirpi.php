<?php

$num= ($_POST['num']);
$est= ($_POST['estacion']);
$cnt= ($_POST['cliente']);
$prod= ($_POST['producto']);
$fecha= ($_POST['fecha']);
$hrt= ($_POST['hrt']);
$obs= ($_POST['obs']);


//Configuracion de la conexion a base de datos
$servername = "localhost";
$username = "root";
$password = "d1nosauri0Z";
$dbname = "cdcol";
$malpass = 0;
if(!mysql_connect("localhost","root","d1nosauri0Z"))
 { echo "Ocurrio un error en la conexión a la base de Dato";
   die();
     }
 mysql_select_db("cdcol");

$result=mysql_query("SELECT id,usr,firma FROM firmas WHERE firma ='".$_POST["firma"]."' ORDER BY id ASC ;");

while( $row=mysql_fetch_array($result) )
   {

if( strcmp( $_POST["firma"], $row['firma']) == 0  )
  {
  	$malpass=1;
//Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
 //Check connection
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
} 

$sql = "INSERT INTO pi (idTR,Nombre,estacion, fecha, status, obs, hrt, client) values ('".$prod."', '".$num."', ".$est.", '".$fecha."', 'TRANSMITIDO', '".$obs."', '".$hrt."', '".$cnt."' )";

if ($conn->query($sql) === TRUE) {
    echo "<b>EXITO</b> La menci&oacuten se agrego correctamente";
} else { echo "<b>WARNING</b>  > Error en la base de Datos" . $conn->error;}
}

}

if($malpass == 0 ){ echo "<b>WARNING</b> La firma no es v&aacutelida";}


  

?>

