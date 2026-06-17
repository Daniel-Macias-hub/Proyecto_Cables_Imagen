
<html>
<head>
<title>Sistema de cables imagen</title>
<? //include("lang/".file_get_contents("lang.tmp").".php"); ?>
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

$iw= $_GET['width'];
$ih= $_GET['height'] - (15 * ($_GET['height']/16)- 12 );


echo"<frameset cols=\"$iw,*\" marginwidth=\"0\" marginheight=\"0\" frameborder=\"1\" border=\"1\" borderwidth=\"0\">";
echo"<frame name=\"nex\" src=\"http://aptn.ap.org\">";
echo"</frameset>";
echo"</frameset>";
	  
?>

</head>
<body bgcolor=#ffffff>
</body>
</html>

// CACHE BUST 1781296232
