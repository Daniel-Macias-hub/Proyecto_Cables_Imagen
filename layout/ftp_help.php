<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instrucciones de Acceso a Audios FTP</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f4f5f7;
            font-family: 'Outfit', sans-serif;
            color: #1a1a1a;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 90vh;
            margin: 0;
            padding: 20px;
        }
        [data-bs-theme="dark"] body {
            background-color: #121212;
            color: #f0f0f0;
        }
        .help-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 40px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            text-align: center;
            border: 1px solid rgba(227,6,19,0.1);
        }
        [data-bs-theme="dark"] .help-card {
            background: #1e1e1e;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            border-color: rgba(255,255,255,0.05);
        }
        .icon-header {
            font-size: 3.5rem;
            color: #E30613;
            margin-bottom: 20px;
        }
        h2 {
            font-weight: 800;
            margin-bottom: 15px;
            font-size: 1.8rem;
        }
        p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        [data-bs-theme="dark"] p { color: #aaa; }
        
        .steps {
            text-align: left;
            background: rgba(0,0,0,0.03);
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
        }
        [data-bs-theme="dark"] .steps { background: rgba(255,255,255,0.03); }
        
        .step {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }
        .step:last-child { margin-bottom: 0; }
        .step-num {
            background: #E30613;
            color: white;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
            flex-shrink: 0;
        }
        .step-text { font-size: 0.95rem; font-weight: 500; }

        .copy-box {
            background: #f8f9fa;
            border: 1px dashed #E30613;
            padding: 15px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        [data-bs-theme="dark"] .copy-box { background: #252525; }
        .url-text { font-family: monospace; font-size: 0.9rem; color: #009FE3; font-weight: 700; }
        
        .btn-copy {
            background: #E30613;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-copy:hover { transform: scale(1.05); filter: brightness(1.1); }
        
        .alert-windows {
            font-size: 0.8rem;
            color: #888;
            font-style: italic;
        }
    </style>
</head>
<body>

<div class="help-card">
    <div class="icon-header">
        <i class="fas fa-folder-open"></i>
    </div>
    <h2>Acceso a ENTGIMAUDIO</h2>
    <p>Debido a restricciones de seguridad en navegadores modernos (Chrome, Edge), no es posible abrir enlaces FTP directamente en esta ventana.</p>
    
    <div class="steps">
        <div class="step">
            <div class="step-num">1</div>
            <div class="step-text">Copia la ruta FTP del servidor Dalet.</div>
        </div>
        <div class="step">
            <div class="step-num">2</div>
            <div class="step-text">Abre cualquier carpeta en tu computadora (Explorador de Windows).</div>
        </div>
        <div class="step">
            <div class="step-num">3</div>
            <div class="step-text">Pega la ruta en la barra de dirección superior y presiona Enter.</div>
        </div>
    </div>

    <div class="copy-box">
        <span class="url-text" id="ftpUrl">ftp://dalet:ps1dalet@10.29.128.161/</span>
        <button class="btn-copy" onclick="copyUrl()">
            <i class="fas fa-copy me-1"></i> Copiar
        </button>
    </div>

    <div class="alert-windows">
        <i class="fab fa-windows me-1"></i> Recomendado: Usar el Explorador de Archivos de Windows para una mejor experiencia.
    </div>
</div>

<script>
    function copyUrl() {
        const url = document.getElementById('ftpUrl').innerText;
        navigator.clipboard.writeText(url).then(() => {
            const btn = document.querySelector('.btn-copy');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check me-1"></i> Copiado';
            btn.style.background = '#28a745';
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.style.background = '#E30613';
            }, 2000);
        });
    }

    function syncTheme() {
        const theme = localStorage.getItem('theme') || (window.parent && window.parent.document.documentElement.getAttribute('data-bs-theme')) || 'light';
        document.documentElement.setAttribute('data-bs-theme', theme);
    }
    syncTheme();
</script>

</body>
</html>
