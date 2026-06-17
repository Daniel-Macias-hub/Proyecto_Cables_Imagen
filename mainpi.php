<html>
<head>
<title>Sistema de cables imagen</title>
<meta http-equiv ="Content-Type" content="text/html; charset=UTF-8">

<? //include("lang/".file_get_contents("lang.tmp").".php"); ?>
<link rel="shortcut icon" href="img/miniima.jpg" />
</head>
<?



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

$iw= $_GET['width'] - (15 * ($_GET['width']/16)- 55 );
$ih= $_GET['height'] - (15 * ($_GET['height']/16)- 20 );


echo"<frameset cols=\"$iw,*\" marginwidth=\"0\" marginheight=\"0\" frameborder=\"1\" border=\"1\" borderwidth=\"0\">";
echo"<frame name=\"navi\" src=\"pi.php\" scrolling=yes>";
echo"<frame name=\"content\" src=\"deskpi.php\" marginwidth=1>";
echo"</frameset>";
echo"</frameset>";
	  
?>
<body bgcolor=#1C8BC9>
</body>
</html>

// CACHE BUST 1781296232
