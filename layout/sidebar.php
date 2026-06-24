<?php
// Layout Sidebar (Sustituye a cablesmenu.php)
?>
<div class="col-lg-2 col-md-3 sidebar-column p-0 d-none d-md-flex">
    <div class="card shadow-sm border-0 h-100 d-flex flex-column bg-transparent">
        <div class="card-header text-white fw-bold sticky-top d-flex align-items-center justify-content-center" style="background-color: #E30613; font-family: 'Outfit', sans-serif; letter-spacing: 0.5px; z-index: 10; height: 46px; padding: 0 15px;">
            <span style="white-space: nowrap; font-size: 0.9rem;">AGENCIAS Y SECCIONES</span>
        </div>
        <div class="list-group list-group-flush flex-grow-1 overflow-auto" style="padding-bottom: 100px;">
            <a href="ini.php" target="mainIframe" class="list-group-item list-group-item-action fw-bold mb-1 d-flex align-items-center" style="color: #009FE3; border-left: 5px solid #009FE3; background-color: rgba(0,159,227,0.05);">
                <i class="fas fa-stream me-2"></i> Últimos Cables
            </a>
            <a href="urgentes.php" target="mainIframe" class="list-group-item list-group-item-action fw-bold mb-2 shadow-sm d-flex align-items-center justify-content-center" style="background-color: #E30613; color: white !important; border: none; border-radius: 4px;">
                <i class="fas fa-bolt me-2"></i> URGENTES
            </a>
            
            <div class="list-group-item fw-bold text-uppercase mt-2 py-2 d-flex align-items-center justify-content-between" style="font-size: 0.7rem; letter-spacing: 1px; color: var(--bs-body-color); background-color: rgba(var(--bs-tertiary-bg-rgb), 0.5); border-left: 4px solid #009FE3;">
                <span>AFP NOTISECTOR</span>
                <svg viewBox="0 0 120 50" width="40" height="18" style="opacity: 0.9;"><rect width="120" height="50" fill="#0072b9" rx="6"/><text x="60" y="37" font-family="Arial Black" font-size="34" font-weight="900" font-style="italic" fill="#ffffff" text-anchor="middle">AFP</text></svg>
            </div>
            <a href="afpdes.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-3 small fw-bold" style="color: #E30613;">AFP (TODOS)</a>
            <a href="afpcul.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-4 small">Cultura</a>
            <a href="afpdep.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-4 small">Deportes</a>
            <a href="afpeco.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-4 small">Economía</a>
            <a href="afpesp.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-4 small">Espectáculos</a>
            <a href="afpfin.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-4 small">PoliciaYJusticia</a>
            <a href="afpinter.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-4 small">Internacional</a>
            <a href="afppol.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-4 small">Politica</a>
            
            <div class="list-group-item fw-bold text-uppercase mt-3 py-2 d-flex align-items-center justify-content-between" style="font-size: 0.7rem; letter-spacing: 1px; color: var(--bs-body-color); background-color: rgba(var(--bs-tertiary-bg-rgb), 0.5); border-left: 4px solid #FF8000;">
                <span>REUTERS NEWS</span>
                <svg viewBox="0 0 100 100" width="20" height="20" style="opacity: 0.9;"><g fill="#f08100"><circle cx="50" cy="50" r="10"/><circle cx="50" cy="20" r="8"/><circle cx="50" cy="80" r="8"/><circle cx="20" cy="50" r="8"/><circle cx="80" cy="50" r="8"/></g></svg>
            </div>
            <a href="rtrdes.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-3 small fw-bold" style="color: #E30613;">REUTERS (TODOS)</a>
            <a href="rtrdep.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-4 small">Deportes</a>
            <a href="rtreco.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-4 small">Economía</a>
            <a href="rtresp.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-4 small">Espectáculos</a>
            <a href="rtrinter.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-4 small">Internacional</a>

            <!-- [COMENTADO TEMPORALMENTE - NOTIMEX]
            <div class="list-group-item fw-bold text-uppercase mt-3 py-2 d-flex align-items-center justify-content-between" style="font-size: 0.7rem; letter-spacing: 1px; color: var(--bs-body-color); background-color: rgba(var(--bs-tertiary-bg-rgb), 0.5); border-left: 4px solid #E30613;">
                <span>NOTIMEX MÉXICO</span>
                <span style="font-family: Arial Black; font-size: 14px; color: #E30613; letter-spacing: -1px; opacity: 0.9;">NTX</span>
            </div>
            <a href="ntxdes.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-3 small fw-bold" style="color: #E30613;">NOTIMEX (TODOS)</a>
            <a href="ntxcli.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-4 small">Clima</a>
            <a href="ntxdep.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-4 small">Deportes</a>
            <a href="ntxesp.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-4 small">Espectáculos</a>
            <a href="ntxfin.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-4 small">Negocios</a>
            <a href="ntxmet.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-4 small">Metrópoli</a>
            <a href="ntxinter.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-4 small">Internacional</a>
            <a href="ntxnac.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-4 small">Nacional</a>
            <a href="ntxedos.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-4 small">Estados</a>
            <a href="ntxtec.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-4 small">Ciencia y Tec</a>
            <a href="ntxseg.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-4 small">Seguridad y Jus</a>
            <a href="ntxelect.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-4 small">Electoral</a>
            -->
            
            <!-- [COMENTADO TEMPORALMENTE - AP]
            <div class="list-group-item fw-bold text-uppercase mt-3 py-2 d-flex align-items-center justify-content-between" style="font-size: 0.7rem; letter-spacing: 1px; color: var(--bs-body-color); background-color: rgba(var(--bs-tertiary-bg-rgb), 0.5); border-left: 4px solid #333;">
                <span>ASSOCIATED PRESS</span>
                <span style="font-family: 'Times New Roman', serif; font-size: 16px; font-weight: bold; color: #E31837; opacity: 0.9;">AP</span>
            </div>
            <a href="apdes.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-3 small fw-bold" style="color: #E30613;">AP (TODOS)</a>
            <a href="apcul.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-4 small">Cultura</a>
            <a href="apdep.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-4 small">Deportes</a>
            <a href="apesp.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-4 small">Espectáculos</a>
            <a href="apfin.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-4 small">Finanzas</a>
            <a href="apinter.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-4 small">Internacional</a>
            -->
            
            <div class="list-group-item fw-bold text-uppercase mt-3 py-2 d-flex align-items-center justify-content-between" style="font-size: 0.7rem; letter-spacing: 1px; color: var(--bs-body-color); background-color: rgba(var(--bs-tertiary-bg-rgb), 0.5); border-left: 4px solid #00d1b2;">
                <span>DPA ALEMANA</span>
                <div style="display: flex; gap: 2px; opacity: 1;"><span style="width: 5px; height: 5px; background: #00d1b2; border-radius: 50%;"></span><span style="width: 5px; height: 5px; background: #00d1b2; border-radius: 50%;"></span><span style="width: 5px; height: 5px; background: #00d1b2; border-radius: 50%;"></span></div>
            </div>
            <a href="dpades.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-3 small fw-bold" style="color: #00d1b2;">DPA (TODOS)</a>
            <a href="dpaint.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-4 small">Internacional</a>
            <a href="dpaesp.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-4 small">Espectáculos</a>
            <a href="dpadep.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-4 small">Deportes</a>
            <a href="dpaeco.php" target="mainIframe" class="list-group-item list-group-item-action py-1 px-4 small">Economía</a>

            <!-- [NUEVOS BLOQUES: REDACCIÓN GIM y TURBINA] -->
            <!-- [COMENTADO TEMPORALMENTE - REDACCIÓN GIM HEADER]
            <div class="list-group-item fw-bold text-uppercase mt-3 py-2 d-flex align-items-center gap-2" style="font-size: 0.7rem; letter-spacing: 1.5px; color: var(--bs-body-color); background-color: rgba(var(--bs-tertiary-bg-rgb), 0.5); border-left: 4px solid #E30613;">
                <i class="fas fa-pen-nib"></i> REDACCIÓN GIM
            </div>
            -->

            <div class="list-group-item fw-bold text-uppercase mt-3 py-2 d-flex align-items-center justify-content-between" style="font-size: 0.7rem; letter-spacing: 1.5px; color: var(--bs-body-color); background-color: rgba(var(--bs-tertiary-bg-rgb), 0.5); border-left: 4px solid #E30613;">
                <span><i class="fas fa-users me-2"></i> TURBINA</span>
            </div>
            <a href="0red.php" target="mainIframe" class="list-group-item list-group-item-action d-flex align-items-center gap-2 small">0.REDACCION</a>
            <a href="i1a.php" target="mainIframe" class="list-group-item list-group-item-action d-flex align-items-center gap-2 small">1a EMISION</a>
            <a href="entgimtexto.php" target="mainIframe" class="list-group-item list-group-item-action d-flex align-items-center gap-2 small">ENTGIMTEXTO</a>

            <!-- [COMENTADO TEMPORALMENTE - ENLACES ORIGINALES TURBINA]
            <a href="mesat.php" target="mainIframe" class="list-group-item list-group-item-action d-flex align-items-center gap-2 small">Reporteros</a>
            <a href="mesac.php" target="mainIframe" class="list-group-item list-group-item-action d-flex align-items-center gap-2 small">Corresponsales</a>
            <a href="mesae.php" target="mainIframe" class="list-group-item list-group-item-action d-flex align-items-center gap-2 small">Entrevistas</a>
            <a href="audios.php" target="mainIframe" class="list-group-item list-group-item-action d-flex align-items-center gap-2 small">1.AUDIOS</a>
            <a href="layout/ftp_help.php" target="mainIframe" title="Instrucciones para acceder al servidor de audios FTP" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between small">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-headphones-alt" style="color:#E30613;"></i>
                    ENTGIMAUDIO
                </div>
                <i class="fas fa-info-circle opacity-50"></i>
            </a>
            <a href="nd.php" target="mainIframe" class="list-group-item list-group-item-action d-flex align-items-center gap-2 small">
                <i class="fas fa-newspaper" style="color:#E30613;"></i> ND - Redacción
            </a>
            -->
        </div>
    </div>
</div>
