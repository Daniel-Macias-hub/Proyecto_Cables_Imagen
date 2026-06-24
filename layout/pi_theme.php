<?php /* Fragmento de tema compartido para páginas Pi en iframe */ ?>
<script>
(function() {
    // Leer el tema del padre (mismo origen) o del localStorage
    var theme = 'dark';
    try {
        theme = window.parent.localStorage.getItem('theme') || localStorage.getItem('theme') || 'dark';
    } catch(e) {
        theme = localStorage.getItem('theme') || 'dark';
    }
    document.documentElement.setAttribute('data-pi-theme', theme);

    // Escuchar cambios de tema desde el padre
    try {
        window.parent.document.getElementById('themeToggleBtn') &&
        window.parent.document.getElementById('themeToggleBtn').addEventListener('change', function() {
            var t = this.checked ? 'dark' : 'light';
            document.documentElement.setAttribute('data-pi-theme', t);
        });
    } catch(e) {}
})();
</script>
<style>
/* ── LIGHT THEME OVERRIDES para páginas Pi ── */
:root[data-pi-theme="light"] body,
html[data-pi-theme="light"] body {
    background: #f4f5f7 !important;
    color: #1a1a1a !important;
}
html[data-pi-theme="light"] .pi-header,
html[data-pi-theme="light"] .prog-header {
    background: linear-gradient(135deg, #E30613 0%, #c00010 100%) !important;
}
html[data-pi-theme="light"] .program-btn,
html[data-pi-theme="light"] .pi-card,
html[data-pi-theme="light"] .prog-card,
html[data-pi-theme="light"] .filters-bar {
    background: #ffffff !important;
    border-color: rgba(0,0,0,0.1) !important;
    color: #1a1a1a !important;
}
html[data-pi-theme="light"] .program-btn:hover,
html[data-pi-theme="light"] .pi-card:hover,
html[data-pi-theme="light"] .prog-card:hover {
    background: #f0f0f0 !important;
    border-color: #E30613 !important;
    color: #1a1a1a !important;
}
html[data-pi-theme="light"] .prog-name,
html[data-pi-theme="light"] .pi-nombre { color: #1a1a1a !important; }
html[data-pi-theme="light"] .prog-sub,
html[data-pi-theme="light"] .pi-meta-item,
html[data-pi-theme="light"] .pi-meta-item span,
html[data-pi-theme="light"] .prog-arrow,
html[data-pi-theme="light"] .results-label { color: #555 !important; }
html[data-pi-theme="light"] .filter-input {
    background: #f4f5f7 !important;
    border-color: rgba(0,0,0,0.15) !important;
    color: #1a1a1a !important;
}
html[data-pi-theme="light"] select.filter-input option { background: #fff; color: #1a1a1a; }
html[data-pi-theme="light"] .btn-apply {
    background: #eeeeee !important;
    border-color: rgba(0,0,0,0.15) !important;
    color: #1a1a1a !important;
}
html[data-pi-theme="light"] .pi-obs {
    background: rgba(0,0,0,0.04) !important;
    color: #555 !important;
}
html[data-pi-theme="light"] .filter-group label,
html[data-pi-theme="light"] .pi-header small { color: rgba(0,0,0,0.45) !important; }
html[data-pi-theme="light"] .empty-hist,
html[data-pi-theme="light"] .empty-state { color: rgba(0,0,0,0.25) !important; }
html[data-pi-theme="light"] .pi-header h6,
html[data-pi-theme="light"] .page-title-left h2 { color: #1a1a1a !important; }
html[data-pi-theme="light"] .page-title-left p { color: #666 !important; }
</style>
