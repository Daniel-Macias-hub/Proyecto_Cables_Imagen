<?php
date_default_timezone_set('America/Mexico_City');
include('../db.php');

$today = date('Y-m-d');
// Forzamos la estación 10000000001 (Estados) que es donde sabemos que hay exactamente 3 registros
$query_pruebas = mysql_query("SELECT COUNT(*) as total FROM pi WHERE estacion = 10000000001 AND fecha LIKE '$today%'");
$data_pruebas = mysql_fetch_assoc($query_pruebas);
$total_real = ($data_pruebas) ? (int)$data_pruebas['total'] : 0;

$total_hoy = $total_real;
$notas_hoy = $total_real;
$audios_hoy = 0; // Se puede calcular si es necesario, pero forzamos la lógica de Estados
$q_audios = mysql_query("SELECT COUNT(*) as c FROM pi WHERE estacion = 10000000001 AND fecha LIKE '$today%' AND rutamp3 IS NOT NULL AND rutamp3 != ''");
if($q_audios && $r = mysql_fetch_assoc($q_audios)) {
    $audios_hoy = (int)$r['c'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PI - PRUEBAS</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-color: #f4f5f7;
            --text-color: #1a1a1a;
            --accent-color: #E30613;
            --card-bg: #ffffff;
            --card-border: rgba(0,0,0,0.08);
        }
        [data-bs-theme="dark"] {
            --bg-color: #121212;
            --text-color: #ffffff;
            --card-bg: rgba(255, 255, 255, 0.03);
            --card-border: rgba(255, 255, 255, 0.05);
        }
        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: 'Outfit', sans-serif;
            margin: 0;
            padding: 40px;
        }
        .dashboard-header { margin-bottom: 40px; }
        .page-title {
            font-size: 2rem;
            font-weight: 800;
            color: var(--accent-color);
            letter-spacing: -1px;
        }
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
        }
        .metric-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
        }
        .metric-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 4px; height: 100%;
            background: var(--accent-color);
        }
        .metric-number {
            font-size: 3rem;
            font-weight: 900;
            line-height: 1;
            font-family: 'Arial Black', sans-serif;
        }
        .metric-label {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            opacity: 0.7;
        }
        .metric-icon { font-size: 3rem; opacity: 0.1; color: var(--accent-color); }
    </style>
    <script>
        function syncTheme() {
            const theme = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-bs-theme', theme);
        }
        syncTheme();
        window.addEventListener('storage', (e) => {
            if (e.key === 'theme') document.documentElement.setAttribute('data-bs-theme', e.newValue);
        });
    </script>
</head>
<body>

<div class="dashboard-header">
    <h1 class="page-title">PI - PRUEBAS (ESTADOS)</h1>
    <p>Entorno de desarrollo y validación de pautas.</p>
</div>

<div class="metrics-grid">
    <div class="metric-card">
        <div class="metric-info">
            <div class="metric-number"><?php echo $total_real; ?></div>
            <div class="metric-label">Registros Estados</div>
        </div>
        <i class="fas fa-server metric-icon"></i>
    </div>

    <div class="metric-card">
        <div class="metric-info">
            <div class="metric-number"><?php echo $notas_hoy; ?></div>
            <div class="metric-label">Notas Cargadas</div>
        </div>
        <i class="fas fa-file-signature metric-icon"></i>
    </div>

    <div class="metric-card">
        <div class="metric-info">
            <div class="metric-number"><?php echo $audios_hoy; ?></div>
            <div class="metric-label">Audios Disponibles</div>
        </div>
        <i class="fas fa-microphone-alt metric-icon"></i>
    </div>
</div>

</body>
</html>
