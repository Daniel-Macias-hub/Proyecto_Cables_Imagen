

function form_mencion(){
	

	var num = document.getElementById("num").value ;
 	 var estacion = document.getElementById("estacion").value ;
 	 var cliente = document.getElementById("cliente").value ;
 	 var producto = document.getElementById("producto").value ;
 	 var fecha = document.getElementById("fecha").value ;
 	 var hrt = document.getElementById("hrt").value ;
 	 var obs = document.getElementById("obs").value ;
 	 var pass= document.getElementById("password").value ;
	
	if (estacion == "0"){
		 document.getElementById("valid").style.display = "inline";
		 document.getElementById("valid").innerHTML= "<b>WARNING</b> : Debe seleccionar una  <b>Estación</b>";
		 setTimeout("ocultarvalid();", 5000);
		return false;
	}else if (cliente == ''){

		 document.getElementById("valid").style.display = "inline";
		 document.getElementById("valid").innerHTML= "<b>WARNING</b> : Debe seleccionar un  <b>Cliente</b>";
		 setTimeout("ocultarvalid();", 5000);
return false;

	} else if( producto == ''){
 document.getElementById("valid").style.display = "inline";
		 document.getElementById("valid").innerHTML= "<b>WARNING</b> : Debe seleccionar un  <b>Producto</b>";
		 setTimeout("ocultarvalid();", 5000);
	return false;
	}else if( fecha == ''){
 document.getElementById("valid").style.display = "inline";
		 document.getElementById("valid").innerHTML= "<b>WARNING</b> : Debe seleccionar una  <b>Fecha</b>";
		 setTimeout("ocultarvalid();", 5000);

		return false;
	}else if( hrt == ''){
 document.getElementById("valid").style.display = "inline";
		 document.getElementById("valid").innerHTML= "<b>WARNING</b> : Debe seleccionar un  <b>Hora</b>";
		 setTimeout("ocultarvalid();", 5000);
		return false;
	}else if( obs == ''){
 document.getElementById("valid").style.display = "inline";
		 document.getElementById("valid").innerHTML= "<b>WARNING</b> : Debe anotar sus <b>Observaciones</b>";
		 setTimeout("ocultarvalid();", 5000);
		 return false;
	}else if( pass == ''){
 document.getElementById("valid").style.display = "inline";
		 document.getElementById("valid").innerHTML= "<b>WARNING</b> : Debe ingresar una  <b>Firma</b>";
		 setTimeout("ocultarvalid();", 5000);
		return false;
	}
	return true;

}
function ocultarvalid(){
   document.getElementById("validSuccess").style.display = "none";
   document.getElementById("valid").style.display = "none";
}
window.onload = function(){
  var fecha = new Date(); //Fecha actual
  var mes = fecha.getMonth()+1; //obteniendo mes
  var dia = fecha.getDate(); //obteniendo dia
  var ano = fecha.getFullYear(); //obteniendo año
  var hora= fecha.getHours();
  var min= fecha.getMinutes();
  if(dia<10)
    dia='0'+dia; //agrega cero si el menor de 10
  if(mes<10)
    mes='0'+mes //agrega cero si el menor de 10
  document.getElementById('fecha').value=ano+"-"+mes+"-"+dia;
  document.getElementById('hrt').value=hora+":"+min;
}
function cargar() {
	
$('#myModal').modal('show');


 document.getElementById("num").value = "MAM00"+ document.getElementById("random").value;


}
function enviar_datos(){
 	 var num = document.getElementById("num").value ;
 	 var estacion = document.getElementById("estacion").value ;
 	 var cliente = document.getElementById("cliente").value ;
 	 var producto = document.getElementById("producto").value ;
 	 var fecha = document.getElementById("fecha").value ;
 	 var hrt = document.getElementById("hrt").value ;
 	 var obs = document.getElementById("obs").value ;

 	 var pass= document.getElementById("password").value ;
      var res;
     if(form_mencion() == true){
 	

       var parametro={"num": num, "estacion": estacion, "cliente": cliente, "producto": producto, "fecha": fecha, "hrt": hrt, "obs": obs, "firma": pass};
      
 $.ajax({
        data : parametro,
        url: 'subirpi.php',
       type: 'post',
        beforSend: function(){
          alert("procesando");
        },

        success: function (response){
       
          document.getElementById("validSuccess").style.display = "inline";
		 document.getElementById("validSuccess").innerHTML= response;
		 setTimeout("ocultarvalid();", 8000);
        

  
          
        }

     });
 

//$('#myModal').modal('hide');

}



}
