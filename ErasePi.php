<html>
<head>

 
<meta name="author" content="Miguel MENDOZA">
<link href="xampp.css" rel="stylesheet" type="text/css">
<link href="style1.css" rel="stylesheet" type="text/css">
 <link rel="stylesheet" href="css/bootstrap.min.css">
 <link rel="stylesheet" href="js/bootstrap.min.js">
<!-- Bootstrap stylesheet -->
<link rel="stylesheet" type="text/css" href="clockpicker/assets/css/bootstrap.min.css">

<!-- ClockPicker Stylesheet -->
<link rel="stylesheet" type="text/css" href="clockpicker/dist/bootstrap-clockpicker.min.css">
<link rel="stylesheet" type="text/css" href="clockpicker/assets/css/github.min.css">
<!-- jQuery and Bootstrap scripts -->
<script type="text/javascript" src="clockpicker/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="clockpicker/assets/js/bootstrap.min.js"></script>

<!-- ClockPicker script -->
<script type="text/javascript" src="clockpicker/dist/bootstrap-clockpicker.min.js"></script>

<!-- Sweet Alertt -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.19.1/dist/sweetalert2.all.min.js" integrity="sha256-pYQrGA6LI+iNqLNslfPObC8AbGjVAQIZzGbRBgzHApc=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.19.1/dist/sweetalert2.min.css" integrity="sha256-J8SXTq+SCSrJ+GSCNWSoO3ef8idzOhhNAJRulSUr6mg=" crossorigin="anonymous">

<script type="text/javascript">

<?php 

$IDpi = $_REQUEST['PI']; 

?>

function signEvaluate()
{
 /*
	Swal.fire({
  title: "Submit your Github username",
  input: "text",
  inputAttributes: {
    autocapitalize: "off"
  },
  showConfirmButton: true,
  allowOutsideClick: false,
  allowEscapeKey: false,
  confirmButtonText: "Look up",
  showLoaderOnConfirm: true,
  preConfirm: async (login) => {
    try {
      const githubUrl = `
        https://api.github.com/users/${login}
      `;
      const response = await fetch(githubUrl);
      if (!response.ok) {
        return Swal.showValidationMessage(`
          ${JSON.stringify(await response.json())}
        `);
      }
      return response.json();
    } catch (error) {
      Swal.showValidationMessage(`
        Request failed: ${error}
      `);
    }
  },
  allowOutsideClick: () => !Swal.isLoading()
}).then((result) => {
  if (result.isConfirmed) {
    Swal.fire({
      title: `${result.value.login}'s avatar`,
      imageUrl: result.value.avatar_url
    });
  }
});*/
	
	var IdPI = <?php echo $IDpi; ?>
	
	swal.fire({
	title: "Valida Firma",
	type: "warning",
	html: "Ingresa una Firma Valida para eliminar",
	allowOutsideClick: false,
	//showCancelButton: true,
	//closeOnConfirm: true,
	//closeOnCancel: true,
	confirmButtonColor: "#DD6B55",
	cancelButtonText: "No",
	confirmButtonText: "Yes",
	input: "text",
	inputAttributes: {
    autocapitalize: "off"
	},
	preConfirm: (name) => {
        if (!name || name.trim() === "") {
            Swal.showValidationMessage("Firma Vacia!");
        }
    },
	confirmButtonText: "VALIDAR",
	}).then(function (result) 
	{
	 
					$.ajax({
                            url: 'EvaluateFirmaBorra.php?Firma='+result.value+'&PI='+IdPI,
							type: 'post',
							
                            success: function(response)
                            {
								//alert(response);
                                //console.log(response);
                                //window.location = self.location;
								//Swal.fire('Seguimiento Agregado!', '', 'success')
								if(response == 1)
								{
									Swal.fire('Firma Autorizada para Borrar Encontrada!', '', 'success')
								}
								else
								{
									location.reload();
								}
								
                            },
                            error: function() {
                                Swal.fire('Error, contactar al administrador',
                                    '', 'error');
									 location.reload();
                            }
                        });
	 });
}
</script>

</head>

<body onload="signEvaluate()">
</body>
</html>                     
		
