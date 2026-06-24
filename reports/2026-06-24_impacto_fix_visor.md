# AUDITORÍA DE IMPACTO: FIX VISOR ($_SESSION['server'])
**Proyecto:** Sistema de Cables Grupo Imagen
**Fecha:** 2026-06-24
**Autor:** AI Auditor

---

## 1. RESUMEN EJECUTIVO

Se analizó el impacto de cambiar la inicialización de $_SESSION['server'] de http://10.29.128.198 a http://10.29.128.184 en los archivos isor.php y layout/grid_template.php.

Actualmente, ambos archivos inicializan la sesión (si está vacía) apuntando al propio servidor .198. Debido a que los archivos físicos de cables (/rtrtxt/) no se han migrado y solo residen en .184, todas las peticiones fallan con HTTP 404.

Cambiar el valor a .184 restauraría la funcionalidad inmediata en todo el sistema, pero violaría directamente la regla de negocio de lograr "independencia total de .198", creando un acoplamiento fuerte y permanente con la instalación legacy (.184).

---

## 2. MAPA DE DEPENDENCIAS

La variable $_SESSION['server'] se propaga a todo el ecosistema.

**A. Archivos que INICIALIZAN la variable (Race Condition actual):**
* layout/grid_template.php (L4) -> Hardcodeado a .198
* isor.php (L4) -> Hardcodeado a .198
* cabe.php (L3-L5) -> Hardcodeado a .184 (Legacy)
* cabepi.php (L3-L5) -> Hardcodeado a .184 (Legacy PI)

*Nota:* Dependiendo de por dónde entra el usuario al sistema, se inicializa con .198 o .184, afectando toda su sesión.

**B. Archivos que DEPENDEN de grid_template.php (Se inicializarían en .184):**
39 archivos de FrontEnd moderno. Ejemplos:
fpeco.php, pcul.php, dpades.php, 
txdep.php, trfin.php, urgentes.php, 	emas_all.php.

**C. Archivos que CONSUMEN $_SESSION['server'] (Usos directos):**
* **Server-side proxy:**
  * isor.php: Usa $server para hacer ile_get_contents() desde el backend.
* **Client-side direct links (Legacy):**
  * uscar.php, inipi.php, trcul.php, dpacul.php, peco.php, etc.
  * Estos archivos concatenan $httpm =  . ['path']; y generan enlaces <a href="...httpm..." target="text">.

**D. Dependencias Ocultas:**
* **Buscador (uscar.php):** Depende de $server para renderizar 100% de los resultados.
* **Red del Cliente:** Si el cliente hace clic en un enlace legacy, **su navegador** debe tener visibilidad de red hacia 10.29.128.184.

---

## 3. RIESGOS

1. **Acoplamiento de Arquitectura (Crítico):** El servidor .198 dejará de ser independiente. Si el servidor .184 se apaga o sufre una caída, .198 también dejará de mostrar cables.
2. **Tráfico de Red Cruzado:**
   * El tráfico del isor.php fluirá como: Cliente -> .198 -> .184 -> .198 -> Cliente.
   * El tráfico de la interfaz legacy fluirá como: Cliente -> .184 (Bypass de .198).
3. **Bloqueo de red al Cliente:** Si los usuarios finales están en un segmento de red que solo permite ver .198 (y no .184), la interfaz legacy se romperá de todos modos.

---

## 4. IMPACTO ESPERADO

Si se aplica el cambio a .184:

* **Visor Moderno:** Volverá a funcionar. isor.php descargará exitosamente los HTML desde .184 y los inyectará en el nuevo FrontEnd.
* **Agencias (AFP, RTR, DPA):** Volverán a abrir notas exitosamente porque el visor usará las rutas relativas de la BD contra el host .184.
* **Buscador (Legacy):** Volverá a funcionar. Sus enlaces generados cambiarán de .198 a .184.

---

## 5. CASOS DE PRUEBA NECESARIOS (SI SE APLICA)

Si se decidiera aplicar el cambio, se debe validar:
1. Limpiar cookies/sesión e ingresar a cablesmain.php.
2. Abrir un cable reciente de **RTR** vía isor.php. (Validar HTTP 200 interno).
3. Realizar una búsqueda en uscar.php y hacer clic en un resultado. (Validar que el frame cargue directo desde .184).
4. Entrar por el legacy index.php (carga cabe.php) y luego ir a la vista moderna para verificar que la sesión no colapsa por doble inicialización.

---

## 6. PLAN DE REVERSIÓN

En caso de fallo, el rollback consistiría en:
1. Restaurar isor.php y layout/grid_template.php desde sus respaldos (.bak).
2. Forzar la destrucción de sesiones activas en PHP (session_destroy()) en todos los clientes, ya que el valor queda cacheado en el navegador del usuario hasta que se cierre la sesión.

---

## 7. RECOMENDACIÓN FINAL

**NO APROBAR** el cambio de código a .184.

**Justificación:**
El objetivo prioritario del proyecto definido en PROJECT_MASTER_CONTEXT.md es **"Hacer completamente funcional e independiente la instalación .198"**. Aplicar este parche consolida la dependencia hacia el servidor viejo. 

La falla actual no es un "error de código" en .198, sino un **error de infraestructura/migración**. El código de .198 es correcto al apuntar a sí mismo.

**Solución arquitectónica correcta:**
1. Mantener $_SESSION['server'] = "http://10.29.128.198" en todo el código (corrigiendo cabe.php y cabepi.php para que apunten a .198).
2. **Sincronizar físicamente** el directorio /opt/lampp/htdocs/rtrtxt/ desde el servidor .184 hacia el servidor .198.
3. Configurar la ingesta de cables (crawlers/cron) para que escriban localmente en .198.
