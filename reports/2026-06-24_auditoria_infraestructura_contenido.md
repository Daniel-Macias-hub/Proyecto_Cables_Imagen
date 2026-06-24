# AUDITORÍA DE INFRAESTRUCTURA DE CONTENIDO
**Proyecto:** Sistema de Cables Grupo Imagen
**Fecha:** 2026-06-24
**Autor:** AI Auditor

---

## 1. OBJETIVO
Determinar cómo llegan los archivos HTML de cables al sistema .198, por qué no existen físicamente en sus directorios, y evaluar la completitud de la migración.

---

## 2. HALLAZGOS PRINCIPALES (EL ESPEJISMO DE LA MIGRACIÓN)

La auditoría de los scripts locales en .198 revela que **la migración nunca se completó a nivel de infraestructura backend**. El servidor .198 opera actualmente como una "fachada" (FrontEnd) que parasita los datos del servidor original (.184).

### ¿Cómo llegan los cables a .198?
No existen crawlers ni procesos FTP reales en .198 que reciban cables de agencias. En su lugar, se encontraron dos scripts en X:\cables_staging\ que "roban" la información de .184:

1. **ingestor_maestro.php (Scraper):** 
   - Se describe a sí mismo como "v2 FORENSE OPERACIONAL".
   - Descarga el HTML de http://10.29.128.184/imagen/ini.php.
   - Extrae los títulos, fechas, agencias y rutas relativas (/rtrtxt/...).
   - Inserta estos metadatos en la base de datos local de .198.
   - **Confesión en código:** El script documenta explícitamente que *"El visor.php del staging ya sabe leer /rtrtxt/*.htm desde 10.29.128.184"* operando como *"proxy HTTP transparente"*.
   
2. **sync_db_maestro.php (Clonador DB):**
   - Se conecta directamente a la base de datos de .184 mediante credenciales remotas.
   - Sincroniza las tablas de cables, fotos, pi, tnews y videos hacia la BD de .198.

**Conclusión:** Los archivos físicos de cables (.htm) nunca llegan a .198. Solo llegan los registros de base de datos.

---

## 3. ANÁLISIS DEL DIRECTORIO DE CONTENIDO

A partir de consultas directas a la base de datos sincronizada:

*   **Rutas únicas almacenadas:** La única carpeta base registrada para agencias es /rtrtxt.
*   **¿AFP usa rtrtxt?:** **SÍ.**
*   **¿DPA usa rtrtxt?:** **SÍ.**
*   **¿Reuters usa rtrtxt?:** **SÍ.**
*   **¿Existen fptxt o dpatxt?:** **NO.** Históricamente, el sistema .184 configuró la ingesta de todas las agencias para vaciar los archivos en una única carpeta llamada trtxt.

### Estadísticas Actuales (Ventana de Ingesta Activa)
*   **Archivos totales en BD:** 2,834 cables (en la ventana de 5 días analizada).
*   **Fecha más antigua:** 2026-06-20.
*   **Fecha más reciente:** 2026-06-24.
*   **Distribución:** 
    *   DPA: 1,065
    *   AFP: 959
    *   Reuters (RTR): 810
*   **Frecuencia de actualización:** Continua (cron jobs o tareas programadas en .198 ejecutan los scripts de sincronización mencionados).

---

## 4. ESTADO DE LA MIGRACIÓN: INCOMPLETA

La migración a .198 se limitó a:
1. Copiar el código fuente PHP (FrontEnd y Visores).
2. Refactorizar el diseño de la interfaz web (cablesmain.php, modernización visual).
3. Instalar scripts de puente/sincronización (ingestor_maestro.php, sync_db_maestro.php) para mantener la ilusión de funcionamiento.

**Faltantes Críticos:**
No se migraron los **Demonios de Ingesta reales**. En algún lugar del servidor .184 existen procesos (scripts Perl, Bash, crons, o servicios Java/C++) que se conectan a los FTP o APIs de Reuters, AFP y DPA, descargan los archivos XML/TXT originales y los convierten a .htm dentro de /rtrtxt/.

---

## 5. REQUISITOS PARA INDEPENDENCIA REAL DE .198

Para que .198 funcione 100% por sí solo y se pueda apagar definitivamente .184, se requiere:

1. **Auditoría en .184:** Ingresar al servidor .184 vía SSH para localizar los demonios originales de ingesta de AFP, Reuters y DPA.
2. **Migración de Ingesta:** Trasladar esos demonios, sus configuraciones, claves de API y credenciales FTP hacia el servidor .198.
3. **Migración de Históricos:** Sincronizar físicamente (sync) todo el contenido de /opt/lampp/htdocs/rtrtxt/ desde .184 hacia .198.
4. **Desconexión:** Apagar ingestor_maestro.php y sync_db_maestro.php en .198.
5. **Configuración Local:** Asegurar que los nuevos demonios en .198 escriban directamente en su propia base de datos y su propio directorio local.
