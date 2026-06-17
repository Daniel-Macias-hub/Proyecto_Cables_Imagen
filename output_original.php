<html>
<body>

<?php

$servername = "10.29.128.184";
$username = "mike";
$password = "mikemmp";
$dbname = "cdcol";
$malpass = 0;

if(!mysql_connect("localhost","root","d1nosauri0Z"))
 { echo "<h2>".$TEXT['cds-error']."</h2>";
   die();
     }
 mysql_select_db("cdcol");

$result=mysql_query("SELECT id,usr,firma FROM firmas WHERE firma ='".$_GET["firma"]."' ORDER BY id ASC ;");

while( $row=mysql_fetch_array($result) )
   {

		if( strcmp( $_GET["firma"], $row['firma']) == 0  )
		  {
				$malpass=1;
				// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname);
				// Check connection
				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				} 

				$sql = "UPDATE pi SET status='".$_GET["stat"]."', obs='".$_GET["obs"]."', hrt='".$_GET["hrt"]."' WHERE id=".$_GET["dbid"] ;

				if ($conn->query($sql) === TRUE) {
					echo "Gracias ".$row['usr']."  Se Actualizo el estado <br>";
				} else {
					echo "Hubo Un error con la base de datos " . $conn->error;
				}

				$conn->close();
				$ruta = "/data2/audios/";

				$nomfile = $ruta."XHDLM".date("Y-m-d").".BCR";

				$myfile = fopen($nomfile, "a") or die("Error Abriendo Archivo LOG!");
				$txt =  date("Y/m/d - h:i:sa")."   ".$_GET["nom"]."  ".$_GET["stat"]."  ".$_GET["obs"]."\r"."\n" ;
				fwrite($myfile, $txt);
				fclose($myfile);


		}

}

if($malpass == 0 ){ echo "La Firma No Es Valida ";}
?>

</body>
</html>
