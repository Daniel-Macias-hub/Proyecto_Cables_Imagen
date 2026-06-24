<?php
if(!session_id()) session_start();
if(!isset($_SESSION['server'])) {
    $_SESSION['server'] = "http://10.29.128.198";
}
$server = $_SESSION['server'];

$raw_path = isset($_GET['path']) ? $_GET['path'] : '';

if (empty($raw_path)) {
    die("Error: Ruta de cable no proporcionada.");
}

// Limpiar el path para asegurar que lo pasamos limpio al host original
if (strpos($raw_path, '/') !== 0) {
    $raw_path = '/' . $raw_path;
}

$full_url = $server . $raw_path;
$content = @file_get_contents($full_url);

if ($content === false) {
    $content = "<div class='alert alert-danger border-0 shadow-sm'>
                    <h5 class='alert-heading'>El cable está dañado o inaccesible</h5>
                    <p>No se pudo establecer comunicación con el archivo Legacy en <b>$full_url</b>.</p>
                </div>";
} else {
    // Limpieza agresiva del cochambre Legacy (Cabeceras y tags que rompen nuestro DOM)
    $content = preg_replace('/<head\b[^>]*>(.*?)<\/head>/is', '', $content);
    $content = str_ireplace(['<html>', '</html>', '<body>', '</body>'], '', $content);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lector de Noticias (Cable)</title>
    <!-- Google Fonts: Outfit (Imagen Style) y Open Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: transparent;
            padding: 15px;
            font-family: 'Open Sans', sans-serif;
            transition: background-color 0.3s, color 0.3s;
        }
        .cable-card {
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
            transition: background-color 0.3s, color 0.3s;
        }
        
        /* Contenido inyectado */
        .legacy-content {
            font-size: 1.15rem;
            line-height: 1.7;
            color: inherit;
        }
        .legacy-content h4 {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 1.8rem;
            margin-bottom: 20px;
            border-bottom: 3px solid #E30613;
            padding-bottom: 10px;
        }
        .text-subtle {
            opacity: 0.6;
        }

        /* Ajustes extra para modo oscuro */
        html[data-bs-theme="dark"] body { color: #f8f9fa; }
        html[data-bs-theme="dark"] .legacy-content h4 { border-bottom-color: rgba(255,255,255,0.1); }
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <!-- Contenedor centralizado para el viejo HTML -->
    <div class="card cable-card border-0">
        <div class="card-body p-5 legacy-content">
            <?= $content ?>
        </div>
    </div>
</div>

<script>
// Sincronización instantánea de Dark Theme con el contenedor padre o localStorage
function syncTheme() {
    try {
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
        } else if (window.parent && window.parent.document) {
            const parentTheme = window.parent.document.documentElement.getAttribute('data-bs-theme');
            if (parentTheme) {
                document.documentElement.setAttribute('data-bs-theme', parentTheme);
            }
        }
    } catch (e) {
        console.warn("No se pudo sincronizar el tema.");
    }
}
syncTheme();

if(window.parent) {
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.attributeName === "data-bs-theme") syncTheme();
        });
    });
    observer.observe(window.parent.document.documentElement, { attributes: true });
}
</script>

</body>
</html>
