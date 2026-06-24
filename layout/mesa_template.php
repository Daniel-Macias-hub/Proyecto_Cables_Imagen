<?php
if(!session_id()) session_start();
include_once('db.php');

$page_title = isset($page_title) ? $page_title : "iNews - Mesa de Información";
$cola = isset($cola_name) ? $cola_name : "MESA-INFORMACION.ORDENDELDIA.REPORTEROS";

$result = mysql_query("SELECT id,num,cola,tit,rep,cam,form,foto,vid,link,estat,edo,ftp,age,idAvid,adela,aprov,modi,fmod,creby,credate,fechact FROM mesaint WHERE cola='$cola' ORDER BY id ASC", $conn);
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { background-color: transparent; padding: 20px; font-family: 'Segoe UI', sans-serif; }
        .mesa-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            margin-bottom: 20px;
            overflow: hidden;
            background-color: var(--bs-card-bg);
            border-left: 5px solid #E30613;
        }
        .meta-label { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #666; margin-right: 5px; }
        .meta-value { font-size: 0.9rem; color: #333; }
        .inews-icon { width: 40px; height: 40px; border-radius: 8px; }
        html[data-bs-theme="dark"] .meta-label { color: #aaa; }
        html[data-bs-theme="dark"] .meta-value { color: #eee; }
    </style>
</head>
<body>

<div class="container-fluid">
    <h4 class="fw-bold mb-4" style="font-family: 'Outfit', sans-serif; color: #198754;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2" style="margin-top:-4px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
        <?= $page_title ?>
    </h4>

    <div class="row">
        <?php
        if($result && mysql_num_rows($result) > 0) {
            while($row = mysql_fetch_array($result)) {
                echo "<div class='col-12'>";
                echo "  <div class='mesa-card p-3'>";
                echo "    <div class='row g-3 align-items-center'>";
                echo "      <div class='col-md-1 text-center'>";
                echo "          <div class='badge bg-success mb-2'>#".$row['num']."</div>";
                echo "          <img src='img/inews.JPG' class='inews-icon shadow-sm' alt='iNews'>";
                echo "      </div>";
                echo "      <div class='col-md-8'>";
                echo "          <h5 class='fw-bold mb-1'>".htmlspecialchars($row['tit'])."</h5>";
                echo "          <div class='row'>";
                echo "              <div class='col-md-4'><span class='meta-label'>Reportero:</span> <span class='meta-value'>".htmlspecialchars($row['rep'])."</span></div>";
                echo "              <div class='col-md-4'><span class='meta-label'>Cámara:</span> <span class='meta-value'>".htmlspecialchars($row['cam'])."</span></div>";
                echo "              <div class='col-md-4'><span class='meta-label'>Agencia:</span> <span class='meta-value'>".htmlspecialchars($row['age'])."</span></div>";
                echo "          </div>";
                echo "          <div class='row mt-1 small'>";
                echo "              <div class='col-md-4'><span class='meta-label'>Estado:</span> <span class='meta-value'>".$row['edo']."</span></div>";
                echo "              <div class='col-md-4'><span class='meta-label'>Estatus:</span> <span class='meta-value'>".$row['estat']."</span></div>";
                echo "              <div class='col-md-4 text-muted'>📅 ".$row['fechact']."</div>";
                echo "          </div>";
                echo "      </div>";
                echo "      <div class='col-md-3 text-end'>";
                echo "          <a href='text.php?action=ineint&id=".$row['id']."' class='btn btn-outline-danger btn-sm rounded-pill'>Ver Detalles</a>";
                echo "      </div>";
                echo "    </div>";
                echo "  </div>";
                echo "</div>";
            }
        } else {
            echo "<div class='col-12'>";
            $empty_state_text = "Por el momento no se encuentran historias<br>disponibles en esta cola de iNews";
            include 'layout/empty_state.php';
            echo "</div>";
        }
        ?>
    </div>
</div>

<script>
function syncTheme() {
    const theme = localStorage.getItem('theme') || (window.parent && window.parent.document.documentElement.getAttribute('data-bs-theme')) || 'light';
    document.documentElement.setAttribute('data-bs-theme', theme);
}
syncTheme();
</script>
</body>
</html>
