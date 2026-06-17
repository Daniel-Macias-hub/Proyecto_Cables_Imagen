# GIM-AI Phase 2 - Sistema ImagenM (Legacy)

## 1. Descripción del Sistema
Sistema legacy de consulta, visualización y gestión de cables de agencias informativas (AFP, DPA, Reuters, AP, Notimex). Desarrollado originariamente para funcionar sobre entornos LAMP con versiones obsoletas de PHP (5.x).

## 2. Arquitectura Encontrada
Arquitectura monolítica y fuertemente acoplada sin el uso de Frameworks o Front Controllers. La lógica de presentación y acceso a datos está embebida en cada script de manera independiente.
* **Manejo de rutas**: Accesos directos a los scripts (`afpcul.php`, `cablesmain.php`).
* **Base de datos**: Uso extensivo de funciones `mysql_*` (deprecated) conectadas de forma *hardcoded* a `cdcol`.

## 3. Dependencias
* Ingestor Externo: Las tablas de cables (`cables`, `audios`, `videos`, `tnews`) NO son alimentadas por este código PHP. Requieren que un proceso externo (demonio o sistema de ingesta) escriba en la base de datos `cdcol`.
* Sistema de Gestión de Audios: Integración pasiva con **DALET** vía directorio `/audios/` y FTP en `tnmenu.php`.

## 4. Requisitos
* PHP 5.6 (Nativo) o PHP 8.x (Haciendo uso del Shim proveído).
* Servidor Web (Apache/Nginx).
* MySQL o MariaDB.
* Extensión PDO habilitada si se usa PHP 8.x.

## 5. Instalación local
1. Clonar este repositorio.
2. Levantar los contenedores de Docker incluidos: `docker-compose up -d`.
3. Importar el dump de la base de datos (ver siguiente sección).
4. Acceder vía `http://localhost:8080/cablesmain.php`.

## 6. Restauración de BD
Importar la base de datos en el contenedor:
```bash
docker cp cdcol_desarrollo.sql db_container:/
docker exec -it db_container mysql -u root -pd1nosauri0Z cdcol < /cdcol_desarrollo.sql
```

## 7. Uso de mysql_shim.php
Para correr este sistema legacy en PHP 8.x sin refactorizar los 485 archivos, se diseñó `mysql_shim.php`. Este script envuelve las funciones `mysql_*` y las pasa por PDO.
Para que funcione automáticamente, la configuración `.user.ini` de este repositorio inyecta:
`auto_prepend_file = "mysql_shim.php"`

## 8. Limitaciones Conocidas
* No existe ingesta en tiempo real localmente. Solo se verán noticias hasta la fecha del volcado de la BD.
* Los audios brutos de la redacción no están en el repositorio (por su enorme tamaño). 

## 9. Diferencias respecto a producción
* Rutas absolutas a `Y:\` o IPs estáticas de la LAN empresarial (`10.29...`) podrían requerir emulación local si se entra a módulos muy profundos.
* Credenciales de DB expuestas y adaptadas para el entorno de desarrollo.
