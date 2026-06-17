<html>
<head>
<title>Sistema de cables imagen</title>
<meta http-equiv ="Content-Type" content="text/html; charset=UTF-8">

<?php //include("lang/".file_get_contents("lang.tmp").".php"); ?>
<link rel="shortcut icon" href="img/miniima.jpg" />
</head>
<?php



if (isset($_GET['width']) AND isset($_GET['height'])) {
	  // output the geometry variables
	  // echo "Screen width is: ". $_GET['width'] ."<br />\n";
	  // echo "Screen height is: ". $_GET['height'] ."<br />\n";
  }

  else {

echo "<script language='javascript'>\n";
echo     "location.href=\"" . $_SERVER['SCRIPT_NAME'] . "?" . $_SERVER['QUERY_STRING'] . "&width=\" + screen.width + \"&height=\" + screen.height;\n";
echo "</script>\n";
exit();
	}  

$iw= $_GET['width'] - (15 * ($_GET['width']/16)- 8 );
$ih= $_GET['height'] - (15 * ($_GET['height']/16)- 20 );

echo"<frameset rows=\"$ih ,*\" marginwidth=\"0\" marginheight=\"0\" frameborder=\"2\" border=\"2\" borderwidth=\"1\">";
echo"<frame name=\"hed\" src=\"cabe.php\" scrolling=no>";
echo"<frameset cols=\"$iw,*\" marginwidth=\"0\" marginheight=\"0\" frameborder=\"1\" border=\"1\" borderwidth=\"0\">";
echo"<frame name=\"navi\" src=\"cablesmenu.php\" scrolling=yes>";
echo"<frame name=\"content\" src=\"desk.php\" marginwidth=1>";
//echo"<frame name=\"content\" src=\"IACHAT.php\" marginwidth=1>";
echo"</frameset>";
echo"</frameset>";
	  
?>
<body bgcolor=#1C8BC9>

</body>
</html>

// CACHE BUST 1781296232
