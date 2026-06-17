<?php
$dbid= ($_POST['dbid']);
$nombre = ($_POST['nombre']);

$fileName = $_FILES["file1"]["name"]; // The file name
$subName = explode(".", $fileName );

$fileName = $nombre."-".$dbid.'.'.$subName[1];

$fileTmpLoc = $_FILES["file1"]["tmp_name"]; // File in the PHP tmp folder
$fileType = $_FILES["file1"]["type"]; // The type of file it is
$fileSize = $_FILES["file1"]["size"]; // File size in bytes
$fileErrorMsg = $_FILES["file1"]["error"]; // 0 for false... and 1 for true
$pathlink = "http://10.29.128.184/audio2/";

if (!$fileTmpLoc) { // if file not chosen
    echo "No se ha seleccionado un achivo... Seleccione uno";
    exit();
}
if(move_uploaded_file($fileTmpLoc, "/data2/audios/$fileName")){
    
    echo "El Archivo  ".  basename( $_FILES['file1']['name']) ." Se Transfirio con exito <BR>";

//
$plink = $pathlink.$fileName;
$servername = "10.29.128.184";
$username = "mike";
$password = "mikemmp";
$dbname = "cdcol";
$malpass = 0;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "UPDATE pi SET rutamp3='".$plink."' WHERE id=".$dbid ;

if ($conn->query($sql) === TRUE) {
    echo "Gracias <br>";
} else { echo "                  Hubo Un error con la base de datos " . $conn->error;}
} else {   echo "Fallo la Transferencia";}


//
  


?>

