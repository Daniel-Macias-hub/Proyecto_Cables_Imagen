<?php
date_default_timezone_set('America/Mexico_City');
$today = date('Y-m-d');

$total_hoy = 0;
$audios_hoy = 0;
$notas_hoy = 0;

if($conn = @mysql_connect("localhost","root","d1nosauri0Z")) {
    mysql_select_db("cdcol", $conn);
    mysql_query("set names 'utf8'", $conn);
    
    // Total de registros hoy
    $q_total = mysql_query("SELECT COUNT(*) as c FROM pi WHERE fecha >= '$today 00:00:00'");
    if($q_total && $r = mysql_fetch_assoc($q_total)) {
        $total_hoy = $r['c'];
    }
    
    // Audios subidos hoy (suponiendo que rutamp3 tenga algo)
    $q_audios = mysql_query("SELECT COUNT(*) as c FROM pi WHERE fecha >= '$today 00:00:00' AND rutamp3 IS NOT NULL AND rutamp3 != '' AND rutamp3 != '-'");
    if($q_audios && $r = mysql_fetch_assoc($q_audios)) {
        $audios_hoy = $r['c'];
    }
    
    // Notas subidas hoy (todos los registros son notas de programa, así que podemos igualarlo al total o buscar los que tienen texto)
    $notas_hoy = $total_hoy;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bienvenido a Pi</title>
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
            overflow-x: hidden;
        }
        .dashboard-header {
            margin-bottom: 40px;
            animation: fadeInDown 0.6s ease-out;
        }
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .dashboard-header h1 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 5px;
            letter-spacing: -0.5px;
        }
        .dashboard-header p {
            font-size: 1rem;
            opacity: 0.6;
        }
        
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            animation: fadeInUp 0.8s ease-out;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .metric-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        [data-bs-theme="dark"] .metric-card {
            box-shadow: 0 10px 30px rgba(0,0,0,0.4);
        }
        .metric-card:hover {
            transform: translateY(-5px);
            border-color: rgba(227, 6, 19, 0.3);
            box-shadow: 0 15px 40px rgba(227, 6, 19, 0.1);
        }
        .metric-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 4px;
            height: 100%;
            background: var(--accent-color);
        }
        .metric-info {
            display: flex;
            flex-direction: column;
        }
        .metric-value {
            font-size: 2.8rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 5px;
            font-family: 'Arial Black', sans-serif;
        }
        .metric-label {
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.7;
        }
        .metric-icon {
            font-size: 3.5rem;
            opacity: 0.1;
            color: var(--accent-color);
        }
    </style>
    <script>
        function syncTheme() {
            const theme = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-bs-theme', theme);
        }
        syncTheme();
        window.addEventListener('storage', syncTheme);
    </script>
</head>
<body style="position: relative;">


<div class="dashboard-header">
    <h1><i class="fas fa-broadcast-tower" style="color: #E30613; margin-right: 15px;"></i>Sistema PI</h1>
    <p>Seleccione un programa en el menú lateral izquierdo para consultar notas o reproducir audios.</p>
</div>

<div class="metrics-grid">
    <div class="metric-card">
        <div class="metric-info">
            <span class="metric-value"><?= number_format($total_hoy) ?></span>
            <span class="metric-label">Total Hoy</span>
        </div>
        <i class="fas fa-chart-line metric-icon"></i>
    </div>
    
    <div class="metric-card">
        <div class="metric-info">
            <span class="metric-value"><?= number_format($notas_hoy) ?></span>
            <span class="metric-label">Notas Subidas</span>
        </div>
        <i class="fas fa-file-alt metric-icon"></i>
    </div>
    
    <div class="metric-card">
        <div class="metric-info">
            <span class="metric-value"><?= number_format($audios_hoy) ?></span>
            <span class="metric-label">Audios Subidos</span>
        </div>
        <i class="fas fa-headphones metric-icon"></i>
    </div>
</div>

</body>
</html>
