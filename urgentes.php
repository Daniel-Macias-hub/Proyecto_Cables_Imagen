<?php
$page_title = "Cables Urgentes";
// Sistema original: urge=3 es máxima prioridad, urge=2 y urge=1 también urgentes.
// Filtramos WHERE urge IN ('1','2','3') — últimos 7 días para no quedar vacíos
// Ordenado: primero los de mayor urgencia (3 > 2 > 1), luego por fecha/hora DESC
$query = "SELECT id, titulo, age, cat, fecha, hora, path, urge
          FROM cables
          WHERE urge IN ('1','2','3')
          AND fecha >= DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY)
          ORDER BY CAST(urge AS UNSIGNED) DESC, fecha DESC, hora DESC
          LIMIT 300;";
include('layout/grid_template.php');
?>
