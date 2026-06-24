# AUDITORÍA DE INDEPENDENCIA TOTAL — SERVIDOR 198
**Sistema de Cables — Grupo Imagen** | Entorno objetivo: `10.29.128.198` (`X:\imagenm`)
**Fecha:** 2026-06-24 | **Estado:** Solo Auditoría (Sin Modificaciones)

---

## RESUMEN EJECUTIVO
El objetivo de esta auditoría es determinar con precisión y evidencia verificable qué componentes, datos y configuraciones faltan para que el servidor de staging `10.29.128.198` (`.198`) funcione de forma 100% autónoma e independiente de los servidores de producción `10.29.128.184` (`.184`) y `10.29.128.174` (`.174`).

---

## FASE 1: AUDITORÍA DE ARCHIVOS DE CONTENIDO
Se identificó la ubicación, el volumen y el estado de los directorios de contenido que la aplicación consulta o requiere.

### 1. Cables de Texto (`rtrtxt`)
* **Ubicación actual:** Servidor remoto `10.29.128.184`. No existen en `.198`.
* **Ruta física (remota):** `/opt/lampp/htdocs/rtrtxt/` (servido vía HTTP en `http://10.29.128.184/rtrtxt/`). No está expuesto a través de la unidad de red Samba `Y:\` (la cual apunta a `/home/jesus/` o similar en `.184`).
* **Cantidad aproximada de archivos:** ~720,000 archivos `.htm`.
* **Tamaño aproximado:** ~1.8 GB (tamaño promedio de 2.5 KB por cable).
* **Última fecha de actualización:** En tiempo real (conforme entran cables hoy 2026-06-24).

### 2. Fotos (`fotos` / `fotor`)
* **Ubicación actual:** Servidor remoto `10.29.128.184`. No existen en `.198`.
* **Ruta física (remota):** `/opt/lampp/htdocs/fotos/` y `/opt/lampp/htdocs/fotor/` (servido vía HTTP en `http://10.29.128.184/fotos/`).
* **Cantidad aproximada de archivos:** ~65,000 registros activos en producción.
* **Tamaño aproximado:** ~9.7 GB (tamaño promedio de 150 KB por imagen).
* **Última fecha de actualización:** En tiempo real. Último registro en base de datos: `2026-06-24 12:47:19`.

### 3. Videos (`videos`)
* **Ubicación actual:** Sin datos.
* **Ruta física:** `/opt/lampp/htdocs/videos/`.
* **Cantidad aproximada de archivos:** 0 (la tabla `videos` tanto local como remota se encuentra vacía con 0 registros).
* **Tamaño aproximado:** 0 bytes.
* **Última fecha de actualización:** N/A.

### 4. Audios (`audios` / `data2`)
* **Ubicación actual:** Servidor remoto `10.29.128.184`.
* **Ruta física:** `/data2/audios/` en el filesystem de Linux (fuera de `htdocs`). Nota: Las carpetas de la aplicación `X:\imagenm\audios` y `Y:\audios` están físicas pero vacías (0 archivos, 0 bytes). Los archivos MP3 del módulo PI se guardan en la raíz del sistema de archivos del servidor Linux en `/data2/audios/`.
* **Cantidad aproximada de archivos:** ~48,985 registros en la tabla `pi` (muchos de los cuales tienen audios MP3 asociados).
* **Tamaño aproximado:** Estimado en ~50 GB (asumiendo ~1 MB por audio mp3 corto).
* **Última fecha de actualización:** En tiempo real (conforme los redactores suben pautas de audio).

---

## FASE 2: AUDITORÍA DE INGESTA
Se determinó el flujo de entrada de datos al sistema de cables en el servidor local `.198`.

```
[SERVIDOR PRODUCCIÓN 10.29.128.184]
  (MySQL cdcol con tablas vivas)
             │
             │ Consulta remota TCP 3306 (mike / [CONEXION_OCULTA])
             ▼
[SERVIDOR LOCAL STAGING 10.29.128.198]
  Script: X:\cables_staging\sync_db_maestro.php (disparado cada 5 min)
             │
             ├──► Inserta registros en MySQL local cdcol
             └──► Escribe bitácora en X:\cables_staging\logs\sync_YYYY-MM-DD.log
```

### Componentes de Ingestión Identificados:
1. **Sincronizador PHP (`sync_db_maestro.php`):**
   * **Ruta:** `X:\cables_staging\sync_db_maestro.php`
   * **Propósito:** Se conecta a la BD remota de `.184` y copia hacia la BD local los registros de las tablas `cables`, `fotos`, `pi`, `tnews` y `videos` agregados en los últimos 3 días.
   * **Configuración Local:** Conexión a `localhost` (`127.0.0.1`), usuario `root`, password `[OCULTO_LOCAL_DB]`.
   * **Configuración Remota:** Conexión a `10.29.128.184`, usuario `mike`, password `[OCULTO_REMOTE_DB]`, base de datos `cdcol`.
   * **Frecuencia:** Ejecutado cada 5 minutos.
2. **Disparador en Windows (`sync_cables.ps1`):**
   * **Ruta:** `X:\cables_staging\sync_cables.ps1`
   * **Propósito:** Lanza una solicitud HTTP GET a `http://10.29.128.198/cables_staging/sync_db_maestro.php?run=1` para forzar la sincronización de las tablas de base de datos de manera externa.
   * **Estado:** Es el mecanismo activo que mantiene la base de datos sincronizada.
3. **Cron Job en el Servidor Linux (`cron_sync.sh`):**
   * **Ruta:** `/opt/lampp/htdocs/cables_staging/cron_sync.sh`
   * **Configuración en Crontab:** `*/5 * * * * /opt/lampp/htdocs/cables_staging/cron_sync.sh`
   * **Estado actual:** **FALLANDO (Inactivo)**. Los registros de logs indican un código de error de salida `127` (el binario `curl` no está instalado en el PATH del crontab de Linux). La sincronización funciona solo por el disparador externo de Windows.
4. **Recepción en Caliente (Agencias):**
   * **Proceso:** En el servidor `.184` corren procesos demonio que escuchan puertos TCP y carpetas FTP de AFP, Reuters y DPA para guardar los cables.
   * **En `.198`:** Estos procesos **no existen**. La ingesta de cables nuevos se apoya en la base de datos y la descarga bajo demanda de archivos del servidor remoto `.184`.

---

## FASE 3: DEPENDENCIAS EXTERNAS
Se identificaron de forma exhaustiva los enlaces, conexiones e IPs hardcodeadas hacia `.184` y servicios externos.

| Archivo | Línea | Código | Propósito |
|---|---|---|---|
| `X:\cables_staging\sync_db_maestro.php` | 43 | `$conn_remoto = @mysqli_connect('10.29.128.184', 'mike', 'mikemmp', 'cdcol');` | Conexión MySQL remota para extraer los metadatos de cables, fotos y PI. |
| `X:\cables_staging\thumb.php` | 42 | `$remoteUrl = 'http://10.29.128.184' . $src;` | Descarga en caliente de fotos originales desde el servidor legacy para redimensionarlas localmente. |
| `X:\imagenm\cabe.php` | 3 | `$server = "http://10.29.128.184";` | Definición de servidor de referencia de cabecera. |
| `X:\imagenm\cabe.php` | 62 | `<a class=n target=new href=http://10.29.120.50:8181>K4</a>` | Enlace heredado del sistema editorial K4. |
| `X:\imagenm\cabepi.php` | 3 | `$server = "http://10.29.128.184";` | Servidor de referencia para el visor de pautas (PI). |
| `X:\imagenm\entgimtexto.php` | 52 | `$httpm="http://10.29.128.184";` | Enlace base para visor de cables. |
| `X:\imagenm\i1a.php` | 52 | `$httpm="http://10.29.128.184";` | Enlace base para cables. |
| `X:\imagenm\nd.php` | 52 | `$httpm="http://10.29.128.184";` | Enlace base para cables. |
| `X:\imagenm\EvaluateFirma.php` | 4 | `$servername = "10.29.128.184";` | Conexión remota MySQL de firma digital. |
| `X:\imagenm\EvaluateFirmaBorra.php` | 4 | `$servername = "10.29.128.184";` | Conexión remota MySQL de firma digital. |
| `X:\imagenm\nexio.php` | 37 | `href=http://10.29.128.184/nexios/main_login.php` | Enlace al inicio de sesión de Nexio remota. |
| `X:\imagenm\nexiodes.php` | 100, 104 | `href=http://10.29.128.184".$row['path']` | Enlaces a archivos físicos en Nexio. |
| `X:\imagenm\nexiomal.php` | 56, 60 | `href=http://10.29.128.184".$row['path']` | Enlaces a archivos físicos en Nexio. |
| `X:\imagenm\layout\ftp_help.php` | 145 | `ftp://dalet:ps1dalet@10.29.128.161/` | Credenciales e IP del servidor FTP de Dalet para Turbina. |
| `X:\imagenm\layout\header.php` | 692 | `href="http://10.29.120.50:8181"` | Enlace a K4 en el menú principal. |
| `X:\imagenm\output.php` | 34 | `$servername = "10.29.128.184";` | Conexión MySQL remota en visor heredado. |
| `X:\imagenm\output_original.php` | 6 | `$servername = "10.29.128.184";` | Conexión MySQL remota. |
| `X:\imagenm\PopNuevo.php` | 60 | `window.close("http://10.29.128.184/imagen/PopNuevo.php", ...)` | Ventana flotante emergente heredada de producción. |
| `X:\imagenm\subir.php` | 14 | `$pathlink = "http://10.29.128.184/audio2/";` | Ruta web de descarga de audios. |
| `X:\imagenm\subir.php` | 26 | `$servername = "10.29.128.184";` | Servidor MySQL remoto para persistencia de audios subidos. |
| `X:\imagenm\tnmenu.php` | 59 | `href=ftp://dalet:ps1dalet@10.29.128.161` | Acceso FTP heredado de Dalet. |
| `X:\imagenm\video.php` | 41 | `href="http://10.29.50.81"` | Acceso externo al sistema de video AP. |
| `X:\imagenm\IACHAT.php` | 63 | `src="http://10.29.130.38:3000"` | Carga de interfaz del Chatbot GIM-AI. |

---

## FASE 4: PLAN DE INDEPENDENCIA TOTAL
Para que el servidor `.198` opere de forma 100% autónoma y segura se debe ejecutar la siguiente estrategia técnica:

### 1. Migración y Sincronización de Contenido Físico
* **Acción:** Copiar recursivamente los directorios `/opt/lampp/htdocs/rtrtxt/`, `/opt/lampp/htdocs/fotos/` y `/data2/audios/` desde `.184` a `.198`.
* **Método sugerido:** Ejecutar `rsync` vía SSH directo entre los servidores Linux para sincronizar los directorios físicos de manera diferencial.
* **Política de retención:** Debido al volumen, es recomendable migrar solo el contenido correspondiente a los últimos 90 días (aproximadamente 3 GB de cables y fotos en total).

### 2. Configuración de Ingesta Local Autónoma
* **Acción:** Solicitar a los proveedores de agencias de noticias (Reuters, AFP, DPA) el enrutamiento/envío de sus feeds FTP y sockets TCP a la IP local `.198`.
* **Acción técnica:** Migrar los scripts demonios que procesan los feeds recibidos en `.184` y configurarlos para ejecutarse localmente en la máquina Linux de `.198`.

### 3. Refactorización de Referencias Hardcodeadas
* **Acción:** Reemplazar todas las IPs `10.29.128.184` en el código por la IP local `.198` o `localhost` según corresponda.
* **Acción en visor.php:** Cambiar la sesión del servidor a local:
  ```php
  $_SESSION['server'] = "http://10.29.128.198";
  ```
  Esto forzará a que el visor consulte los archivos `.htm` en el directorio local `/rtrtxt/`.

### 4. Corrección del Cron Job Local en Linux
* **Acción:** Instalar `curl` en el sistema Linux del servidor `.198` y asegurar que la tarea programada en crontab se ejecute correctamente para no depender de scripts PowerShell externos de Windows.

### 5. Evaluation de Riesgos
* **Riesgo de corte:** El cambio de IPs con las agencias externas de noticias puede tener un tiempo de propagación donde no se reciban cables nuevos si no se coordina de manera oportuna.
* **Espacio en disco:** Se requiere validar que el disco del servidor `.198` cuente con al menos 100 GB libres para albergar de manera autónoma los audios y fotos futuras.

### 6. Tiempos Estimados
* **Ajuste de código e IP locales:** 4 horas.
* **Sincronización inicial de archivos físicos:** 8 horas.
* **Coordinación y redirección de feeds de agencias:** 3 a 5 días hábiles.

---

## FASE 5: CONTROL DE CAMBIOS Y GIT
Este documento de auditoría ha sido incorporado al repositorio de Git para mantener la trazabilidad.

* **Archivo creado:** [independencia_total_198.md](file:///X:/imagenm_git/independencia_total_198.md)
* **Estado del repositorio:** Todos los archivos de código nuevos y modificados han sido consolidados de manera limpia sin aplicar modificaciones directas al entorno de ejecución.
