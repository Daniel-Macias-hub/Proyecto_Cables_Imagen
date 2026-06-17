
<? include("langsettings.php"); ?>
<html>
<head>
<!--  Creado por miguel mendoza     -->
<title>Sistema de cables en la Red Grupo Imagen</title>
<link href="xampp.css" rel="stylesheet" type="text/css">
</head>
<body>
<?

$DB_HostName = "localhost";
$DB_Name = "cdcol";
$DB_User = "root";
$DB_Pass = "d1nosauri0Z";
$DB_Table = "mats";
	
if (isset ($_GET["eve"]))
		$eve = $_GET["eve"];
	else
		$eve = "sin-evento";

if (isset ($_GET["cam"]))
                $cam = $_GET["cam"];
        else
                $cam = "sin-camara";

if (isset ($_GET["rep"]))
                $rep = $_GET["rep"];
        else
                $rep = "sin-reportero";

if (isset ($_GET["lugar"]))
                $lugar = $_GET["lugar"];
        else
                $lugar = "sin-lugar";

		
$con = mysql_connect($DB_HostName,$DB_User,$DB_Pass) or die(mysql_error()); 
mysql_select_db($DB_Name,$con) or die(mysql_error());
$sql = "insert into $DB_Table (eve,cam,rep,lugar,fec,hora) values('$eve','$cam','$rep','$lugar',CURDATE(),CURTIME())";
$res = mysql_query($sql,$con) or die(mysql_error());
	
mysql_close($con);
if ($res) {
                echo "Exito";
		echo $eve;
	}else{
		echo "failed";
	}// end else

?>
</body>

</html>
