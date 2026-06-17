<html>
<?
if($_REQUEST['action']=="ver")
         {

if (isset($_GET['width']) AND isset($_GET['height'])) {
 // output the geometry variables
// echo "Screen width is: ". $_GET['width'] ."<br />\n";
// echo "Screen height is: ". $_GET['height'] ."<br />\n";
} 

else {
// pass the geometry variables
// (preserve the original query string
//   -- post variables will need to handled differently)
echo "<script language='javascript'>\n";
echo     "location.href=\"" . $_SERVER['SCRIPT_NAME'] . "?" . $_SERVER['QUERY_STRING'] . "&width=\" + screen.width + \"&height=\" + screen.height;\n";
echo "</script>\n";
exit();
	}

///  parametro de  pantalla	 
///if($file=="")$file=$_REQUEST['id'];
$file=$_REQUEST['id'];
$f=htmlentities(file_get_contents($file));
//echo "<h2>".$TEXT['global-sourcecode']."</h2>";
//echo "Screen width is: ". $_GET['width'] ."<br />\n";
//echo "Screen height is: ". $_GET['height'] ."<br />\n";
$iw= $_GET['width'] - (15 * ($_GET['width']/16)+19 );
$ih= $_GET['height'] - (15 * ($_GET['height']/16)+ 16 );
//echo "Screen width is: ".$iw."<br />\n";
//echo "Screen heigh is: ".$ih."<br />\n";
echo "<textarea style=\"color: black; background-color:#FFFF99\" cols= $iw rows= $ih >";
echo $f;
echo "</textarea>";
}
    



if($_REQUEST['action']=="ft")
         {
$file=$_REQUEST['id'];


echo "<table>";
echo "<tr>";
echo "<tr valign=top><td align=left class=navi>";

if(!mysql_connect("localhost","root","d1nosauri0Z"))
        {
                echo "<h2>".$TEXT['cds-error']."</h2>";
                die();
        }
        mysql_select_db("cdcol");
        $result=mysql_query("SELECT id,st,age,cat,tit,aut,fec,path,capt,capt2,XDimension,YDimension FROM fotos WHERE id=$file;");

while( $row=mysql_fetch_array($result) )
        {
$pat=$row['path'];
//$arch = str_replace("/fotor","../fotor",$row['path']);
$arch = str_replace("/foto","../foto",$row['path']);



if(strpos($arch,".pdf") !== false )
{


echo "<tr><td class=tabval><b>Titulo: ".$row['st']."</b></tr>";
echo "<tr><td class=tabval><b>Fotografo: ".$row['aut']."</b></tr>";
echo "<tr><td class=tabval><b>Categoria: ".$row['capt2']."</b></tr>";
echo "<tr><td class=tabval><b>SubCategoria: ".$row['cat']."</b></tr>";
echo "<tr><td class=tabval><b>Descripcion: ".$row['tit']."</b>";
echo "<b>".$row['capt']."</b></tr>";
//if($he<>2000/6)


echo "<a href=$pat> Es una infografia Click aqui para abrir pfd </a> ";

}
else
{



list($wid, $hei) = getimagesize($arch);
$wi = $wid/5;
$he= $hei/5;

echo "<tr><td class=tabval><b>Titulo: ".$row['st']."</b></tr>";
echo "<tr><td class=tabval><b>Fotografo: ".$row['aut']."</b></tr>";
echo "<tr><td class=tabval><b>Categoria: ".$row['capt2']."</b></tr>";
echo "<tr><td class=tabval><b>SubCategoria: ".$row['cat']."</b></tr>";
echo "<tr><td class=tabval><b>Descripcion: ".$row['tit']."</b>";
echo "<b>".$row['capt']."</b></tr>";
//if($he<>2000/6)

echo "<tr><td class=tabval><b>Resolucion: ".$wid."</b>";
echo "<b>x</b>";
echo "<b>".$hei."</b></tr>";

echo "<img src=$pat width=$wi height=$he >";


}




}






 
// echo " <title>".$file. " </title>";
  }





if($_REQUEST['action']=="ineint")
         {
$file=$_REQUEST['id'];
echo "<table>";
echo "<tr>";
echo "<tr valign=top><td align=left class=navi>";

if(!mysql_connect("localhost","root","d1nosauri0Z"))
        {
                echo "<h2>".$TEXT['cds-error']."</h2>";
                die();
        }
        mysql_select_db("cdcol");
        $result=mysql_query("SELECT id,nota FROM mesaint WHERE id=$file;");

while( $row=mysql_fetch_array($result) )
        { echo "<tr><td class=tabval><b>.".$row['nota']."</b></tr>";}
 
// echo " <title>".$file. " </title>";
  }





if($_REQUEST['action']=="vid")
         {
$file=$_REQUEST['id'];

echo "<table border = 2>";
echo "<tr>";
echo "<tr valign=top><td align=left class=navi>";

if(!mysql_connect("localhost","root","d1nosauri0Z"))
        {
                echo "<h2>".$TEXT['cds-error']."</h2>";
                die();
        }
        mysql_select_db("cdcol");
        $result=mysql_query("SELECT id,titulo,age,cat,fecha,path,ext,hora,pathv FROM videos WHERE id=$file;");

while( $row=mysql_fetch_array($result) )
        {

$pat=$row['path'];
$video=$row['pathv'];
$arch = str_replace("/foto","../afpv",$row['path']);
$htmtemp = $arch;
$htmlfile = str_replace(".jpg",".htm",$htmtemp);
$video = str_replace("./mpg","../afpv/mpg",$row['pathv']);
list($wid, $hei) = getimagesize($arch);
$wi = $wid/2;
$he= $hei/2;
echo "<tr><td class=tabval><b>Titulo: ".$row['titulo']."</b></tr>";

echo "<tr><td><img src=$arch width=$wi height=$he> ";          
echo " <a href=\"$video\" target=\"_blank\">Descargar Video</a></td></tr> ";        

echo "<tr><td><iframe height=500 width=800 src=\"$htmlfile\" seamless></iframe></td></tr>";  

}

// echo " <title>".$file. " </title>";
  }








if($_REQUEST['action']=="welcom")
         {
echo "<table>";
echo "<tr>";
echo "<tr valign=top><td align=left class=navi>";
echo "<tr><td class=tabval><b>Titulo:xxx</b></tr>";
}






if($_REQUEST['action']=="pi")
         {
$file=$_REQUEST['id'];


echo "<table>";
echo "<tr>";

echo "<form action=\"welcome_get.php\" method=\"get'\">";
echo "Name: <input type=\"text\" name=\"name\"><br>";
echo "E-mail: <input type=\"text\" name=\"email\"><br>";
echo "<input type=\"submit\">";
echo "</form>";

echo "<tr>";
echo "</table>";





  }










?>

</body>
</html>
                            
		

// CACHE BUST 1781296232
