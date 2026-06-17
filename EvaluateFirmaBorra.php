<?php
	
	//$Firma=$_GET['Firma'];
	$servername = "10.29.128.184";
	$username = "mike";
	$password = "mikemmp";
	$dbname = "cdcol";
	$malpass = 0;
	
	if(!mysql_connect("localhost","root","d1nosauri0Z"))
	{
	   echo "<h2>".$TEXT['cds-error']."</h2>";
	   die();
    }
	mysql_select_db("cdcol");

	$result=mysql_query("SELECT * FROM firmas WHERE firma ='".$_GET["Firma"]."'");
	$Encontrado = mysql_num_rows($result);
	$row=mysql_fetch_array($result);
   
	
	//echo "SELECT * FROM firmas WHERE firma ='".$_GET["Firma"]."'";
	//echo $Encontrado;
	
	if($Encontrado == 1 and $row['usr'] == 'Lizzet Ortega')
	{
		$result=mysql_query("delete from pi where id ='".$_GET["PI"]."' limit 1");
		echo $Encontrado;
	}
	else
	
	{	
		echo 0;
	}
	
	/*
	while( $row=mysql_fetch_array($result) )
	   {

			if( strcmp( $_GET["Firma"], $row['firma']) == 0  )
			{
			$malpass=1;
			// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
		if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	 }
	*/	 


	
	
	

?>