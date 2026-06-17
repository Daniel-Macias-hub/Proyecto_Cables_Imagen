<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
	
	
	<body >

<?php
 if(isset($_GET['dateT']) && isset($_GET['station']))
{
     // echo $_GET['dateT'];

	if(!mysql_connect("localhost","root","d1nosauri0Z"))
	{
		echo "<h2>".$TEXT['cds-error']."</h2>";
		die();
	}
	mysql_select_db("cdcol");
	//   $result=mysql_query("SELECT id,titulo,age,cat,fecha,hora,path FROM cables WHERE fecha = CURRENT_DATE ORDER BY hora DESC;");
 
?>

 

<table class="table table-striped" border=0 cellpadding=1 cellspacing=1>
<thead class="thead-dark">
<tr >
    <th>Programas</th>
 </tr>
</thead>
<?php

		$result=mysql_query('select programa,count(*) as Total from pi where fecha between "'.$_GET['dateT'].' 00:00:00" and "'.$_GET['dateT'].' 23:00:00" and estacion ='.$_GET['station'].' group by programa order by fecha  asc');
	   
		//echo 'select programa,count(*) as Total from pi where fecha between "'.$_GET['dateT'].' 00:00:00" and "'.$_GET['dateT'].' 23:00:00" group by programa order by programa';
		$id = 1;
		 
		while($row=mysql_fetch_array($result) )
		{
				$Cadena = 'GetPiByProgramStationTest.php?Programa='.$row['programa'].'&Station='.$_GET['station'].'&Date='.$_GET['dateT'];
			    echo "<tr valign=center >";
				//echo $row['programa'].'<br>';
				echo "<td><a id=".$id."ID target=select href='".$Cadena."'><li>".$row['programa']."</li></a></td>";
				
				 echo "</tr>";
			 
			 $id = $id + 1;
        }
}
 
?>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
