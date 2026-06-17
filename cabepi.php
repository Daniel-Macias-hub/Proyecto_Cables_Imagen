<?php
if(!session_id()) session_start();
$server = "http://10.29.128.184";
if(!isset($_SESSION['server'])) {
    $_SESSION['server'] = $server;
}
?>

<html>
<body style="background: #999999; margin-top: -2px; margin-left: -2px;">
<link href="xampp.css" rel="stylesheet" type="text/css">


</body>
</html>



