<!-- layout/sidebar_fotos.php -->
<div class="col-lg-2 col-md-3 sidebar-column p-0 d-none d-md-flex">
    <div class="card shadow-sm border-0 h-100 d-flex flex-column bg-transparent">
        <div class="card-header text-white fw-bold sticky-top d-flex align-items-center justify-content-center" style="background-color: #E30613; font-family: 'Outfit', sans-serif; letter-spacing: 0.5px; z-index: 10; height: 46px; padding: 0 15px;">
            <span style="white-space: nowrap; font-size: 0.9rem;">GALERÍA FOTOS</span>
        </div>
        <div class="list-group list-group-flush flex-grow-1 overflow-auto" style="padding-bottom: 100px;">
            <a href="fotos_all.php" target="mainIframe" class="list-group-item list-group-item-action py-2 px-3 fw-bold" style="border-bottom: 2px solid #E30613; color: var(--bs-body-color);">
                Ver todas las fotos
            </a>

            <!-- AFP -->
            <div class="list-group-item fw-bold text-uppercase mt-2 py-1 d-flex align-items-center justify-content-between" style="font-size: 0.7rem; letter-spacing: 1px; background-color: rgba(var(--bs-tertiary-bg-rgb), 0.5); border-top: 6px solid #009FE3; border-left: 4px solid #009FE3; color: #009FE3;">
                <span>AFP NOTISECTOR</span>
                <svg viewBox="0 0 120 50" width="35" height="16" style="opacity: 0.9;"><rect width="120" height="50" fill="#0072b9" rx="6"/><text x="60" y="37" font-family="Arial Black" font-size="34" font-weight="900" font-style="italic" fill="#ffffff" text-anchor="middle">AFP</text></svg>
            </div>
            <a href="fnafppol.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-3 small">Politica</a>
            <a href="fnafpinter.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-3 small">International</a>
            <a href="fnafpdepo.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-3 small">Deportes</a>
            <a href="fnapclima.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-3 small">Clima</a>
            <a href="fnafpespecta.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-3 small">Espectaculos</a>
            <a href="fnapfinan.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-3 small">Finanzas</a>
            <a href="fnafpwar.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-3 small">Conflicto</a>
            <a href="fnafpdes.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-3 small fw-bold" style="color: #009FE3;">AFP (TODOS)</a>

            <!-- DPA -->
            <div class="list-group-item fw-bold text-uppercase mt-1 py-1 d-flex align-items-center justify-content-between" style="font-size: 0.7rem; border-top: 5px solid currentColor; letter-spacing: 1px; background-color: rgba(var(--bs-tertiary-bg-rgb), 0.5); border-left: 4px solid #00d1b2; color: #00d1b2;">
                <span>DPA ALEMANA</span>
                <div style="display: flex; gap: 2px; opacity: 1;"><span style="width: 5px; height: 5px; background: #00d1b2; border-radius: 50%;"></span><span style="width: 5px; height: 5px; background: #00d1b2; border-radius: 50%;"></span><span style="width: 5px; height: 5px; background: #00d1b2; border-radius: 50%;"></span></div>
            </div>
            <a href="fndpapol.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-3 small">Politica</a>
            <a href="fndpadep.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-3 small">Deportes</a>
            <a href="fndpaint.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-3 small">International</a>
            <a href="fndpaesp.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-3 small">Espectaculos</a>
            <a href="fndpades.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-3 small fw-bold" style="color: #00d1b2;">DPA (TODOS)</a>

            <!-- Reuters -->
            <div class="list-group-item fw-bold text-uppercase mt-1 py-1 d-flex align-items-center justify-content-between" style="font-size: 0.7rem; border-top: 5px solid currentColor; letter-spacing: 1px; background-color: rgba(var(--bs-tertiary-bg-rgb), 0.5); border-left: 4px solid #FF8000; color: #FF8000;">
                <span>REUTERS NEWS</span>
                <svg viewBox="0 0 100 100" width="18" height="18" style="opacity: 0.9;"><g fill="#f08100"><circle cx="50" cy="50" r="10"/><circle cx="50" cy="20" r="8"/><circle cx="50" cy="80" r="8"/><circle cx="20" cy="50" r="8"/><circle cx="80" cy="50" r="8"/></g></svg>
            </div>
            <a href="fnrtrdep.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-3 small">Deportes</a>
            <a href="fnrtrinter.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-3 small">Internacional</a>
            <a href="fnrtrdom.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-3 small">Domestic</a>
            <a href="fnrtreco.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-3 small">Negocios</a>
            <a href="fnrtresp.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-3 small">Espectáculos</a>
            <a href="frtrdes.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-3 small fw-bold" style="color: #FF8000;">REUTERS (TODOS)</a>

            <!-- Notimex -->
            <!-- [COMENTADO TEMPORALMENTE - Notimex]
            <div class="list-group-item fw-bold text-uppercase mt-1 py-1 d-flex align-items-center justify-content-between" style="font-size: 0.7rem; border-top: 6px solid #E30613 !important; letter-spacing: 1px; background-color: rgba(var(--bs-tertiary-bg-rgb), 0.5); border-left: 4px solid #E30613; color: #E30613;">
                <span>NOTIMEX MÉXICO</span>
                <span style="font-family: Arial Black; font-size: 13px; color: #E30613; letter-spacing: -1px; opacity: 0.9;">NTX</span>
            </div>
            <a href="fndes.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-3 small fw-bold" style="color: #E30613;">NOTIMEX (TODOS)</a>
            -->
        </div>
    </div>
</div>
