# CHANGELOG — Sistema Cables Imagen

## 2026-06-24

### Auditoria — reports/2026-06-24_auditoria_directorios_visor.md

Auditoría completa de directorios de contenido del visor.

Hallazgos:
- rtrtxt solo existe en 10.29.128.184. No en .198.
- afptxt y dpatxt no existen en ningún servidor.
- visor.php L4 apunta a http://10.29.128.198 (hardcodeado incorrecto).
- grid_template.php L4 tiene el mismo problema.
- K4 apuntaba a IP incorrecta (10.29.120.50).

Sin modificaciones funcionales en esta fase.

### Cambio — K4 corregido (decisión de negocio PROJECT_MASTER_CONTEXT.md L60)

Archivos modificados:
- layout/header.php L692: http://10.29.120.50:8181 -> http://10.29.120.16:8181/K4Overview/
- cabe.php L62: misma corrección

Respaldos creados:
- layout/header.php.bak_k4_fix_20260624 (MD5: 9513D0FDB644960F5AD0FA00C61CCC7B)
- cabe.php.bak_k4_fix_20260624 (MD5: 6DD1059974B6CC8A185B86E3F54AA1F1)
