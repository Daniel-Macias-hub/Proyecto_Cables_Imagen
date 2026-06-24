<!DOCTYPE html>
<html lang="es">
<head>
    <title>Nuevo Registro PI</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Fonts & Bootstrap -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- ClockPicker Stylesheet -->
    <link rel="stylesheet" type="text/css" href="clockpicker/dist/bootstrap-clockpicker.min.css">
    
    <!-- jQuery and Bootstrap scripts -->
    <script type="text/javascript" src="clockpicker/assets/js/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="clockpicker/dist/bootstrap-clockpicker.min.js"></script>
    
    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.19.1/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.19.1/dist/sweetalert2.min.css">

    <style>
        :root {
            --bg-color: #f4f5f7;
            --card-bg: #ffffff;
            --text-color: #1a1a1a;
            --border-color: rgba(0,0,0,0.1);
            --input-bg: #ffffff;
            --input-border: #ced4da;
            --input-color: #495057;
            --accent-color: #E30613;
            --corp-blue: #009FE3;
        }
        [data-bs-theme="dark"] {
            --bg-color: #121212;
            --card-bg: #1e1e1e;
            --text-color: #ffffff;
            --border-color: rgba(255,255,255,0.1);
            --input-bg: #2a2a2a;
            --input-border: #333333;
            --input-color: #ffffff;
        }
        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: 'Outfit', sans-serif;
            padding: 40px;
        }
        .form-container {
            max-width: 900px;
            margin: 0 auto;
            background: var(--card-bg);
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            border: 1px solid var(--border-color);
            animation: fadeIn 0.4s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        [data-bs-theme="dark"] .form-container { box-shadow: 0 10px 40px rgba(0,0,0,0.5); }
        
        .form-header {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid var(--accent-color);
        }
        .form-header h2 {
            font-weight: 800;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.8rem;
        }
        .form-header h2 i { color: var(--accent-color); }
        
        /* Modern Inputs */
        .modern-label {
            font-weight: 700;
            font-size: 0.95rem;
            margin-bottom: 10px;
            opacity: 0.85;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .modern-input {
            background-color: var(--input-bg);
            border: 2px solid var(--input-border);
            color: var(--input-color);
            border-radius: 10px;
            padding: 14px 18px;
            font-size: 1.05rem;
            width: 100%;
            transition: all 0.25s;
        }
        .modern-input:focus {
            border-color: var(--corp-blue);
            box-shadow: 0 0 0 4px rgba(0, 159, 227, 0.15);
            outline: none;
            background-color: var(--input-bg);
            color: var(--input-color);
        }
        .modern-input[readonly] {
            opacity: 0.8;
            cursor: not-allowed;
            background-color: rgba(0,0,0,0.03);
            border-color: var(--border-color);
        }
        [data-bs-theme="dark"] .modern-input[readonly] { background-color: rgba(255,255,255,0.03); }

        /* Grid Layout */
        .grid-layout {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 25px;
        }
        .grid-full {
            grid-column: 1 / -1;
            margin-bottom: 30px;
        }
        
        /* Botones Corporativos */
        .btn-modern {
            padding: 16px 32px;
            border-radius: 10px;
            font-weight: 800;
            font-size: 1.1rem;
            letter-spacing: 1px;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: 100%;
        }
        .btn-brand {
            background-color: var(--accent-color);
            color: white;
            box-shadow: 0 6px 20px rgba(227, 6, 19, 0.2);
        }
        .btn-brand:hover {
            background-color: #c2000d;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(227, 6, 19, 0.4);
            color: white;
        }
    </style>
    
    <script>
        function syncTheme() {
            const theme = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-bs-theme', theme);
        }
        syncTheme();
        window.addEventListener('storage', syncTheme);

        function signEvaluate() {
            Swal.fire({
                title: "Valida Firma",
                type: "warning",
                html: "Por favor, Ingresa una Firma",
                allowOutsideClick: false,
                confirmButtonColor: "#DD6B55",
                cancelButtonText: "No",
                confirmButtonText: "VALIDAR",
                input: "text",
                inputAttributes: { autocapitalize: "off" },
                preConfirm: (name) => {
                    if (!name || name.trim() === "") {
                        Swal.showValidationMessage("Firma Vacia!");
                    }
                }
            }).then(function (result) {
                $.ajax({
                    url: 'EvaluateFirma.php?Firma=' + result.value,
                    type: 'post',
                    success: function(response) {
                        if(response == 1) {
                            Swal.fire({
                                title: 'Firma Encontrada!', 
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        } else {
                            location.reload();
                        }
                    },
                    error: function() {
                        Swal.fire('Error, contactar al administrador', '', 'error');
                        location.reload();
                    }
                });
            });
        }

        function initForm() {
            // Generar ID random
            const d = Math.floor(Math.random() * 1000000) + 2;
            document.getElementById("num").value = "MAN00" + d;
            
            // Setear fecha actual por defecto
            document.getElementById("fecha").valueAsDate = new Date();
            
            // Validar firma
            signEvaluate();
        }

        function enviar_datos() {
            var num = document.getElementById("num").value;
            var estacion = document.getElementById("estacion").value;
            var cliente = document.getElementById("cliente").value;
            var producto = document.getElementById("producto").value;
            var fecha = document.getElementById("fecha").value;
            var hrt = document.getElementById("hrt").value;
            var obs = document.getElementById("obs").value;

            // Validaciones
            if(!producto) { Swal.fire('Atención', 'Debe ingresar un Producto.', 'warning'); return; }
            if(!hrt) { Swal.fire('Atención', 'Debe asignar una Hora.', 'warning'); return; }

            var parametro = {
                "num": num, "estacion": estacion, "cliente": cliente, 
                "producto": producto, "fecha": fecha, "hrt": hrt, "obs": obs
            };

            // Loading state
            Swal.fire({
                title: 'Procesando...',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });

            $.ajax({
                data: parametro,
                url: 'subirpi.php',
                type: 'post',
                success: function (response) {
                    Swal.fire('¡Éxito!', 'Registro agregado correctamente.', 'success')
                    .then(() => {
                        // Limpiar formulario o ir al historial
                        window.location.href = 'consultar_historial_pi.php';
                    });
                },
                error: function() {
                    Swal.fire('Error', 'Hubo un problema al guardar los datos.', 'error');
                }
            });
        }

        window.onload = initForm;
    </script>
</head>

<body>

<div class="form-container">
    <div class="form-header">
        <h2><i class="fas fa-folder-plus"></i> Nuevo Registro de Programación</h2>
    </div>

    <form onsubmit="event.preventDefault(); enviar_datos();">
        
        <div class="grid-layout">
            <div>
                <div class="modern-label">Número de Registro</div>
                <input type="text" id="num" class="modern-input" readonly>
            </div>
            <div>
                <div class="modern-label">Estación</div>
                <select id="estacion" class="modern-input">
                    <option value="0">Seleccione...</option>
                    <option selected value="10000000001">XEDA</option>
                </select>
            </div>
        </div>

        <div class="grid-layout">
            <div>
                <div class="modern-label">Producto / Nombre</div>
                <input type="text" id="producto" class="modern-input" placeholder="Ej: Entrevista exclusiva">
            </div>
            <div>
                <div class="modern-label">Cliente</div>
                <input type="text" id="cliente" class="modern-input" placeholder="Nombre del cliente o marca">
            </div>
        </div>

        <div class="grid-layout">
            <div>
                <div class="modern-label">Fecha de Programación</div>
                <input type="date" id="fecha" class="modern-input">
            </div>
            <div>
                <div class="modern-label">Hora de Transmisión</div>
                <div class="input-group clockpicker" data-placement="bottom" data-align="top" data-autoclose="true">
                    <input type="text" id="hrt" name="hrt" class="modern-input" maxlength="10" placeholder="00:00" style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                    <span class="input-group-text" style="background-color: var(--input-bg); border-color: var(--input-border); color: var(--input-color); border-width: 2px; border-left: none;">
                        <i class="fas fa-clock" style="color: var(--corp-blue);"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="grid-full">
            <div class="modern-label">Observaciones</div>
            <textarea id="obs" class="modern-input" rows="4" placeholder="Agrega cualquier detalle, indicación o nota relevante..."></textarea>
        </div>

        <div class="mt-4">
            <button type="button" class="btn-modern btn-brand" onclick="enviar_datos();">
                <i class="fas fa-save"></i> GUARDAR REGISTRO
            </button>
        </div>
    </form>
</div>

<script type='text/javascript'>
    $('.clockpicker').clockpicker(); 
</script>

</body>
</html>
