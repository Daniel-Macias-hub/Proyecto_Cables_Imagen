# AUDITORÍA DE DIRECTORIOS DE CONTENIDO — VISOR.PHP
**Proyecto:** Sistema de Cables Grupo Imagen
**Servidor auditado:** `10.29.128.198` (`X:\imagenm`)
**Fecha:** 2026-06-24
**Tipo:** Solo Lectura | Sin Modificaciones
**Protocolo:** AI_OPERATING_PROTOCOL.md

---

## 1. OBJETIVO

Verificar la existencia de los directorios `afptxt`, `rtrtxt` y `dpatxt`, determinar su ubicación real, y verificar si `visor.php` construye correctamente las rutas.

---

## 2. VERIFICACIÓN VIA FILESYSTEM (SMB)

| Directorio | X:\ (raíz .198) | X:\imagenm | Y:\ (raíz .184) | Y:\imagen |
|---|---|---|---|---|
| rtrtxt | NO | NO | NO | NO |
| afptxt | NO | NO | NO | NO |
| dpatxt | NO | NO | NO | NO |
| fotos  | NO | NO | NO | NO |
| videos | NO | NO | NO | NO |
| audios | NO | SÍ (vacío) | SÍ (vacío) | NO |

Conclusión: rtrtxt, afptxt y dpatxt no existen en ningún punto de montaje SMB accesible.

---

## 3. VERIFICACIÓN VIA HTTP (2026-06-24 14:14:52)

| URL | HTTP Status |
|---|---|
| http://10.29.128.198/rtrtxt/ | 404 NOT FOUND |
| http://10.29.128.198/afptxt/ | 404 NOT FOUND |
| http://10.29.128.198/dpatxt/ | 404 NOT FOUND |
| http://10.29.128.184/rtrtxt/ | 200 OK |
| http://10.29.128.184/afptxt/ | 404 NOT FOUND |
| http://10.29.128.184/dpatxt/ | 404 NOT FOUND |

Hallazgo crítico: /rtrtxt/ SOLO existe en 10.29.128.184.
Los directorios /afptxt/ y /dpatxt/ NO existen en ningún servidor.

---

## 4. UBICACIÓN REAL DE ARCHIVOS FÍSICOS

`
Servidor:  10.29.128.184
Ruta HTTP: http://10.29.128.184/rtrtxt/{nombre_archivo}.htm
Ruta FS:   /opt/lampp/htdocs/rtrtxt/ (inferido del DocumentRoot)
`

Todas las agencias (AFP, Reuters, DPA) usan el MISMO directorio /rtrtxt/:

| Agencia | Ejemplo de path en BD |
|---|---|
| AFP | /rtrtxt/afp.com-20260624T193606Z-TX-PAR-GDC03.htm |
| RTR | /rtrtxt/2026-06-24Txxxxx_..._RTRMADT_0_TITULO.htm |
| DPA | /rtrtxt/0624epi00099.htm |

Los directorios afptxt y dpatxt NO se usan en este sistema.

---

## 5. ANÁLISIS DE visor.php

Archivo: X:\imagenm\visor.php (123 líneas)

Flujo de construcción de ruta:
  L4:  \['server'] = "http://10.29.128.198"; <-- HARDCODED INCORRECTO
  L6:  \ = \['server'];
  L8:  \ = \['path']; // = "/rtrtxt/0624epi00099.htm"
  L19: \ = \ . \;
        = "http://10.29.128.198/rtrtxt/0624epi00099.htm" -> HTTP 404
  L20: file_get_contents(\); -> false

Verificación con rutas reales de BD:

| Path (desde BD) | .198 HTTP | .184 HTTP |
|---|---|---|
| /rtrtxt/0624epi00099.htm | 404 | 200 / 3,114 B |
| /rtrtxt/afp.com-20260624T193606Z-TX-PAR-GDC03.htm | 404 | 200 / 2,377 B |
| /rtrtxt/afp.com-20260624T192842Z-TX-PAR-GDB92.htm | 404 | 200 / 2,787 B |

Confirmación en runtime:
GET http://10.29.128.198/imagenm/visor.php?path=%2Frtrtxt%2F0624epi00099.htm
-> HTTP 200 (marco HTML visible)
-> Mensaje: "El cable está dañado o inaccesible"
-> URL fallida: http://10.29.128.198/rtrtxt/0624epi00099.htm (HTTP 404)

La lógica de construcción de ruta es CORRECTA.
El problema es el VALOR de \['server'] (apunta a .198 en vez de .184).

---

## 6. REFERENCIAS EN CÓDIGO

| Patrón | Archivos en X:\imagenm | Resultado |
|---|---|---|
| /rtrtxt/ | Ningún .php | No está hardcodeado en código. Solo en BD. |
| /afptxt/ | Ningún .php | No referenciado en código ni BD. |
| /dpatxt/ | Ningún .php | No referenciado en código ni BD. |
| _SESSION['server'] | visor.php L4, grid_template.php L4 | Ambos apuntan a http://10.29.128.198 |

---

## 7. ESTADO DEL ENLACE K4

| Archivo | Línea | Valor Actual | Valor Correcto (PROJECT_MASTER_CONTEXT.md L60) |
|---|---|---|---|
| layout/header.php | 692 | http://10.29.120.50:8181 | http://10.29.120.16:8181/K4Overview/ |
| cabe.php | 62 | http://10.29.120.50:8181 | http://10.29.120.16:8181/K4Overview/ |

---

## 8. CONCLUSIONES

| # | Hallazgo | Severidad |
|---|---|---|
| 1 | afptxt y dpatxt no existen en ningún servidor ni son usados | Informativa |
| 2 | rtrtxt solo existe en .184 - NO en .198 | CRÍTICA |
| 3 | visor.php L4 apunta a .198 que no tiene /rtrtxt/ - todo cable falla | CRÍTICA |
| 4 | grid_template.php L4 también tiene .198 hardcodeado | CRÍTICA |
| 5 | K4 en header.php y cabe.php apunta a IP incorrecta (10.29.120.50) | MEDIA |
| 6 | La lógica de construcción de ruta en visor.php es correcta | Informativa |

---

*Auditoría completada sin modificaciones. Evidencia: HTTP real + análisis de código fuente.*
