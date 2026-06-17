<? include("langsettings.php"); ?>
<html>
<head>
<!--  Creado por miguel mendoza     -->
<title>Sistema de cables en la Red Grupo Imagen</title>
<link href="xampp.css" rel="stylesheet" type="text/css">
</head>
<body>


<table target=text border=0 cellpadding=0 cellspacing=0>
<tr bgcolor=#f87820>
<td><img src=img/blank.gif width=10 height=25></td>

<td class=tabhead ><img src=img/blank.gif width=80 height=8><br><b>Titulo </b></td>
<td class=tabhead ><img src=img/blank.gif width=5 height=8><br><b></b></td>
<td class=tabhead ><img src=img/blank.gif width=50 height=8><br><b>fecha</b></td>
<td class=tabhead ><img src=img/blank.gif width=5 height=8><br><b>ver</b></td>
<td><img src=img/blank.gif width=10 height=25></td>
</tr>


<?
if(!session_id()) session_start();
$server = $_SESSION['server'];


$querys=$_REQUEST['id'];

if($_REQUEST['action']=="get")
         {



if(!mysql_connect("localhost","root","d1nosauri0Z"))
           {
           echo "<h2>".$TEXT['cds-error']."</h2>";
           die();
           }
mysql_select_db("cdcol");



$result=mysql_query("SELECT id,titulo,age,cat,fecha,hora,path FROM cables ORDER BY fecha DESC, hora DESC LIMIT 1000;");
    
    $i=0;
    while( $row=mysql_fetch_array($result) )
	{
	
       $pos = strripos ($row['titulo'] , $querys );

       if($pos > 0 )		
       {
		
	if($i>0)
	{
        echo "<tr class=tr_mmp valign=bottom>";
        echo "<td bgcolor=#f87820 backgroaund='img/strichel.gif' colspan=7><img src=img/blank.gif width=1 height=1></td>";
        echo "</tr>";
        }
        $httpm=$server . $row['path'];
        echo "<tr class=tr_mmp valign=center >";
        if ($row['age']=="AFP") echo "<td><a class=n target=text href= $httpm><img src=img/lafp.JPG width=30 height=30></td>";
    //    if ($row['age']=="AP") echo "<td><a class=n target=text href= $httpm><img src=img/lap.JPG width=30 height=30></td>";
        if ($row['age']=="RTR") echo "<td><a class=n target=text href= $httpm><img src=img/lrtr.JPG width=30 height=30></td>";
        if ($row['age']=="NTX") echo "<td><a class=n target=text href= $httpm><img src=img/NTX.JPG width=30 height=30></td>";
        if ($row['age']=="DPA") echo "<td><a class=n target=text href= $httpm><img src=img/dpa.jpg width=30 height=30></td>";
        echo "<td><a class=n target=text href= $httpm><b>".$row['age']."-".$row['titulo']."</b></td>";
//        echo "<td class=tabval><img src=img/blank.gif width=1 height=10></td>";
        echo "<td><a class=n target=text href= $httpm> <small>".$row['fecha']."<BR>".$row['hora']."</small></td>";
        echo "<td></td>";
        echo "</tr>";

        $i++;
	}

}


echo "<td bgcolor=#f87820 backgroaund='img/strichel.gif' colspan=7><img src=img/blank.gif width=1 height=1></td>";
echo "<td bgcolor=#f87820 backgroaund='img/strichel.gif' colspan=7><img src=img/blank.gif width=1 height=1></td>";
mysql_free_result($result);



//BUSQUEDA   EN  VIDEO    id,st,cat,tit,fec,path FROM tnews WHERE cat=\"0.Redaccion\" ORDER BY fec DESC;");

$resultv=mysql_query("SELECT id,titulo,age,cat,fecha,path,ext,hora,pathv FROM videos ORDER BY fecha DESC, hora DESC LIMIT 2000 ;");
$rv=0;
while( $rowv=mysql_fetch_array($resultv) )
     {
     $postv = strripos ($rowv['titulo'] , $querys );
     if($postv > 0 )
     {
        echo "<tr class=tr_mmp valign=bottom>";
        echo "<td bgcolor=#f87820 backgroaund='img/strichel.gif' colspan=7><img src=img/blank.gif width=1 height=1></td>";
        echo "</tr>";
        $mm = str_replace("/foto","/afpv",$rowv['path']);
        echo "<td class=tabval><img src=img/blank.gif width=1 height=2></td>";
        echo "<td class=tabval><b>".$rowv['ext']." - ".$rowv['titulo']."</b></td>";
        echo "<td class=tabval><a class=n target=text onclick=\"h(this);\" href=text.php?action=vid&id=".$rowv['id']."><img src=$mm width=60 height=40 > <br>";
        echo "<small>".$rowv['fecha']."-".$rowv['hora']." </small></td>";

        echo "</tr>";

        $rv++;
        }
  }

echo "<td bgcolor=#f87820 backgroaund='img/strichel.gif' colspan=7><img src=img/blank.gif width=1 height=1></td>";
echo "<td bgcolor=#f87820 backgroaund='img/strichel.gif' colspan=7><img src=img/blank.gif width=1 height=1></td>";

mysql_free_result($resultv);



//BUSQUEDA   EN  TNEWS    id,st,cat,tit,fec,path FROM tnews WHERE cat=\"0.Redaccion\" ORDER BY fec DESC;");

$resulttn=mysql_query("SELECT id,st,cat,tit,fec,path FROM tnews ORDER BY fec;");
$j=0;
while( $rowt=mysql_fetch_array($resulttn) )
     {
     $postine = strripos ($rowt['tit'] , $querys );
     if($postine > 0 )
     {
        echo "<tr class=tr_mmp valign=bottom>";
        echo "<td bgcolor=#f87820 backgroaund='img/strichel.gif' colspan=7><img src=img/blank.gif width=1 height=1></td>";
        echo "</tr>";

        $httpm= $server . $rowt['path'];
        echo "<tr class=tr_mmp valign=center >";
        echo "<td><a class=n target=text href= $httpm><img src=img/dalet.jpg width=30 height=30></td>";
        echo "<td><a class=n target=text href= $httpm><b>".$rowt['cat']."-".$rowt['tit']."</b></td>";

        echo "<td></td>";
        echo "</tr>";

        $j++;
        }
  }

echo "<td bgcolor=#f87820 backgroaund='img/strichel.gif' colspan=7><img src=img/blank.gif width=1 height=1></td>";
echo "<td bgcolor=#f87820 backgroaund='img/strichel.gif' colspan=7><img src=img/blank.gif width=1 height=1></td>";

mysql_free_result($resulttn);


//BUSQUEDA   EN  INEWS





$resultine=mysql_query("SELECT id,num,cola,tit,rep,cam,form,foto,vid,link,estat,edo,ftp,age,idAvid,adela,aprov,modi,fmod,creby,credate,fechact FROM mesaint ORDER BY id ASC ;");

$ine=0;
while( $rowine=mysql_fetch_array($resultine) )
     {
     $postn = strripos ($rowine['tit'] , $querys );
     if($postn > 0 )
     {
 {
        echo "<tr valign=bottom>";
        echo "<td bgcolor=#f87820 backgroaund='img/strichel.gif' colspan=7><img src=img/blank.gif width=300 height=1></td>";
        echo "</tr>";
        }
        echo "<tr valign=center>";
        echo "<td class=tabval><img src=img/blank.gif width=4 height=5></td>";
        echo "<td class=tabval><b><font color=\"green\"> NUM:</font>".$rowine['num'].
"<BR><font color=\"green\"> Titulo: </font>".$rowine['tit'].
"<BR><font color=\"green\"> Reporter: </font>".$rowine['rep'].
"<BR><font color=\"green\"> Cam: </font> ".$rowine['cam'].
"<font color=\"green\"> form:</font> ".$rowine['form'].
"<BR><font color=\"green\"> foto </font>".$rowine['foto'].
"<font color=\"green\"> Video </font>".$rowine['vid']. 
"<font color=\"green\"> Link </font> ".$rowine['link'].
"<font color=\"green\"> Estatus: </font> ".$rowine['estat'].
"<BR><font color=\"green\"> Estado: </font> ".$rowine['edo'].
"<font color=\"green\"> FTP: </font> ".$rowine['ftp'].
"<font color=\"green\"> Agencia: </font> ".$rowine['age'].
"<BR><font color=\"green\"> ID: </font> ".$rowine['idAvid'].
"<font color=\"green\"> ADELANTO: </font> ".$rowine['adela'].
"<BR><font color=\"green\"> APROBADO: </font> ".$rowine['aprov'].
"<font color=\"green\"> Actualizado: </font> ".$rowine['fechact']." </b></td>";       
        echo "<td class=tabval></td>";
echo "<td class=tabval><a class=n target=text href=text.php?action=ineint&id=".$rowine['id']."><img src=img/inews.JPG width=50 height=50> <br>";
        echo "</tr>";      


        $ine++;
        }
  }

echo "<td bgcolor=#f87820 backgroaund='img/strichel.gif' colspan=7><img src=img/blank.gif width=1 height=1></td>";
echo "<td bgcolor=#f87820 backgroaund='img/strichel.gif' colspan=7><img src=img/blank.gif width=1 height=1></td>";

mysql_free_result($resultine);

  




/// busqueda en   FOTOS


$result=mysql_query("SELECT id,age,cat,tit,aut,fec,path,idt FROM fotos  ORDER BY fec DESC;");
    $i=0;
    $mm="";
    while( $rowf=mysql_fetch_array($result) )
        {

    $postn = strripos ($rowf['tit'] , $querys );
    $postidt = strripos ($rowf['idt'] , $querys );


     if( $postn > 0 || $postidt > -1 )
     {
        if($i>0)
        {
        echo "<tr valign=bottom>";
        echo "<td bgcolor=#f87820 backgroaund='img/strichel.gif' colspan=7><img src=img/blank.gif width=1 height=1></td>";
        echo "</tr>";
        }

        echo "<tr valign=center>";

       // if($rowf['age'] == " AP")  $mm = str_replace("/foto/","/tumb/",$rowf['path']); 
       // if($rowf['age'] == "AP")  $mm = str_replace("/foto/","/tumb/",$rowf['path']);
       // if($rowf['age'] == "NOTIMEX")  $mm = str_replace("/foto/","/tumb/",$rowf['path']);
        if($rowf['age'] == "DPA")  $mm = str_replace("/foto/","/foto/Tumb/",$rowf['path']);
        if($rowf['age'] == "REUTERS") $mm = str_replace("/fotor/","/fotor/Tumb/",$rowf['path']);
        if($rowf['age'] == "AFP") $mm = str_replace("/foto/","/foto/Tumb/",$rowf['path']);        

        echo "<td class=tabval><img src=img/blank.gif width=1 height=2></td>";
        echo "<td class=tabval ><b>".$rowf['age']."-".$rowf['idt']."-".$rowf['tit']."</b></td>";
        echo "<td class=tabval><a class=n target=text href=text.php?action=ft&id=".$rowf['id']."><img src=$mm> <br>";
        echo "<small>".$rowf['fec']."</small></td>";
        echo "<td class=tabval></td>";
        echo "</tr>";

        $i++;

         }

        }

mysql_free_result($result);


}

?>

</table>



</body>
</html>
