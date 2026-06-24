<?php
if(!session_id()) session_start();
include_once('db.php');
date_default_timezone_set('America/Mexico_City');

// Consulta completa de cables para la lista lateral
$result = mysql_query("SELECT titulo, age, cat, fecha, hora, path, urge FROM cables ORDER BY fecha DESC, hora DESC LIMIT 150", $conn);

// Contadores para el Welcome Hub
$cnt_afp = 0; $cnt_rtr = 0; $cnt_dpa = 0; $cnt_ntx = 0; $cnt_ap = 0;
$c_res = mysql_query("SELECT age, COUNT(*) as t FROM cables WHERE fecha >= CURDATE() GROUP BY age", $conn);
if($c_res) {
    while($c_row = mysql_fetch_array($c_res)) {
        $a = strtoupper($c_row['age']);
        if($a == 'AFP') $cnt_afp = $c_row['t'];
        elseif($a == 'RTR' || $a == 'REUTERS') $cnt_rtr += $c_row['t'];
        elseif($a == 'DPA') $cnt_dpa = $c_row['t'];
        elseif($a == 'NTX') $cnt_ntx = $c_row['t'];
        elseif($a == 'AP')  $cnt_ap = $c_row['t'];
    }
}
$total_cables = $cnt_afp + $cnt_rtr + $cnt_dpa + $cnt_ntx + $cnt_ap;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Imagen TV</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root { --imagen-red: #E30613; --imagen-blue: #009FE3; --gimm-scale: 1; }
        
        @media (min-width: 1400px) { :root { --gimm-scale: 1.1; } }
        @media (min-width: 1900px) { :root { --gimm-scale: 1.25; } }

        html { font-size: calc(16px * var(--gimm-scale)); }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        /* === VARIABLES DE TEMA === */
        :root {
            --bg-main: #f0f2f5;
            --bg-panel: #ffffff;
            --bg-panel-border: rgba(0,0,0,0.08);
            --bg-panel-header-border: rgba(0,0,0,0.07);
            --bg-card: rgba(0,0,0,0.04);
            --bg-card-border: rgba(0,0,0,0.1);
            --bg-cable-hover: rgba(0,0,0,0.04);
            --bg-cable-active: rgba(227,6,19,0.08);
            --bg-right-panel: #e8eaed;
            --color-text: #1a1a1a;
            --color-text-muted: #777;
            --color-text-dim: #aaa;
            --color-title: var(--imagen-red);
            --color-value: #1a1a1a;
            --color-scrollbar: rgba(0,0,0,0.2);
            --color-footer-border: rgba(0,0,0,0.07);
            --color-footer-text: #aaa;
            --tile4-bg: #fff;
            --logo-label-color: #1a1a1a;
        }
        html[data-bs-theme="dark"] {
            --bg-main: #0a0a0a;
            --bg-panel: #0d0d0d;
            --bg-panel-border: rgba(255,255,255,0.06);
            --bg-panel-header-border: rgba(255,255,255,0.07);
            --bg-card: rgba(255,255,255,0.03);
            --bg-card-border: rgba(255,255,255,0.07);
            --bg-cable-hover: rgba(255,255,255,0.04);
            --bg-cable-active: rgba(227,6,19,0.08);
            --bg-right-panel: #000;
            --color-text: #fff;
            --color-text-muted: #666;
            --color-text-dim: #555;
            --color-title: var(--imagen-red);
            --color-value: #fff;
            --color-scrollbar: #333;
            --color-footer-border: rgba(255,255,255,0.05);
            --color-footer-text: #333;
            --tile4-bg: #000;
            --logo-label-color: #fff;
        }

        body {
            background: var(--bg-main);
            color: var(--color-text);
            font-family: 'Segoe UI', Roboto, sans-serif;
            height: 100vh;
            overflow: hidden;
            transition: background 0.3s, color 0.3s;
        }
        .outfit { font-family: 'Outfit', sans-serif; }

        /* ===== RESPONSIVE BREAKPOINTS ===== */

        /* Pantallas pequeñas (laptop 12", tablets) */
        @media (max-width: 1100px) {
            body { height: auto; overflow: auto; }
            .main-layout { flex-direction: row; height: auto; min-height: 100vh; }
            .left-panel  { width: 42%; height: 100vh; position: sticky; top: 0; }
            .right-panel { width: 58%; height: 100vh; position: sticky; top: 0; }
            .panel-header { padding: 16px 20px 12px; }
            .panel-header h1 { font-size: 2rem; }
            .support-row { padding: 10px 20px; gap: 8px; }
            .support-card { padding: 8px 12px; gap: 8px; }
            .support-card .value { font-size: 0.9rem; }
            .list-header { padding: 8px 20px 6px; }
            .cables-list { padding: 0 8px 12px; }
        }

        /* Tablets en portrait y móviles grandes */
        @media (max-width: 768px) {
            body { height: auto; overflow: auto; }
            .main-layout { flex-direction: column; height: auto; width: 100%; }
            .left-panel {
                width: 100%;
                height: auto;
                max-height: 60vh;
                position: relative;
            }
            .right-panel {
                width: 100%;
                height: 40vh;
                position: relative;
            }
            .panel-header { padding: 14px 16px 10px; }
            .panel-header h1 { font-size: 1.7rem; letter-spacing: -0.5px; }
            .support-row { padding: 8px 16px; }
            .support-card { padding: 8px 10px; gap: 8px; }
            .support-card .value { font-size: 0.85rem; }
            .list-header { padding: 6px 16px; }
            .cables-list { max-height: 30vh; }
            .panel-footer { padding: 8px 16px; }
            #close-note-btn { top: 8px; right: 8px; font-size: 0.72rem; padding: 5px 10px; }
        }

        /* Móviles pequeños */
        @media (max-width: 480px) {
            .panel-header h1 { font-size: 1.4rem; }
            .support-row { flex-direction: column; padding: 8px 12px; }
            .cable-title { font-size: 0.8rem; }
        }

        .main-layout { display: flex; height: 100vh; width: 100vw; }

        /* === PANEL IZQUIERDO === */
        .left-panel {
            width: 35%;
            height: 100%;
            display: flex;
            flex-direction: column;
            background: var(--bg-panel);
            border-right: 1px solid var(--bg-panel-border);
            flex-shrink: 0;
            transition: background 0.3s;
        }

        .panel-header {
            padding: 28px 32px 20px;
            border-bottom: 1px solid var(--bg-panel-header-border);
            flex-shrink: 0;
        }
        .panel-header h1 {
            font-size: 2.8rem;
            letter-spacing: -1.5px;
            color: var(--color-title);
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            line-height: 1;
        }
        .panel-header .subtitle {
            font-size: 0.7rem;
            letter-spacing: 3px;
            color: var(--color-text-muted);
            text-transform: uppercase;
            margin-top: 4px;
        }

        .support-row { display: flex; gap: 10px; padding: 16px 32px; flex-shrink: 0; }
        .support-card {
            flex: 1;
            background: var(--bg-card);
            border: 1px solid var(--bg-card-border);
            border-radius: 12px;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: border-color 0.3s, background 0.3s;
        }
        .support-card:hover { border-color: var(--imagen-red); }
        .support-card .icon { font-size: 1.4rem; }
        .support-card .label { font-size: 0.65rem; color: var(--color-text-muted); font-family: 'Outfit', sans-serif; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; }
        .support-card .value { font-size: 1rem; font-weight: 700; color: var(--color-value); }
        .support-card a.value { color: var(--color-value); text-decoration: none; }
        .support-card a.value:hover { color: var(--imagen-red); }

        .list-header {
            padding: 10px 32px 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
        }
        .list-header .list-title { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; color: var(--color-text-muted); font-family: 'Outfit', sans-serif; }
        .list-header .refresh-btn { font-size: 0.72rem; color: var(--color-text-dim); background: none; border: none; cursor: pointer; transition: color 0.3s; }
        .list-header .refresh-btn:hover { color: var(--imagen-red); }

        .cables-list {
            flex: 1;
            overflow-y: auto;
            padding: 0 12px 16px;
            scrollbar-width: thin;
            scrollbar-color: var(--color-scrollbar) transparent;
        }
        .cables-list::-webkit-scrollbar { width: 4px; }
        .cables-list::-webkit-scrollbar-thumb { background: var(--color-scrollbar); border-radius: 2px; }

        .cable-row {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            border-left: 3px solid transparent;
            margin-bottom: 2px;
        }
        .cable-row:hover { background: var(--bg-cable-hover); border-left-color: var(--imagen-red); }
        .cable-row.active { background: var(--bg-cable-active); border-left-color: var(--imagen-red); }
        .cable-row.urge-3 { background: rgba(220,53,69,0.1); }
        .cable-row.urge-2 { background: rgba(255,193,7,0.08); }

        .agency-badge { display: inline-block; padding: 3px 7px; border-radius: 5px; font-size: 0.62rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; font-family: 'Outfit', sans-serif; flex-shrink: 0; margin-top: 2px; }
        .bg-afp { background: #009fe3; color: #fff; }
        .bg-rtr { background: #333; color: #fff; border: 1px solid #555; }
        .bg-ntx { background: var(--imagen-red); color: #fff; }
        .bg-ap  { background: #000; color: #fff; border: 1px solid #444; }
        .bg-dpa { background: #f7941d; color: #fff; }
        .bg-gen { background: #555; color: #fff; }

        .cable-info { flex: 1; min-width: 0; }
        .cable-title { font-size: 0.9rem; font-weight: 700; color: var(--color-text); line-height: 1.35; margin-bottom: 3px; white-space: normal; font-family: 'Outfit', sans-serif; }
        .cable-meta { font-size: 0.75rem; color: var(--color-text-dim); font-weight: 600; }

        .panel-footer {
            padding: 10px 32px;
            border-top: 1px solid var(--color-footer-border);
            font-size: 0.7rem;
            color: var(--color-footer-text);
            text-align: center;
            font-family: 'Outfit', sans-serif;
            flex-shrink: 0;
        }

        /* === PANEL DERECHO — ANIMACIÓN IMAGEN === */
        .right-panel {
            width: 65%;
            height: 100%;
            position: relative;
            background: #0a0a0a;
            overflow: hidden;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.4s;
        }
        html[data-bs-theme="light"] .right-panel { background: #e8eaed; }

        /* Contenedor de la animación */
        #anim-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            position: absolute;
            inset: 0;
        }

        /* Loader principal */
        .imagen-loader {
            --sz: 22vmin;
            position: relative;
            width: var(--sz);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: calc(var(--sz) * 0.06);
            animation: loaderPulse 3000ms ease-in-out infinite;
        }
        .imagen-loader::before {
            content: "";
            position: absolute;
            width: 260%;
            height: 260%;
            top: -80%;
            left: -80%;
            background: radial-gradient(
                circle,
                rgba(0,159,227,0.12) 0%,
                rgba(227,6,19,0.08) 40%,
                transparent 70%
            );
            pointer-events: none;
            border-radius: 50%;
        }

        /* Círculo azul — punto de la "i" */
        .logo-dot {
            width: var(--sz);
            height: var(--sz);
            border-radius: 50%;
            background: #009FE3;
            box-shadow:
                0 0 calc(var(--sz)*0.15) #009FE3cc,
                0 0 calc(var(--sz)*0.4)  #009FE366,
                0 0 calc(var(--sz)*0.7)  #009FE322;
            animation: glowPulseBlue 2400ms ease-in-out infinite;
            flex-shrink: 0;
        }

        /* Cuadrado rojo — cuerpo de la "i" */
        .logo-body {
            width: var(--sz);
            height: calc(var(--sz) * 1.1);
            background: #E30613;
            border-radius: calc(var(--sz) * 0.05);
            box-shadow:
                0 0 calc(var(--sz)*0.15) #E30613cc,
                0 0 calc(var(--sz)*0.4)  #E3061366,
                0 0 calc(var(--sz)*0.7)  #E3061322;
            animation: glowPulseRed 2400ms ease-in-out infinite;
            animation-delay: 1200ms;
            flex-shrink: 0;
        }

        /* Etiqueta IMAGEN debajo */
        .imagen-label {
            margin-top: calc(var(--sz) * 0.22);
            font-family: 'Arial Black', 'Outfit', sans-serif;
            font-weight: 900;
            font-size: calc(var(--sz) * 0.22);
            letter-spacing: 5px;
            color: #ffffff;
            text-shadow: 0 0 20px rgba(255,255,255,0.3);
            text-transform: uppercase;
            white-space: nowrap;
            text-align: center;
        }
        html[data-bs-theme="light"] .imagen-label { color: #1a1a1a; text-shadow: none; }

        @keyframes glowPulseBlue {
            0%,100% {
                box-shadow:
                    0 0 calc(var(--sz)*0.15) #009FE3cc,
                    0 0 calc(var(--sz)*0.4)  #009FE366,
                    0 0 calc(var(--sz)*0.7)  #009FE322;
                filter: brightness(1);
            }
            50% {
                box-shadow:
                    0 0 calc(var(--sz)*0.25) #009FE3ff,
                    0 0 calc(var(--sz)*0.6)  #009FE399,
                    0 0 calc(var(--sz)*1.0)  #009FE344;
                filter: brightness(1.15);
            }
        }
        @keyframes glowPulseRed {
            0%,100% {
                box-shadow:
                    0 0 calc(var(--sz)*0.15) #E30613cc,
                    0 0 calc(var(--sz)*0.4)  #E3061366,
                    0 0 calc(var(--sz)*0.7)  #E3061322;
                filter: brightness(1);
            }
            50% {
                box-shadow:
                    0 0 calc(var(--sz)*0.25) #E30613ff,
                    0 0 calc(var(--sz)*0.6)  #E3061399,
                    0 0 calc(var(--sz)*1.0)  #E3061344;
                filter: brightness(1.15);
            }
        }
        @keyframes loaderPulse {
            0%,100% { transform: scale(1)    translateY(0);     }
            50%     { transform: scale(0.92) translateY(-4px);  }
        }

        /* --- BIENVENIDO HUB --- */
        .welcome-hub {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            text-align: center;
            animation: fadeInHub 0.8s ease-out;
        }
        @keyframes fadeInHub { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        .hub-card {
            background: var(--bg-panel);
            border: 1px solid var(--bg-panel-border);
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 800px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            text-align: center;
            backdrop-filter: blur(10px);
        }
        html[data-bs-theme="dark"] .hub-card { box-shadow: 0 20px 50px rgba(0,0,0,0.4); }

        .hub-icon {
            width: 80px; height: 80px;
            background: rgba(227,6,19,0.1);
            color: var(--imagen-red);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .hub-title { font-family: 'Outfit', sans-serif; font-size: 2.2rem; font-weight: 800; margin-bottom: 10px; }
        .hub-subtitle { color: var(--color-text-muted); font-size: 1rem; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 30px; }

        .stat-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 12px;
            margin-bottom: 30px;
        }
        .stat-chip {
            background: var(--bg-card);
            border: 1px solid var(--bg-panel-border);
            padding: 8px 16px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.85rem;
            min-width: 120px;
            justify-content: center;
            font-family: 'Outfit', sans-serif;
            font-weight: 600;
        }
        .stat-chip .dot { width: 8px; height: 8px; border-radius: 50%; }
        .stat-chip .val { color: var(--imagen-red); font-weight: 800; }

        #note-viewer { position: absolute; inset: 0; width: 100%; height: 100%; border: none; display: none; }

        #close-note-btn {
            position: absolute;
            top: 16px;
            right: 16px;
            z-index: 100;
            background: rgba(0,0,0,0.6);
            border: 1px solid rgba(255,255,255,0.2);
            color: #fff;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.78rem;
            cursor: pointer;
            backdrop-filter: blur(8px);
            display: none;
            font-family: 'Outfit', sans-serif;
            transition: all 0.3s;
        }
        #close-note-btn:hover { background: var(--imagen-red); border-color: var(--imagen-red); }
    </style>
</head>
<body>

<div class="main-layout">

    <!-- ===== PANEL IZQUIERDO ===== -->
    <div class="left-panel">

        <!-- Lista de Cables -->
        <div class="list-header">
            <span class="list-title"><i class="bi bi-broadcast text-danger me-1"></i>Últimos Cables</span>
            <button class="refresh-btn" onclick="window.location.reload()">
                <i class="bi bi-arrow-clockwise me-1"></i>Refrescar
            </button>
        </div>

        <div class="cables-list" id="cables-list">
            <?php
            if ($result && mysql_num_rows($result) > 0) {
                while ($row = mysql_fetch_array($result)) {
                    $path  = isset($row['path'])   ? $row['path']   : '';
                    $age   = isset($row['age'])    ? strtoupper($row['age']) : 'N/A';
                    $titulo = isset($row['titulo']) ? $row['titulo'] : 'Sin Título';
                    $fecha = isset($row['fecha'])  ? $row['fecha']  : '';
                    $hora  = isset($row['hora'])   ? $row['hora']   : '';
                    $urge  = isset($row['urge'])   ? $row['urge']   : '';

                    $urgeClass = '';
                    if ($urge == '3') $urgeClass = 'urge-3';
                    elseif ($urge == '2') $urgeClass = 'urge-2';

                    $logoHtml = '';
                    if ($age == 'AFP') { 
                        $logoHtml = "
                        <svg viewBox=\"0 0 120 50\" width=\"65\" height=\"28\" style=\"filter: drop-shadow(0px 2px 3px rgba(0,0,0,0.2));\">
                          <rect width=\"120\" height=\"50\" fill=\"#0072b9\" rx=\"6\" />
                          <text x=\"60\" y=\"37\" font-family=\"'Arial Black', Impact, sans-serif\" font-size=\"36\" font-weight=\"900\" font-style=\"italic\" fill=\"#ffffff\" text-anchor=\"middle\" letter-spacing=\"-1.5\">AFP</text>
                        </svg>";
                    } elseif ($age == 'RTR' || $age == 'REUTERS') { 
                        $age = 'RTR';
                        $logoHtml = "
                        <div style='display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 3px;'>
                          <svg viewBox=\"0 0 100 100\" width=\"28\" height=\"28\">
                            <g fill=\"#f08100\">
                              <circle cx=\"50\" cy=\"50\" r=\"6\"/>
                              <circle cx=\"50\" cy=\"30\" r=\"4.5\"/><circle cx=\"50\" cy=\"70\" r=\"4.5\"/>
                              <circle cx=\"30\" cy=\"50\" r=\"4.5\"/><circle cx=\"70\" cy=\"50\" r=\"4.5\"/>
                              <circle cx=\"36\" cy=\"36\" r=\"4.5\"/><circle cx=\"64\" cy=\"64\" r=\"4.5\"/>
                              <circle cx=\"36\" cy=\"64\" r=\"4.5\"/><circle cx=\"64\" cy=\"36\" r=\"4.5\"/>
                              <circle cx=\"50\" cy=\"14\" r=\"5.5\"/><circle cx=\"50\" cy=\"86\" r=\"5.5\"/>
                              <circle cx=\"14\" cy=\"50\" r=\"5.5\"/><circle cx=\"86\" cy=\"50\" r=\"5.5\"/>
                              <circle cx=\"24\" cy=\"24\" r=\"5.5\"/><circle cx=\"76\" cy=\"76\" r=\"5.5\"/>
                              <circle cx=\"24\" cy=\"76\" r=\"5.5\"/><circle cx=\"76\" cy=\"24\" r=\"5.5\"/>
                            </g>
                          </svg>
                          <div style='font-family: Arial, sans-serif; font-size: 10px; font-weight: 800; color: #555; letter-spacing: 0.5px;'>REUTERS</div>
                        </div>";
                    } elseif ($age == 'NTX' || $age == 'NOTIMEX') { 
                        $age = 'NTX';
                        $logoHtml = "
                        <div style='display: flex; flex-direction: column; align-items: center;'>
                          <svg viewBox=\"0 0 160 60\" width=\"65\" height=\"24\">
                            <text x=\"0\" y=\"48\" font-family=\"'Arial Black', Impact, sans-serif\" font-size=\"60\" font-weight=\"900\" fill=\"#cc141d\" letter-spacing=\"-3\">NTX</text>
                            <circle cx=\"124\" cy=\"30\" r=\"7\" fill=\"#cc141d\"/>
                            <path d=\"M 124 16 A 14 14 0 0 1 124 44\" stroke=\"#cc141d\" stroke-width=\"4.5\" fill=\"none\" stroke-linecap=\"round\"/>
                            <path d=\"M 124 4 A 26 26 0 0 1 124 56\" stroke=\"#cc141d\" stroke-width=\"4.5\" fill=\"none\" stroke-linecap=\"round\"/>
                          </svg>
                          <div style='font-family: \"Arial Black\", Arial, sans-serif; font-size: 9px; font-weight: 900; color: #555; letter-spacing: 1px; margin-top: 1px;'>NOTIMEX</div>
                        </div>";
                    } elseif ($age == 'AP')  { 
                        $logoHtml = "
                        <div style='display: flex; flex-direction: column; align-items: center;'>
                          <svg viewBox=\"0 0 100 60\" width=\"42\" height=\"25\">
                            <text x=\"50\" y=\"55\" font-family=\"'Times New Roman', Times, serif\" font-size=\"68\" font-weight=\"bold\" fill=\"#e31837\" text-anchor=\"middle\" letter-spacing=\"-4\">AP</text>
                          </svg>
                          <div style='font-family: \"Arial Black\", Impact, sans-serif; font-size: 7.5px; font-weight: 900; color: #000; letter-spacing: 0px; margin-top: -2px;'>Associated Press</div>
                        </div>";
                    } elseif ($age == 'DPA') { 
                        $logoHtml = "
                        <div style='display: flex; align-items: center; justify-content: center; padding-bottom: 4px;'>
                          <span style='font-family: \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 32px; font-weight: 800; color: #00d1b2; letter-spacing: -2px; line-height: 1;'>dpa</span>
                          <div style='display: flex; margin-left: 5px; gap: 3px; margin-top: 5px;'>
                            <span style='width: 7px; height: 7px; background-color: #00d1b2; border-radius: 50%;'></span>
                            <span style='width: 7px; height: 7px; background-color: #00d1b2; border-radius: 50%;'></span>
                            <span style='width: 7px; height: 7px; background-color: #00d1b2; border-radius: 50%;'></span>
                          </div>
                        </div>";
                    } else {
                        $logoHtml = "<div style='background:#555; color:white; font-family:Arial, sans-serif; font-weight:bold; padding:4px 8px; border-radius:3px; font-size:12px; text-align:center;'>$age</div>";
                    }

                    $safe_path = htmlspecialchars($path, ENT_QUOTES);
                    $safe_titulo = htmlspecialchars($titulo);

                    echo "<div class=\"cable-row $urgeClass\" data-path=\"$safe_path\" onclick=\"openNote(this)\">";
                    echo "  <div style=\"width: 75px; flex-shrink: 0; display: flex; justify-content: center; align-items: center; margin-right: 5px; margin-top: 4px;\">";
                    echo "      $logoHtml";
                    echo "  </div>";
                    echo "  <div class=\"cable-info\">";
                    echo "    <div class=\"cable-title\">$safe_titulo</div>";
                    echo "    <div class=\"cable-meta\">$fecha &nbsp;·&nbsp; $hora</div>";
                    echo "  </div>";
                    echo "</div>";
                }
            } else {
                echo "
                <div style='padding: 80px 20px; text-align: center; background: transparent;'>
                    
                    <div style='display: flex; align-items: center; justify-content: center; margin-bottom: 40px;'>
                        <div style='display: flex; flex-direction: column; gap: 5px; margin-right: 15px;'>
                            <div style='width: 38px; height: 38px; background-color: #009fe3; border-radius: 50%;'></div>
                            <div style='width: 38px; height: 38px; background-color: #e30613;'></div>
                        </div>
                        <div style='display: flex; flex-direction: column; align-items: flex-start; justify-content: center;'>
                            <div style='font-family: \"Arial Black\", Impact, sans-serif; font-size: 46px; font-weight: 900; color: var(--color-text); line-height: 0.85; letter-spacing: -0.5px;'>IMAGEN</div>
                            <div style='font-family: \"Outfit\", Arial, sans-serif; font-size: 23px; font-weight: 500; color: var(--color-text); line-height: 1; letter-spacing: 1.5px; margin-top: 2px;'>TELEVISIÓN</div>
                        </div>
                    </div>

                    <h5 style='color: var(--color-text-muted); font-family: \"Outfit\", sans-serif; font-weight: 600; margin-bottom: 40px; font-size: 1.5rem; line-height: 1.4;'>Por el momento no se encuentran cables<br>disponibles</h5>
                    
                    <svg id='emptySvgLanding' viewBox='0 0 800 600' xmlns='http://www.w3.org/2000/svg' style='width: 100%; max-height: 280px; margin: 0 auto; display: block; visibility: hidden;'>
                        <g class='dotsLanding'>
                            <circle class='mainDotLanding' cx='300' cy='300' r='12.5' fill='#E30613'/>
                            <g class='otherDotsLanding' fill='#009FE3'>
                                <circle cx='340' cy='300' r='12.5' />
                                <circle cx='380' cy='300' r='12.5' />
                                <circle cx='420' cy='300' r='12.5' />
                                <circle cx='460' cy='300' r='12.5' />
                                <circle cx='500' cy='300' r='12.5' />
                            </g>
                        </g>
                    </svg>
                </div>
                <script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js'></script>
                <script>
                    if (typeof gsap !== 'undefined') {
                        gsap.set('#emptySvgLanding', { visibility: 'visible' });
                        var tl = gsap.timeline({repeat: -1}).timeScale(1.42);
                        tl.to('.mainDotLanding', { duration: 1, x: 240, ease: 'sine.inOut' })
                          .to('.otherDotsLanding circle', { duration: 0.3, y: -40, ease: 'sine.out', stagger: {each: 0.09, from: 'start'} }, 0.06)
                          .to('.otherDotsLanding circle', { duration: 0.7, y: 0, ease: 'bounce.out', stagger: {each: 0.09, from: 'start'} }, 0.48)
                          .to('.otherDotsLanding circle', { duration: 0.7, scaleY: 0.75, scaleX: 1.2, transformOrigin: 'bottom', ease: 'power1.inOut', stagger: {each: 0.09, from: 'start'} }, 0.48)
                          .to('.otherDotsLanding circle', { duration: 1, x: -40, ease: 'expo.out', stagger: {each: 0.09, from: 'start'} }, 0.68)
                          .to('.mainDotLanding', { duration: 1.8, x: 200, ease: 'elastic.out(1, 0.4)' }, 1);
                    }
                </script>
                ";
            }
            ?>
        </div>

        <div class="panel-footer">IMAGEN TELEVISIÓN &copy; <?= date('Y') ?></div>
    </div>

    <!-- ===== PANEL DERECHO ===== -->
    <div class="right-panel">

        <!-- Bienvenido Hub (Se muestra cuando no hay nota abierta) -->
        <div id="anim-wrapper" class="welcome-hub">
            <div class="hub-card">
                <div class="d-flex justify-content-center">
                    <div class="hub-icon"><i class="bi bi-broadcast"></i></div>
                </div>
                <h2 class="hub-title">Bienvenido a Cables</h2>
                <div class="hub-subtitle">SISTEMA DE RECEPCIÓN DE CABLES</div>
                
                <div style="background: var(--bg-card); padding: 15px 25px; border-radius: 15px; margin-bottom: 25px;">
                    <div style="font-size: 0.8rem; color: var(--color-text-dim); text-transform: uppercase; letter-spacing: 2px;">Publicado hoy</div>
                    <div style="font-size: 2.5rem; font-weight: 900; color: var(--imagen-red); font-family: 'Outfit';">
                        <?= number_format($total_cables) ?> <span style="font-size: 1rem; font-weight: 400; color: var(--color-text-muted);">NOTAS</span>
                    </div>
                </div>

                <div class="stat-grid mb-4">
                    <div class="stat-chip"><span class="dot" style="background:#0072b9"></span> AFP <span class="val"><?= number_format($cnt_afp) ?></span></div>
                    <div class="stat-chip"><span class="dot" style="background:#f08100"></span> RTR <span class="val"><?= number_format($cnt_rtr) ?></span></div>
                    <div class="stat-chip"><span class="dot" style="background:#00d1b2"></span> DPA <span class="val"><?= number_format($cnt_dpa) ?></span></div>
                    <div class="stat-chip"><span class="dot" style="background:#cc141d"></span> NTX <span class="val"><?= number_format($cnt_ntx) ?></span></div>
                    <div class="stat-chip"><span class="dot" style="background:#e31837"></span> AP  <span class="val"><?= number_format($cnt_ap) ?></span></div>
                </div>

                <!-- Soporte Reubicado -->
                <div class="d-flex flex-wrap justify-content-center gap-3 mt-2 pt-4 border-top" style="border-color: var(--bg-panel-border) !important;">
                    <div class="d-flex align-items-center gap-2" style="background: rgba(var(--imagen-red-rgb), 0.05); padding: 10px 20px; border-radius: 12px; border: 1px solid rgba(var(--imagen-red-rgb), 0.1); min-width: 200px;">
                        <i class="bi bi-telephone-outbound-fill text-danger" style="font-size: 1.2rem;"></i>
                        <div class="text-start">
                            <div style="font-size: 0.65rem; text-transform: uppercase; opacity: 0.6; font-weight: 700; letter-spacing: 1px;">Soporte Técnico</div>
                            <div style="font-size: 0.95rem; font-weight: 800; font-family: 'Outfit';">Ext. 9096</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2" style="background: rgba(255,193,7, 0.05); padding: 10px 20px; border-radius: 12px; border: 1px solid rgba(255,193,7, 0.1); min-width: 200px;">
                        <i class="bi bi-envelope-at-fill text-warning" style="font-size: 1.2rem;"></i>
                        <div class="text-start">
                            <div style="font-size: 0.65rem; text-transform: uppercase; opacity: 0.6; font-weight: 700; letter-spacing: 1px;">Sistemas</div>
                            <div style="font-size: 0.95rem; font-weight: 800; font-family: 'Outfit';">it@gimm.com.mx</div>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 30px; font-size: 0.85rem; color: var(--color-text-dim); font-style: italic;">
                    <i class="bi bi-info-circle me-1"></i> Selecciona un cable de la lista lateral para visualizar el contenido completo.
                </div>
            </div>
        </div>

        <!-- Iframe Visor de Nota -->
        <iframe id="note-viewer" name="noteViewer" src="" title="Visor de Cable"></iframe>

        <!-- Botón para cerrar nota -->
        <button id="close-note-btn" onclick="closeNote()">
            <i class="bi bi-x-lg me-1"></i>Cerrar Nota
        </button>

    </div>
</div>

<script>
const noteViewer  = document.getElementById("note-viewer");
const closeBtn    = document.getElementById("close-note-btn");
const animWrapper = document.getElementById("anim-wrapper");

// ---- Abrir Nota ----
function openNote(el) {
    const path = el.getAttribute("data-path");
    if (!path) return;

    // Marcar activo en la lista
    document.querySelectorAll(".cable-row").forEach(r => r.classList.remove("active"));
    el.classList.add("active");

    // Construir URL del visor de notas (visor.php acepta el path del cable)
    const url = "visor.php?path=" + encodeURIComponent(path);

    // Mostrar iframe, ocultar galería
    animWrapper.style.display  = "none";
    noteViewer.src  = url;
    noteViewer.style.display   = "block";
    closeBtn.style.display = "block";
}

// ---- Cerrar Nota (volver a galería) ----
function closeNote() {
    animWrapper.style.display  = "flex";
    noteViewer.style.display   = "none";
    noteViewer.src = "";
    closeBtn.style.display = "none";
    document.querySelectorAll(".cable-row").forEach(r => r.classList.remove("active"));
}

// ---- Sincronizar Tema ----
function syncTheme() {
    try {
        const t = localStorage.getItem('theme') ||
                  (window.parent && window.parent.document.documentElement.getAttribute('data-bs-theme')) ||
                  'dark';
        document.documentElement.setAttribute('data-bs-theme', t);
    } catch(e) {}
}
syncTheme();
if (window.parent) {
    new MutationObserver(() => syncTheme())
        .observe(window.parent.document.documentElement, { attributes: true });
}

// Auto-refresco cada 90 segundos (como el original)
setTimeout(() => window.location.reload(), 90000);
</script>
</body>
</html>
