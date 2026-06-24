<?php
/**
 * api_nav_counters.php
 * Endpoint JSON que devuelve contadores de las últimas 24h
 * para todas las secciones del navbar.
 * Usa una sola consulta por tabla para mínimo overhead.
 */
header('Content-Type: application/json');
header('Cache-Control: no-cache, must-revalidate');
if(!session_id()) session_start();
include_once('db.php');

$out = [];

// ── CABLES (tabla: cables) ──────────────────────────────────────────────
$r = @mysql_query("SELECT COUNT(*) as t FROM cables WHERE fecha >= CURDATE()", $conn);
$out['cables'] = ($r && $row = mysql_fetch_assoc($r)) ? (int)$row['t'] : 0;

// ── FOTOS (tabla: fotos) ────────────────────────────────────────────────
$r = @mysql_query("SELECT COUNT(*) as t FROM fotos WHERE fec >= CURDATE()", $conn);
$out['fotos'] = ($r && $row = mysql_fetch_assoc($r)) ? (int)$row['t'] : 0;

// ── VIDEO (tabla: cables cat='video') ──────────────────────────────────
$r = @mysql_query("SELECT COUNT(*) as t FROM cables WHERE cat='video' AND fecha >= CURDATE()", $conn);
$out['video'] = ($r && $row = mysql_fetch_assoc($r)) ? (int)$row['t'] : 0;

// ── X-TEMAS (tabla: cables, cat tipo temas) ────────────────────────────
// Los temas son cables que no son video — ajustar si hay otro criterio
$r = @mysql_query("SELECT COUNT(*) as t FROM cables WHERE cat != 'video' AND fecha >= CURDATE()", $conn);
$out['temas'] = ($r && $row = mysql_fetch_assoc($r)) ? (int)$row['t'] : 0;

// ── TURBINA ─────────────────────────────────────────────────────────────
// Reutiliza el mismo conteo de cables activos
$out['turbina'] = $out['cables'];

// ── PI (tabla: pi) ─────────────────────────────────────────────────────────
$r_pi = @mysql_query("SELECT COUNT(*) as t FROM pi WHERE DATE(fecha) = CURDATE()", $conn);
if ($r_pi && $row_pi = mysql_fetch_assoc($r_pi)) {
    $out['pi'] = (int)$row_pi['t'];
} else {
    $out['pi'] = 0;
}

// ── K4 ──────────────────────────────────────────────────────────────
$out['k4'] = 0;

// ── PRUEBA (tabla: pi, estacion estados) ─────────────────────────────
$r_test = @mysql_query("SELECT COUNT(*) as t FROM pi WHERE fecha BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 23 HOUR) AND estacion = 10000000001", $conn);
if ($r_test && $row_test = mysql_fetch_assoc($r_test)) {
    $out['prueba'] = (int)$row_test['t'];
} else {
    $out['prueba'] = 0;
}

echo json_encode($out);
