<html>
<head>

</head>
<body>

<?
if(!session_id()) session_start();


   if(!mysql_connect("localhost","root","d1nosauri0Z"))
           {
            echo "<h2>".$TEXT['cds-error']."</h2>";
            die();
           }
       mysql_query("set names 'utf8'");
       mysql_select_db("cdcol");

     //$result=mysql_query("SELECT titulo,age,cat,fecha,hora,path FROM cables WHERE fecha = CURRENT_DATE ORDER BY hora DESC;");
    // $result=mysql_query("SELECT titulo,age,cat,fecha,hora,path,urge FROM cables ORDER BY fecha DESC,hora DESC LIMIT 150;");
$result=mysql_query("select * from t");
$i=0;
    if(!session_id()) session_start();

    while( $row=mysql_fetch_array($result) )
	{
        //echo $row['titulo']."</br>";
         echo $row['ti'] . "</br>";
	$i++;
	}


?>


</body>
</html>
