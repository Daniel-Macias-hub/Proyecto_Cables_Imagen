<?php
// Layout Header (Sustituye a cabe.php y todas las declaraciones sueltas de HTML)
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <script>
        // [Bug 4 Fix] Lógica relámpago — aplica tema + colores inline ANTES del primer paint
        (function() {
            var t = localStorage.getItem('theme') || 'dark';
            var d = document.documentElement;
            d.setAttribute('data-bs-theme', t);
            // Pintar fondo inmediato para eliminar FOUC
            d.style.backgroundColor = (t === 'dark') ? '#1a1a1a' : '#f4f5f7';
            d.style.color = (t === 'dark') ? '#dee2e6' : '#212529';
        })();
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Cables - Grupo Imagen</title>
    <!-- Favicon Corporativo Imagen -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'><circle cx='32' cy='20' r='12' fill='%23009FE3'/><rect x='20' y='36' width='24' height='24' fill='%23E30613'/></svg>">
    <!-- Google Fonts: Outfit (Imagen Style) y Open Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar-column');
            if (sidebar) {
                sidebar.classList.toggle('d-none');
                sidebar.classList.toggle('d-flex');
                sidebar.style.position = 'fixed';
                sidebar.style.top = '0';
                sidebar.style.left = '0';
                sidebar.style.width = '280px';
                sidebar.style.height = '100%';
                sidebar.style.zIndex = '2000';
                sidebar.style.boxShadow = '0 0 100px rgba(0,0,0,0.5)';
            }
        }

        function toggleDesktopSidebar() {
            document.body.classList.toggle('sidebar-collapsed');
        }

        function toggleZenHeader() {
            document.body.classList.toggle('header-collapsed');
        }
    </script>
    <style>
        :root {
            --gimm-scale: 1;
            --sidebar-width: 280px;
        }
        
        /* Global Scaling for High Resolution Displays (ThinkPad, TV, etc) */
        @media (min-width: 1400px) { :root { --gimm-scale: 1.1; } }
        @media (min-width: 1900px) { :root { --gimm-scale: 1.2; } }
        @media (min-width: 2500px) { :root { --gimm-scale: 1.4; } }

        html {
            /* Fluid Typography: min 14px, max 18px based on viewport */
            font-size: clamp(14px, 1vw + 10px, 18px);
        }

        body {
            font-family: 'Open Sans', sans-serif;
            background-color: var(--bs-body-bg);
            transition: background-color 0.1s ease, color 0.1s ease;
            height: 100vh;
            margin: 0;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            font-size: calc(1rem * var(--gimm-scale));
        }
        
        h1, h2, h3, h4, h5, h6, .navbar-brand, .nav-link, .offcanvas-title, .card-header {
            font-family: 'Outfit', sans-serif;
            font-weight: 600;
        }
        .navbar-brand img {
            height: calc(40px * var(--gimm-scale));
            margin-right: 15px;
        }
        
        /* Header Responsiveness */
        .navbar {
            padding: calc(0.5rem * var(--gimm-scale)) 0;
            transition: background-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease;
        }

        /* [Bug 3] Navbar theme-aware background */
        .gimm-navbar { background-color: #1a1a1a; }
        [data-bs-theme="light"] .gimm-navbar {
            background-color: #ffffff !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        [data-bs-theme="light"] .gimm-navbar .gimm-logo-text,
        [data-bs-theme="light"] .gimm-navbar .system-title { color: #1a1a1a; }
        [data-bs-theme="light"] .gimm-navbar .magic-nav a { color: #333; }
        [data-bs-theme="light"] .gimm-navbar .magic-nav a:hover span.nav-inner { background-color: rgba(0,0,0,0.07); }
        [data-bs-theme="light"] .gimm-navbar .magic-nav a[data-active=true] span.nav-inner { background: #E30613; color: #fff; }
        [data-bs-theme="light"] .gimm-navbar .search-container { background: #f0f0f0; border-color: rgba(0,0,0,0.12); }
        [data-bs-theme="light"] .gimm-navbar .search-input { color: #333; }
        [data-bs-theme="light"] .gimm-navbar .search-input::placeholder { color: #999; }
        [data-bs-theme="light"] .gimm-navbar .search-container i { color: #666; }
        [data-bs-theme="light"] .gimm-navbar .border-secondary { border-color: rgba(0,0,0,0.08) !important; }
        
        .gimm-logo-text { font-size: calc(1.4rem * var(--gimm-scale)); }
        .system-title { font-size: calc(1.1rem * var(--gimm-scale)); }
        .main-container {
            flex: 1 1 auto;
            height: 0; /* Important for flex children scrolling */
            overflow: hidden;
            padding: 0;
            margin: 0;
        }
        
        /* Zen Mode (Collapsible Header & Sidebar) */
        body.header-collapsed .navbar {
            padding: 0 !important;
            height: 12px !important;
            overflow: hidden;
            border-bottom: 3px solid #E30613;
        }
        body.header-collapsed .navbar .container-fluid { opacity: 0; pointer-events: none; }
        body.header-collapsed .main-container { height: calc(100vh - 12px); }
        
        body.sidebar-collapsed .sidebar-column { display: none !important; }
        body.sidebar-collapsed .content-column { 
            flex: 0 0 100% !important; 
            max-width: 100% !important; 
            padding: 0 !important; 
        }
        body.sidebar-collapsed .card { border-radius: 0 !important; }

        .zen-btn-nav:hover { background: #E30613; border-color: #E30613; }

        /* Integrated Sidebar Controls */
        .zen-sidebar-btn {
            background: none;
            border: none;
            color: rgba(255,255,255,0.7);
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.2s;
            padding: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .zen-sidebar-btn:hover { color: #fff; transform: scale(1.1); }
        
        /* Zen Recovery Controls (Hidden by default, reveals on Hover Zone) */
        .zen-recovery-float {
            position: fixed;
            top: 15px;
            right: 20px;
            z-index: 3000;
            display: flex;
            gap: 8px;
            opacity: 0;
            pointer-events: none;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            transform: translateY(-10px) scale(0.9);
        }
        
        /* Trigger Zone for Zen Controls */
        .zen-trigger-zone {
            position: fixed;
            top: 0;
            right: 0;
            width: 150px;
            height: 60px;
            z-index: 2999;
            background: transparent;
        }
        .zen-trigger-zone:hover ~ .zen-recovery-float,
        .zen-recovery-float:hover {
            opacity: 1;
            pointer-events: auto;
            transform: translateY(0) scale(1);
        }
        
        /* Hint for the hidden zone - Redesign Minimalista */
        .zen-zone-hint {
            position: fixed;
            top: 0;
            right: 0;
            z-index: 10001;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(8px);
            color: rgba(255,255,255,0.8);
            padding: 6px 12px;
            border-bottom-left-radius: 8px;
            font-size: 0.55rem;
            font-weight: 600;
            pointer-events: none;
            border-left: 2px solid #dc3545;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            gap: 6px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }
        @keyframes zen-hint-fade {
            0% { opacity: 0.4; }
            50% { opacity: 0.8; }
            100% { opacity: 0.4; }
        }
        .zen-zone-hint {
            animation: zen-hint-fade 4s infinite;
        }
        @keyframes zen-pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        .zen-trigger-zone:hover ~ .zen-zone-hint {
            display: none;
        }

        /* Bot Cable Link (Chatbot) */
        .bot-cable-link {
            font-size: 0.75rem;
            font-weight: bold;
            color: #009FE3 !important;
            text-decoration: underline !important;
            display: inline-block;
            transition: color 0.2s;
            cursor: pointer;
        }
        .bot-cable-link:hover {
            color: #0056b3 !important;
        }
        
        .btn-recovery {
            width: 38px;
            height: 38px;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(8px);
            color: white;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            transition: all 0.3s;
        }
        .btn-recovery:hover { transform: scale(1.1) rotate(90deg); background: var(--imagen-red); border-color: var(--imagen-red); }
        
        /* Bot Label Animation */
        .bot-label {
            position: fixed;
            bottom: 32px;
            right: 90px;
            background: #E30613;
            color: white;
            padding: 6px 15px;
            border-radius: 20px;
            font-family: 'Outfit', sans-serif;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(227,6,19,0.3);
            z-index: 1040;
            pointer-events: none;
            animation: labelFloat 3s ease-in-out infinite;
        }
        .bot-label::after {
            content: '';
            position: absolute;
            right: -6px;
            top: 50%;
            transform: translateY(-50%);
            border-left: 8px solid #E30613;
            border-top: 6px solid transparent;
            border-bottom: 6px solid transparent;
        }
        @keyframes labelFloat {
            0%, 100% { transform: translateX(0); }
            50% { transform: translateX(-5px); }
        }
        
        /* Ocultar los botones internos cuando ya está colapsado para evitar duplicidad si fuera el caso */
        body.sidebar-collapsed .sidebar-column { display: none !important; }
        
        /* Layout de Columnas Independientes */
        .sidebar-column {
            height: 100%;
            overflow: hidden; /* Inner list-group will scroll */
            border-right: 1px solid rgba(0,0,0,0.08);
            background-color: rgba(var(--bs-light-rgb), 0.5);
            display: flex;
            flex-direction: column;
        }
        
        .content-column {
            height: 100%;
            overflow: hidden; /* Only iframe will scroll */
            padding-top: 15px;
            padding-bottom: 15px;
        }

        .gimm-btn {
            position: fixed;
            bottom: 25px;
            right: 25px;
            width: 55px;
            height: 55px;
            background: linear-gradient(135deg, #009FE3 0%, #0072b9 100%);
            color: white;
            border: 2px solid rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 15px rgba(0,0,0,0.3);
            cursor: pointer;
            z-index: 1050;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .gimm-btn:hover {
            transform: scale(1.1) rotate(5deg);
        }
        
        /* Animaciones para el Chatbot */
        @keyframes chatBounce {
            0% { transform: scale(0.5) translateY(20px); opacity: 0; }
            70% { transform: scale(1.05) translateY(-5px); }
            100% { transform: scale(1) translateY(0); opacity: 1; }
        }

        @keyframes msgInRight {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes msgInLeft {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .chat-animated {
            animation: chatBounce 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
            transform-origin: bottom right;
        }

        .msg-animate-user { animation: msgInRight 0.3s ease-out forwards; }
        .msg-animate-bot { animation: msgInLeft 0.3s ease-out forwards; }

        /* Tema Toggle Ripple Animation */
        #theme-ripple {
            position: fixed;
            border-radius: 50%;
            pointer-events: none;
            z-index: 9999;
            transform: scale(0);
            transition: transform 0.6s cubic-bezier(0.645, 0.045, 0.355, 1);
            background: #1a1a1a;
        }
        
        html[data-bs-theme="dark"] #theme-ripple {
            background: #f4f6f9;
        }
        
        /* Custom tweaks para modo oscuro */
        html[data-bs-theme="dark"] .bg-light {
            background-color: #2b3035 !important;
            color: white !important;
        }
        html[data-bs-theme="dark"] .list-group-item {
            background-color: var(--bs-body-bg);
            color: var(--bs-body-color);
        }
        html[data-bs-theme="dark"] .sidebar-column {
            border-right: 1px solid rgba(255,255,255,0.05);
            background-color: #0f1113;
        }

        /* Insignias de Agencia Modernas (Fase 11) */
        .agency-badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 10px;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-family: 'Outfit', sans-serif;
        }
        .bg-afp { background-color: #009fe3; color: white; }
        .bg-rtr { background-color: #333333; color: white; border: 1px solid #444; }
        .bg-ntx { background-color: #e30613; color: white; }
        .bg-ap  { background-color: #000000; color: white; }
        .bg-dpa { background-color: #008080; color: white; }

        /* Nuevo Logo Grupo Imagen CSS */
        .gimm-brand-container {
            display: flex;
            align-items: center;
            text-decoration: none;
        }
        .gimm-logo-icon {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
            margin-right: 8px;
        }
        .gimm-logo-icon .circle {
            width: 16px;
            height: 16px;
            background-color: #009FE3; /* Azul Imagen */
            border-radius: 50%;
        }
        .gimm-logo-icon .square {
            width: 16px;
            height: 16px;
            background-color: #E30613; /* Rojo Imagen */
        }
        .gimm-logo-text {
            font-family: 'Arial Black', 'Impact', sans-serif;
            font-size: 1.4rem;
            letter-spacing: -0.5px;
            color: #ffffff;
            line-height: 1;
        }
        .system-title {
            font-family: 'Arial Black', 'Impact', sans-serif;
            font-weight: 900;
            font-size: 1.1rem;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: -0.5px;
            border-left: 1px solid rgba(255,255,255,0.3);
            padding-left: 15px;
            margin-left: 15px;
            white-space: nowrap;
        }
        
        /* Acentos de Navegación Activa */
        .nav-link.active {
            color: #ffffff !important;
            border-bottom: 2px solid #E30613;
            font-weight: 700;
        }
        .nav-link:hover { color: #E30613 !important; }

        /* --- Solid Standard Navigation Bar --- */
        /* [Bug 1 + Bug 2 Fix] overflow:visible para que los counters no se corten */
        .magic-nav {
            display: flex;
            align-items: center;
            gap: 0.2rem;
            list-style-type: none;
            padding: 6px 0 0 0; /* espacio superior para badges */
            margin: 0;
            overflow: visible;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .magic-nav::-webkit-scrollbar { display: none; }
        .magic-nav li { margin: 0; display: flex; align-items: center; }
        .magic-nav a {
            text-decoration: none;
            color: #ffffff;
            display: inline-block;
            font-family: 'Outfit', sans-serif;
            font-weight: 600;
            font-size: calc(0.9rem * var(--gimm-scale));
            letter-spacing: 0.5px;
        }
        .magic-nav a span.nav-inner {
            transition: background-color 0.2s ease-in-out, transform 0.1s ease-in-out;
            border-radius: 100px;
            padding: calc(0.3rem * var(--gimm-scale)) calc(0.8rem * var(--gimm-scale));
            display: inline-flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
            position: relative;
        }
        .magic-nav a:hover span.nav-inner { background-color: rgba(255,255,255,0.15); }
        .magic-nav a:active span.nav-inner { transform: scale(0.95); }
        .magic-nav a[data-active=true] span.nav-inner {
            background: #E30613;
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(227,6,19,0.3);
        }

        /* Live counter badge */
        .nav-counter {
            position: absolute;
            top: -2px;
            right: -2px;
            background: #22c55e;
            color: #fff;
            font-size: 0.6rem;
            font-weight: 800;
            font-family: 'Outfit', sans-serif;
            min-width: 18px;
            height: 18px;
            border-radius: 10px;
            padding: 0 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
            box-shadow: 0 2px 5px rgba(0,0,0,0.4);
            letter-spacing: 0;
            opacity: 0;
            transform: scale(0.6);
            transition: opacity 0.3s, transform 0.3s;
            pointer-events: none;
            z-index: 10;
        }
        .nav-counter.loaded {
            opacity: 1;
            transform: scale(1);
        }
        .nav-counter.zero {
            background: #6c757d;
        }
        /* Pulsing dot for live feel */
        .nav-live-dot {
            display: inline-block;
            width: 5px; height: 5px;
            background: #22c55e;
            border-radius: 50%;
            margin-left: 2px;
            animation: navdotpulse 2s infinite;
            flex-shrink: 0;
        }
        @keyframes navdotpulse { 0%,100%{opacity:1;box-shadow:0 0 0 0 #22c55e99;} 50%{opacity:0.5;box-shadow:0 0 0 4px #22c55e00;} }
            /* --- ANIMATED SEARCH BAR --- */
            .animated-search {
              width: 100%;
              max-width: 250px;
            }
            .search-container {
              position: relative;
              background: #2a2a2a;
              border: 1px solid rgba(255,255,255,0.1);
              border-radius: 30px;
              padding: 5px 14px;
              display: flex;
              align-items: center;
              gap: 8px;
              transition: all 0.3s ease;
            }
            .search-container:focus-within {
              border-color: #E30613;
            }
            .search-container i {
              color: #888;
              font-size: 14px;
            }
            .search-input {
              border: none;
              background: none;
              color: #fff;
              font-size: 0.85rem;
              width: 100%;
              outline: none;
              font-family: 'Outfit', sans-serif;
            }
            .search-input::placeholder { color: #555; }
            
            #searchSuggestionsList {
                top: 110%;
                border-radius: 12px;
                overflow: hidden;
                border: 1px solid rgba(128,128,128,0.2);
            }
            
            /* --- CLEAN MODERN THEME SWITCH --- */
            .theme-switch {
              display: inline-block;
              position: relative;
              cursor: pointer;
              margin-left: 10px;
              user-select: none;
            }
            .theme-switch-input {
              position: absolute;
              opacity: 0;
            }
            .theme-switch-track {
              display: flex;
              align-items: center;
              position: relative;
              width: 50px;
              height: 26px;
              background-color: #2c3e50;
              border-radius: 20px;
              transition: background-color 0.3s ease;
            }
            .theme-switch-input:checked + .theme-switch-track {
              background-color: #111;
            }
            .theme-switch-indicator {
              position: absolute;
              top: 3px;
              left: 3px;
              width: 20px;
              height: 20px;
              background-color: #f1c40f;
              border-radius: 50%;
              transition: transform 0.3s ease;
              display: flex;
              align-items: center;
              justify-content: center;
            }
            .theme-switch-input:checked + .theme-switch-track .theme-switch-indicator {
              transform: translateX(24px);
              background-color: #ecf0f1;
            }
            .theme-switch-indicator svg { width: 12px; height: 12px; }
            .theme-switch-labels { display: none; }
    </style>
    <!-- Font Awesome (for the search icon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div id="theme-ripple"></div>

<!-- [Bug 3 Fix] Eliminado background-color inline para que el tema claro funcione -->
<nav class="navbar navbar-expand-lg navbar-dark gimm-navbar" style="z-index: 1040; position: relative; border-bottom: 3px solid #E30613;">
    <div class="container-fluid px-4 d-flex flex-column">
        <!-- Fila 1: Marca Centrada -->
        <div class="d-flex align-items-center justify-content-between w-100 py-3 border-bottom border-secondary border-opacity-25 mb-2">
            <!-- Mobile Toggle (Ya existente) -->
            <button class="btn btn-link text-white d-md-none p-0 me-3" type="button" onclick="toggleSidebar()" style="font-size: 1.5rem;">
                <i class="fas fa-bars"></i>
            </button>
            
            <a class="gimm-brand-container mx-auto" href="cablesmain.php">
                <div class="gimm-logo-icon">
                    <div class="circle"></div>
                    <div class="square"></div>
                </div>
                <div class="gimm-logo-text">IMAGEN</div>
                <div class="system-title">Sistema de Recepción de Cables</div>
            </a>
        </div>

        <!-- Fila 2: Navegación y Herramientas -->
        <!-- [Bug 2 Fix] Contenedor flex con overflow visible y flex-wrap para que Prueba no se corte -->
        <div class="d-flex align-items-center justify-content-center w-100" style="overflow: visible;">
            <button class="navbar-toggler mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#topNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="d-flex align-items-center gap-3" style="overflow: visible;">
                
                <div class="collapse navbar-collapse" id="topNav">
                    <div class="d-flex w-100 justify-content-center align-items-center" style="gap: 15px; overflow: visible;">
                        <?php
                        // Lógica para detectar la sección activa
                        $current_section = isset($_GET['section']) ? $_GET['section'] : 'inicio';
                        ?>
                        <ul class="magic-nav mb-0" id="main-magic-nav">
                            <!-- Cables -->
                            <li><a data-active="<?= ($current_section == 'inicio' || empty($_GET['section'])) ? 'true' : 'false' ?>" href="cablesmain.php">
                                <span class="nav-inner">
                                    Cables <span class="nav-live-dot"></span>
                                    <span class="nav-counter" id="cnt-cables">…</span>
                                </span>
                            </a></li>
                            <!-- X-Temas -->
                            <li><a data-active="<?= ($current_section == 'temas') ? 'true' : 'false' ?>" href="cablesmain.php?section=temas">
                                <span class="nav-inner">X-Temas</span>
                            </a></li>
                            <!-- [COMENTADO TEMPORALMENTE - Turbina]
                            <li><a data-active="<?= ($current_section == 'turbina') ? 'true' : 'false' ?>" href="cablesmain.php?section=turbina">
                                <span class="nav-inner">Turbina</span>
                            </a></li>
                            -->
                            <!-- K4 -->
                            <li><a data-active="false" href="http://10.29.120.50:8181" target="_blank">
                                <span class="nav-inner">K4</span>
                            </a></li>
                            <!-- Fotos -->
                            <li><a data-active="<?= ($current_section == 'fotos') ? 'true' : 'false' ?>" href="cablesmain.php?section=fotos">
                                <span class="nav-inner">
                                    Fotos
                                    <span class="nav-counter" id="cnt-fotos">…</span>
                                </span>
                            </a></li>
                            <!-- [COMENTADO TEMPORALMENTE - Video]
                            <li><a data-active="<?= ($current_section == 'video') ? 'true' : 'false' ?>" href="cablesmain.php?section=video">
                                <span class="nav-inner">
                                    Video
                                    <span class="nav-counter" id="cnt-video">…</span>
                                </span>
                            </a></li>
                            -->
                            <!-- Pi -->
                            <li><a data-active="<?= ($current_section == 'pi') ? 'true' : 'false' ?>" href="cablesmain.php?section=pi">
                                <span class="nav-inner">
                                    Pi
                                    <span class="nav-counter" id="cnt-pi">…</span>
                                </span>
                            </a></li>
                            <!-- Prueba -->
                            <li><a data-active="<?= ($current_section == 'prueba') ? 'true' : 'false' ?>" href="cablesmain.php?section=prueba">
                                <span class="nav-inner">
                                    Prueba
                                    <span style="display:inline-block;width:7px;height:7px;border-radius:50%;background:#28a745;margin-left:6px;vertical-align:middle;"></span>
                                </span>
                            </a></li>
                        </ul>

                        <script>
                        // ── LIVE NAV COUNTERS ──────────────────────────────────────
                        (function() {
                            const SECTIONS = ['cables','fotos','video','pi','prueba'];

                            function fmtNum(n) {
                                if (n >= 1000) return (n/1000).toFixed(1).replace('.0','') + 'k';
                                return n.toString();
                            }

                            function updateCounters() {
                                fetch('api_nav_counters.php')
                                    .then(r => r.json())
                                    .then(data => {
                                        SECTIONS.forEach(sec => {
                                            const el = document.getElementById('cnt-' + sec);
                                            if (!el) return;
                                            const val = data[sec] || 0;
                                            el.textContent = fmtNum(val);
                                            el.classList.add('loaded');
                                            el.classList.toggle('zero', val === 0);
                                        });
                                    })
                                    .catch(() => {
                                        SECTIONS.forEach(sec => {
                                            const el = document.getElementById('cnt-' + sec);
                                            if (el) { el.textContent = '—'; el.classList.add('loaded','zero'); }
                                        });
                                    });
                            }

                            updateCounters();
                            setInterval(updateCounters, 60000);
                        })();
                        </script>
                
                
                        <form class="animated-search ms-3" action="buscar.php" method="get" target="contentFrame" id="globalSearchForm">
                            <div class="search-container">
                                <i class="fas fa-search"></i>
                                <input id="fastSearchInput" class="search-input" type="search" placeholder="Buscar..." name="B1" autocomplete="off">
                                <input type="hidden" name="action" value="get">
                            </div>
                            <div id="searchSuggestionsList" class="list-group position-absolute shadow w-100" style="display: none; max-height: 350px; overflow-y: auto; z-index: 2000;"></div>
                        </form>
            
                        <label class="theme-switch" title="Cambiar Tema">
                          <input type="checkbox" class="theme-switch-input" id="themeToggleBtn">
                          <span class="theme-switch-track">
                            <span class="theme-switch-indicator">
                              <svg class="sun-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"></circle></svg>
                            </span>
                          </span>
                        </label>

                        <script>
                        // ── PREDICTIVE SEARCH LOGIC ────────────────────────────────
                        document.addEventListener("DOMContentLoaded", function() {
                            const searchInput = document.getElementById('fastSearchInput');
                            const suggestBox = document.getElementById('searchSuggestionsList');
                            const themeToggle = document.getElementById('themeToggleBtn');
                            let debounceTimer;

                            // Theme Toggle Logic
                            if (themeToggle) {
                                var applyTheme = function(theme) {
                                    var d = document.documentElement;
                                    d.setAttribute('data-bs-theme', theme);
                                    localStorage.setItem('theme', theme);
                                    themeToggle.checked = (theme === 'dark');
                                    // [Bug 4] Sincronizar colores inline del FOUC fix
                                    d.style.backgroundColor = (theme === 'dark') ? '#1a1a1a' : '#f4f5f7';
                                    d.style.color = (theme === 'dark') ? '#dee2e6' : '#212529';
                                };

                                // Initialize from saved preference
                                var initTheme = localStorage.getItem('theme') || 'dark';
                                applyTheme(initTheme);

                                themeToggle.addEventListener('change', function() {
                                    applyTheme(this.checked ? 'dark' : 'light');
                                });
                            }

                            // Search Logic
                            if (searchInput) {
                                searchInput.addEventListener('input', function() {
                                    clearTimeout(debounceTimer);
                                    const q = this.value.trim();
                                    if (q.length < 3) { suggestBox.style.display = 'none'; return; }

                                    debounceTimer = setTimeout(() => {
                                        fetch(`api_suggest.php?q=${encodeURIComponent(q)}`)
                                            .then(r => r.json())
                                            .then(data => {
                                                suggestBox.innerHTML = '';
                                                if (data.length > 0) {
                                                    data.forEach(item => {
                                                        suggestBox.innerHTML += `
                                                            <a href="${item.url}" target="contentFrame" class="list-group-item list-group-item-action py-2">
                                                                <small class="text-primary fw-bold" style="font-size:0.7rem;">${item.agency}</small>
                                                                <p class="mb-0 fw-bold text-truncate" style="font-size:0.85rem;">${item.title}</p>
                                                            </a>
                                                        `;
                                                    });
                                                    suggestBox.style.display = 'block';
                                                } else { suggestBox.style.display = 'none'; }
                                            });
                                    }, 300);
                                });
                            }

                            document.addEventListener('click', e => {
                                if (searchInput && !searchInput.contains(e.target) && !suggestBox.contains(e.target)) {
                                    suggestBox.style.display = 'none';
                                }
                            });
                        });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Zen Mode Recovery (Fixed) -->
<div class="zen-trigger-zone"></div>
<div class="zen-zone-hint">
    <i class="fas fa-arrows-alt"></i> Layout
</div>
<div class="zen-recovery-float">
    <button class="btn-recovery" onclick="toggleDesktopSidebar()" title="Mostrar Menú">
        <i class="fas fa-bars"></i>
    </button>
    <button class="btn-recovery" onclick="toggleZenHeader()" title="Restaurar Cabecera" style="background: #009FE3; box-shadow: 0 4px 15px rgba(0,159,227,0.4);">
        <i class="fas fa-compress"></i>
    </button>
</div>

<div class="container-fluid main-container">
    <div class="row h-100 g-0">
