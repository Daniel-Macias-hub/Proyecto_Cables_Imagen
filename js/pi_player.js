/**
 * Reproductor Modal GIM — Sistema de Cables / Imagen Televisión
 * Compatible: JS Vanilla, IE11+, Chrome legacy
 * No depende de frameworks. Se inyecta en el DOM del listado activo.
 */
(function (global) {
    'use strict';

    var MODAL_ID   = 'gimAudioModal';
    var OVERLAY_ID = 'gimAudioOverlay';

    // ─── Estilos del modal (inyectados una sola vez) ─────────────────────────
    var CSS = [
        '#' + OVERLAY_ID + '{',
            'position:fixed;top:0;left:0;width:100%;height:100%;',
            'background:rgba(0,0,0,0.72);',
            'backdrop-filter:blur(6px);-webkit-backdrop-filter:blur(6px);',
            'z-index:99999;',
            'display:none;align-items:center;justify-content:center;',
            'animation:gimFadeIn .25s ease both;',
        '}',
        '#' + OVERLAY_ID + '.visible{display:flex;}',
        '@keyframes gimFadeIn{from{opacity:0}to{opacity:1}}',

        '#' + MODAL_ID + '{',
            'background:#151515;',
            'border:1px solid rgba(227,6,19,.3);',
            'border-top:4px solid #E30613;',
            'border-radius:16px;',
            'width:94%;max-width:640px;',
            'box-shadow:0 40px 100px rgba(0,0,0,.85);',
            'font-family:\'Outfit\',sans-serif;',
            'overflow:hidden;',
            'animation:gimSlideUp .3s cubic-bezier(.23,1,.32,1) both;',
        '}',
        '@keyframes gimSlideUp{from{opacity:0;transform:translateY(30px)}to{opacity:1;transform:translateY(0)}}',

        /* Cabecera */
        '.gim-mhdr{',
            'display:flex;align-items:flex-start;justify-content:space-between;',
            'padding:20px 24px 16px;',
            'border-bottom:1px solid rgba(255,255,255,.06);',
        '}',
        '.gim-brand{display:flex;align-items:center;gap:10px;}',
        '.gim-logo{',
            'display:flex;flex-direction:column;align-items:center;gap:3px;flex-shrink:0;',
        '}',
        '.gim-logo .dot-a{width:12px;height:12px;border-radius:50%;background:#009FE3;}',
        '.gim-logo .dot-b{width:12px;height:12px;background:#E30613;}',
        '.gim-badge{',
            'font-size:.65rem;font-weight:800;letter-spacing:1.5px;text-transform:uppercase;',
            'color:#E30613;background:rgba(227,6,19,.12);',
            'border:1px solid rgba(227,6,19,.25);border-radius:20px;',
            'padding:2px 10px;',
        '}',
        '.gim-mtitle{font-size:1.3rem;font-weight:800;color:#fff;line-height:1.2;margin-top:4px;}',
        '.gim-msub{font-size:.88rem;color:#009FE3;font-weight:600;margin-top:2px;}',
        '.gim-close{',
            'background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.12);',
            'color:#aaa;border-radius:50%;width:32px;height:32px;',
            'display:flex;align-items:center;justify-content:center;',
            'cursor:pointer;font-size:.9rem;flex-shrink:0;',
            'transition:all .2s;',
        '}',
        '.gim-close:hover{background:#E30613;border-color:#E30613;color:#fff;}',

        /* Meta grid */
        '.gim-meta{',
            'display:grid;grid-template-columns:repeat(4,1fr);',
            'border-bottom:1px solid rgba(255,255,255,.05);',
        '}',
        '.gim-mcell{padding:10px 16px;border-right:1px solid rgba(255,255,255,.05);}',
        '.gim-mcell:last-child{border-right:none;}',
        '.gim-mlabel{font-size:.6rem;text-transform:uppercase;letter-spacing:1px;color:rgba(255,255,255,.35);font-weight:700;margin-bottom:2px;}',
        '.gim-mval{font-size:.88rem;font-weight:700;color:#e0e0e0;}',
        '.gim-mval.mono{font-family:monospace;color:#009FE3;}',

        /* Body del player */
        '.gim-mbody{padding:20px 24px 8px;}',

        /* Status bar */
        '.gim-status{',
            'display:flex;align-items:center;gap:8px;',
            'margin-bottom:14px;padding:8px 14px;',
            'background:rgba(0,0,0,.35);border-radius:8px;',
            'border:1px solid rgba(255,255,255,.04);',
        '}',
        '.gim-dot{width:8px;height:8px;border-radius:50%;background:#444;flex-shrink:0;transition:all .3s;}',
        '.gim-dot.playing{background:#E30613;box-shadow:0 0 8px rgba(227,6,19,.8);animation:gimPulse 1s infinite;}',
        '.gim-dot.paused{background:#777;}',
        '@keyframes gimPulse{0%,100%{opacity:1}50%{opacity:.35}}',
        '.gim-stxt{font-size:.78rem;font-weight:700;color:rgba(255,255,255,.4);letter-spacing:.4px;}',
        '.gim-stxt.active{color:#E30613;}',

        /* Ondas */
        '.gim-waves{',
            'display:flex;align-items:center;justify-content:center;gap:4px;',
            'height:40px;margin-bottom:12px;',
            'opacity:.2;transition:opacity .4s;',
        '}',
        '.gim-waves.playing{opacity:1;}',
        '.gim-wave{',
            'width:5px;height:100%;background:#E30613;border-radius:3px;',
            'animation:gimBounce 1.2s ease-in-out infinite;',
        '}',
        '.gim-wave:nth-child(1){animation-delay:0s}',
        '.gim-wave:nth-child(2){animation-delay:.1s;height:55%}',
        '.gim-wave:nth-child(3){animation-delay:.2s;height:80%}',
        '.gim-wave:nth-child(4){animation-delay:.3s;height:35%}',
        '.gim-wave:nth-child(5){animation-delay:.4s;height:100%}',
        '.gim-wave:nth-child(6){animation-delay:.5s;height:45%}',
        '.gim-wave:nth-child(7){animation-delay:.6s;height:70%}',
        '@keyframes gimBounce{0%,100%{transform:scaleY(.25)}50%{transform:scaleY(1)}}',

        /* Audio element */
        '.gim-audio{width:100%;height:44px;outline:none;border-radius:8px;display:block;}',
        '.gim-hint{font-size:.68rem;color:rgba(255,255,255,.25);text-align:center;margin-top:6px;word-break:break-all;padding:0 4px;}',
        '.gim-err{background:rgba(227,6,19,.08);border:1px solid rgba(227,6,19,.3);border-radius:8px;padding:16px;text-align:center;color:#fca5a5;font-size:.88rem;}',

        /* Footer */
        '.gim-mfoot{padding:14px 24px;border-top:1px solid rgba(255,255,255,.05);}',
        '.gim-hint-file{font-size:.68rem;color:rgba(255,255,255,.2);word-break:break-all;}',

        /* Responsive */
        '@media(max-width:560px){',
            '.gim-meta{grid-template-columns:1fr 1fr;}',
            '.gim-mhdr{padding:16px 16px 14px;}',
            '.gim-mbody{padding:16px 16px 8px;}',
            '.gim-mfoot{padding:12px 16px;}',
            '.gim-mtitle{font-size:1.1rem;}',
        '}'
    ].join('');

    function injectStyles() {
        if (document.getElementById('gimPlayerCSS')) return;
        var s = document.createElement('style');
        s.id  = 'gimPlayerCSS';
        s.textContent = CSS;
        document.head.appendChild(s);
    }

    // ─── Construcción del modal (primera vez) ────────────────────────────────
    function buildModal() {
        if (document.getElementById(OVERLAY_ID)) return;

        var overlay = document.createElement('div');
        overlay.id  = OVERLAY_ID;

        overlay.innerHTML = [
            '<div id="' + MODAL_ID + '">',
                /* Cabecera */
                '<div class="gim-mhdr">',
                    '<div>',
                        '<div class="gim-brand">',
                            '<div class="gim-logo">',
                                '<div class="dot-a"></div>',
                                '<div class="dot-b"></div>',
                            '</div>',
                            '<span class="gim-badge"><i class="fas fa-broadcast-tower"></i> &nbsp;Reproductor GIM</span>',
                        '</div>',
                        '<div class="gim-mtitle" id="gimTitle">—</div>',
                        '<div class="gim-msub"  id="gimSub">—</div>',
                    '</div>',
                    '<button class="gim-close" onclick="GIMPlayer.close()" title="Cerrar">',
                        '<i class="fas fa-times"></i>',
                    '</button>',
                '</div>',
                /* Meta */
                '<div class="gim-meta" id="gimMeta"></div>',
                /* Body */
                '<div class="gim-mbody">',
                    '<div class="gim-status">',
                        '<span class="gim-dot" id="gimDot"></span>',
                        '<span class="gim-stxt" id="gimStxt">Esperando reproducción...</span>',
                    '</div>',
                    '<div class="gim-waves" id="gimWaves">',
                        '<div class="gim-wave"></div><div class="gim-wave"></div>',
                        '<div class="gim-wave"></div><div class="gim-wave"></div>',
                        '<div class="gim-wave"></div><div class="gim-wave"></div>',
                        '<div class="gim-wave"></div>',
                    '</div>',
                    '<div id="gimAudioWrap"></div>',
                '</div>',
                /* Footer */
                '<div class="gim-mfoot">',
                    '<div class="gim-hint-file" id="gimHintFile"></div>',
                '</div>',
            '</div>'
        ].join('');

        document.body.appendChild(overlay);

        // Cerrar al hacer clic en el fondo
        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) GIMPlayer.close();
        });

        // ESC cierra el modal
        document.addEventListener('keydown', function (e) {
            if ((e.key === 'Escape' || e.keyCode === 27) && overlay.classList.contains('visible')) {
                GIMPlayer.close();
            }
        });
    }

    // ─── Helpers ─────────────────────────────────────────────────────────────
    function el(id) { return document.getElementById(id); }

    function setState(state, label) {
        var dot  = el('gimDot');
        var stxt = el('gimStxt');
        var wvs  = el('gimWaves');
        if (!dot) return;
        dot.className  = 'gim-dot' + (state ? ' ' + state : '');
        stxt.className = 'gim-stxt' + (state === 'playing' ? ' active' : '');
        stxt.textContent = label;
        if (wvs) wvs.className = 'gim-waves' + (state === 'playing' ? ' playing' : '');
    }

    function fmtFecha(s) {
        if (!s) return '—';
        var p = s.split('-');
        return p.length === 3 ? p[2] + '/' + p[1] + '/' + p[0] : s;
    }

    // ─── API pública ─────────────────────────────────────────────────────────
    var GIMPlayer = {

        open: function (opts) {
            /*
             * opts = {
             *   audio  : URL del mp3/wav,
             *   prog   : nombre del programa,
             *   prod   : producto/idTR,
             *   id     : orden/id,
             *   fecha  : YYYY-MM-DD,
             *   hora   : HH:MM:SS
             * }
             */
            injectStyles();
            buildModal();

            // ── Rellenar cabecera
            el('gimTitle').textContent = opts.prog  || 'Sin nombre';
            el('gimSub').textContent   = opts.prod  || '';

            // ── Meta grid
            var metas = [];
            if (opts.id)    metas.push({ l: 'Orden',  v: opts.id,           cls: 'mono' });
            if (opts.fecha) metas.push({ l: 'Fecha',  v: fmtFecha(opts.fecha), cls: '' });
            if (opts.hora)  metas.push({ l: 'Hora Tx',v: (opts.hora || '').substr(0,5), cls: '' });
            var fileName = (opts.audio || '').split('/').pop().split('\\').pop();
            if (fileName)   metas.push({ l: 'Archivo', v: fileName, cls: '' });

            var metaHtml = '';
            metas.forEach(function (m) {
                metaHtml += '<div class="gim-mcell">'
                    + '<div class="gim-mlabel">' + m.l + '</div>'
                    + '<div class="gim-mval ' + m.cls + '">' + m.v + '</div>'
                    + '</div>';
            });
            el('gimMeta').innerHTML = metaHtml;

            // ── Hint ruta completa
            el('gimHintFile').textContent = opts.audio || '';

            // ── Construir elemento audio
            var wrap = el('gimAudioWrap');
            wrap.innerHTML = '';

            if (opts.audio) {
                var aud = document.createElement('audio');
                aud.id       = 'gimAudioEl';
                aud.controls = true;
                aud.autoplay = true;
                aud.className = 'gim-audio';
                if (aud.controlsList) aud.controlsList.add('nodownload');

                var src1 = document.createElement('source');
                src1.src  = opts.audio;
                src1.type = 'audio/mpeg';
                aud.appendChild(src1);

                var src2 = document.createElement('source');
                src2.src  = opts.audio;
                src2.type = 'audio/wav';
                aud.appendChild(src2);

                aud.innerHTML += 'Tu navegador no soporta el reproductor de audio.';

                aud.addEventListener('play',    function () { setState('playing', 'Reproduciendo...'); });
                aud.addEventListener('pause',   function () { setState('paused',  'Pausado'); });
                aud.addEventListener('ended',   function () { setState('',        'Reproducción finalizada'); });
                aud.addEventListener('waiting', function () { setState('',        'Cargando audio...'); });
                aud.addEventListener('canplay', function () {
                    if (aud.paused) setState('paused', 'Listo para reproducir');
                });
                aud.addEventListener('error',   function () { setState('',        'Error al cargar el audio'); });

                wrap.appendChild(aud);
                setState('', 'Iniciando...');
            } else {
                wrap.innerHTML = '<div class="gim-err"><i class="fas fa-exclamation-triangle" style="font-size:1.5rem;display:block;margin-bottom:8px;"></i>No hay archivo de audio disponible para este registro.</div>';
                setState('', 'Sin audio');
            }

            // ── Mostrar overlay
            el(OVERLAY_ID).classList.add('visible');
        },

        close: function () {
            var overlay = el(OVERLAY_ID);
            if (!overlay) return;
            // Pausar el audio antes de cerrar
            var aud = el('gimAudioEl');
            if (aud) { aud.pause(); aud.src = ''; }
            overlay.classList.remove('visible');
            setState('', 'Esperando reproducción...');
        }
    };

    global.GIMPlayer = GIMPlayer;

}(window));
