<?php
if (isset($_GET['width']) AND isset($_GET['height'])) {
  }
  else {
echo "<script language='javascript'>\n";
echo     "location.href=\"" . $_SERVER['SCRIPT_NAME'] . "?" . $_SERVER['QUERY_STRING'] . "\" . "&width=\" + screen.width + \"&height=\" + screen.height;\n";
echo "</script>\n";
exit();
	}  
$iw= $_GET['width'] - (15 * ($_GET['width']/16)- 8 );
$ih= $_GET['height'] - (15 * ($_GET['height']/16)- 20 );
?>