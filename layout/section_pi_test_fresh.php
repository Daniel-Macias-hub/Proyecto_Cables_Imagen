<?php
date_default_timezone_set('America/Mexico_City');
$selected_date = isset($_GET['dateT']) ? $_GET['dateT'] : date('Y-m-d');
$display_date  = date('d/m/Y', strtotime($selected_date));
$is_today      = ($selected_date === date('Y-m-d'));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PI - PRUEBAS (ESTADOS)</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --accent: #E30613;
            --accent-glow: rgba(227, 6, 19, 0.25);
            --bg: #f0f2f5;
            --surface: rgba(255,255,255,0.85);
            --text-primary: #111827;
            --text-muted: #6b7280;
            --border: rgba(0,0,0,0.07);
            --chip-bg: rgba(227,6,19,0.08);
            --chip-border: rgba(227,6,19,0.2);
            --logo-filter: invert(0) brightness(0.15);
            --grain: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='300' height='300' filter='url(%23n)' opacity='0.03'/%3E%3C/svg%3E");
        }
        [data-bs-theme="dark"] {
            --bg: #0d0d0f;
            --surface: rgba(255,255,255,0.04);
            --text-primary: #f9fafb;
            --text-muted: #9ca3af;
            --border: rgba(255,255,255,0.07);
            --chip-bg: rgba(227,6,19,0.12);
            --chip-border: rgba(227,6,19,0.3);
            --logo-filter: invert(1) brightness(1);
        }

        html, body {
            height: 100vh;
            overflow: hidden;
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg);
            color: var(--text-primary);
            transition: background-color 0.3s, color 0.3s;
        }

        /* ── Animated BG ────────────────────────── */
        .bg-layer {
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 10% 90%, rgba(227,6,19,0.07) 0%, transparent 70%),
                radial-gradient(ellipse 60% 50% at 90% 10%, rgba(227,6,19,0.05) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }
        [data-bs-theme="dark"] .bg-layer {
            background:
                radial-gradient(ellipse 80% 60% at 10% 90%, rgba(227,6,19,0.12) 0%, transparent 70%),
                radial-gradient(ellipse 60% 50% at 90% 10%, rgba(227,6,19,0.08) 0%, transparent 70%);
        }

        /* ── Layout ─────────────────────────────── */
        .stage {
            position: relative;
            z-index: 1;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        /* ── Card ───────────────────────────────── */
        .card {
            background: var(--surface);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--border);
            border-radius: 28px;
            padding: 52px 56px;
            width: 100%;
            max-width: 620px;
            text-align: center;
            position: relative;
            overflow: hidden;
            box-shadow:
                0 0 0 1px var(--border),
                0 20px 60px rgba(0,0,0,0.08),
                0 0 80px var(--accent-glow);
            animation: cardIn 0.7s cubic-bezier(0.22,1,0.36,1) both;
        }
        [data-bs-theme="dark"] .card {
            box-shadow:
                0 0 0 1px var(--border),
                0 20px 60px rgba(0,0,0,0.5),
                0 0 100px var(--accent-glow);
        }

        /* Top accent bar */
        .card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--accent), #ff4d4d, var(--accent), transparent);
            background-size: 200% 100%;
            animation: slideBar 3s linear infinite;
        }

        @keyframes slideBar {
            0%   { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        @keyframes cardIn {
            from { opacity: 0; transform: translateY(32px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: 0.5; transform: scale(1.4); }
        }

        /* ── Logo ───────────────────────────────── */
        .logo-wrap {
            margin-bottom: 28px;
            animation: fadeUp 0.6s 0.15s cubic-bezier(0.22,1,0.36,1) both;
        }
        .logo-icon-ring {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent) 0%, #ff4d4d 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 32px var(--accent-glow), 0 0 0 8px var(--chip-bg);
        }
        .logo-icon-ring i {
            font-size: 2rem;
            color: #fff;
        }

        /* ── Eyebrow ────────────────────────────── */
        .eyebrow {
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 3.5px;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 12px;
            animation: fadeUp 0.6s 0.25s cubic-bezier(0.22,1,0.36,1) both;
        }

        /* ── Title ──────────────────────────────── */
        .main-title {
            font-size: clamp(1.4rem, 3vw, 1.85rem);
            font-weight: 800;
            line-height: 1.2;
            color: var(--text-primary);
            margin-bottom: 10px;
            animation: fadeUp 0.6s 0.35s cubic-bezier(0.22,1,0.36,1) both;
        }

        /* ── Divider ────────────────────────────── */
        .divider {
            width: 36px;
            height: 3px;
            background: var(--accent);
            border-radius: 2px;
            margin: 18px auto;
            animation: fadeUp 0.6s 0.4s both;
        }

        /* ── Subtitle ───────────────────────────── */
        .subtitle {
            font-size: 0.92rem;
            color: var(--text-muted);
            line-height: 1.65;
            margin-bottom: 34px;
            animation: fadeUp 0.6s 0.45s cubic-bezier(0.22,1,0.36,1) both;
        }

        /* ── Chips ──────────────────────────────── */
        .chips {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            justify-content: center;
            animation: fadeUp 0.6s 0.55s cubic-bezier(0.22,1,0.36,1) both;
        }
        .chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--chip-bg);
            border: 1px solid var(--chip-border);
            color: var(--accent);
            font-size: 0.75rem;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 50px;
            letter-spacing: 0.4px;
        }
        .chip i { font-size: 0.8rem; }

        /* Live dot */
        .live-dot {
            display: inline-block;
            width: 7px; height: 7px;
            border-radius: 50%;
            background: #22c55e;
            animation: pulse-dot 2s ease-in-out infinite;
        }
    </style>
    <script>
        (function() {
            const t = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-bs-theme', t);
        })();
        window.addEventListener('storage', e => {
            if (e.key === 'theme') document.documentElement.setAttribute('data-bs-theme', e.newValue);
        });
    </script>
</head>
<body>

<div class="bg-layer"></div>

<div class="stage">
    <div class="card">

        <div class="logo-wrap">
            <div class="logo-icon-ring">
                <i class="fas fa-satellite-dish"></i>
            </div>
        </div>

        <p class="eyebrow">Imagen Televisión</p>

        <h1 class="main-title">Entorno de Validación<br>de Pautas &mdash; Estados</h1>

        <div class="divider"></div>

        <p class="subtitle">
            Selecciona un programa del menú lateral para revisar<br>
            los registros de la pauta del día en curso.
        </p>

        <div class="chips">
            <span class="chip"><i class="fas fa-broadcast-tower"></i> Estación: Estados</span>
            <span class="chip"><i class="fas fa-calendar-day"></i> <?php echo $display_date; ?></span>
            <?php if ($is_today): ?>
            <span class="chip"><span class="live-dot"></span> Sistema Activo</span>
            <?php else: ?>
            <span class="chip" style="background:rgba(255,165,0,0.1); border-color:rgba(255,165,0,0.3); color:#f59e0b;"><i class="fas fa-history"></i> Consulta Histórica</span>
            <?php endif; ?>
        </div>

    </div>
</div>

</body>
</html>
