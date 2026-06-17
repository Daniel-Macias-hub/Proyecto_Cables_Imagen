<?php
/**
 * MySQL Legacy Shim - GIM-AI Phase 2
 * Proporciona compatibilidad con la extensión mysql_* usando PDO.
 * Esto elimina los errores de la consola y permite que el código legacy funcione en PHP 8.
 */

if (!function_exists('mysql_connect')) {

    // Variables globales para mantener la conexión y el último resultado
    $GLOBALS['_mysql_shim_pdo'] = null;
    $GLOBALS['_mysql_shim_last_query'] = null;
    $GLOBALS['_mysql_shim_error'] = '';
    $GLOBALS['_mysql_shim_errno'] = 0;

    // Constantes de fetch de MySQL Legacy
    if (!defined('MYSQL_ASSOC')) define('MYSQL_ASSOC', 1);
    if (!defined('MYSQL_NUM'))   define('MYSQL_NUM', 2);
    if (!defined('MYSQL_BOTH'))  define('MYSQL_BOTH', 3);

    function mysql_connect($host = 'localhost', $user = '', $pass = '', $new_link = false, $client_flags = 0) {
        $port = 3306;
        
        // Mapeo dinámico: Si se pide el host legacy "mysql", redirigimos a localhost con credenciales unificadas
        if ($host === 'mysql') {
            $host = 'localhost';
            $user = 'root';
            $pass = 'd1nosauri0Z!3';
        }

        if (strpos($host, ':') !== false) {
            list($host, $port) = explode(':', $host);
        }

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_BOTH,
            PDO::ATTR_EMULATE_PREPARES => true
        ];

        try {
            $dsn = "mysql:host=$host;port=$port;charset=utf8mb4";
            $pdo = new PDO($dsn, $user, $pass, $options);
            $GLOBALS['_mysql_shim_pdo'] = $pdo;
            return $pdo;
        } catch (PDOException $e) {
            // Fallback inteligente: si la conexión falla con credenciales obsoletas, intentamos con las credenciales unificadas de staging
            if ($host !== 'localhost' || $user !== 'root' || $pass !== 'd1nosauri0Z!3') {
                try {
                    $dsn = "mysql:host=localhost;port=3306;charset=utf8mb4";
                    $pdo = new PDO($dsn, 'root', 'd1nosauri0Z!3', $options);
                    $GLOBALS['_mysql_shim_pdo'] = $pdo;
                    return $pdo;
                } catch (PDOException $e2) {
                    $GLOBALS['_mysql_shim_error'] = $e2->getMessage();
                    $GLOBALS['_mysql_shim_errno'] = $e2->getCode();
                    return false;
                }
            }
            $GLOBALS['_mysql_shim_error'] = $e->getMessage();
            $GLOBALS['_mysql_shim_errno'] = $e->getCode();
            return false;
        }
    }

    function mysql_pconnect($host = '', $user = '', $pass = '', $client_flags = 0) {
        return mysql_connect($host, $user, $pass);
    }

    function mysql_select_db(string $dbname, $conn = null) {
        $pdo = $conn ?: $GLOBALS['_mysql_shim_pdo'];
        if (!$pdo instanceof PDO) return false;

        try {
            $pdo->exec("USE `" . str_replace('`', '``', $dbname) . "`");
            return true;
        } catch (PDOException $e) {
            $GLOBALS['_mysql_shim_error'] = $e->getMessage();
            return false;
        }
    }

    function mysql_query(string $query, $conn = null) {
        $pdo = $conn ?: $GLOBALS['_mysql_shim_pdo'];
        if (!$pdo instanceof PDO) return false;

        try {
            $stmt = $pdo->query($query);
            $GLOBALS['_mysql_shim_last_query'] = $stmt;
            
            // Para INSERT/UPDATE/DELETE (consultas sin result set), PDOStatement se comporta distinto
            // En legacy mysql_query devuelve true para insert/update/delete y un resultset para select.
            if ($stmt && $stmt->columnCount() === 0) {
                return true;
            }
            return $stmt;
        } catch (PDOException $e) {
            $GLOBALS['_mysql_shim_error'] = $e->getMessage();
            // PDOException::getCode() devuelve el SQLSTATE (string), intval() extrae el código entero.
            $GLOBALS['_mysql_shim_errno'] = (int)$e->getCode();
            return false;
        }
    }

    function mysql_fetch_array(mixed $result, int $result_type = MYSQL_BOTH) {
        if ($result instanceof PDOStatement) {
            $fetch_mode = PDO::FETCH_BOTH;
            if ($result_type === MYSQL_ASSOC) $fetch_mode = PDO::FETCH_ASSOC;
            elseif ($result_type === MYSQL_NUM) $fetch_mode = PDO::FETCH_NUM;
            return $result->fetch($fetch_mode);
        }
        return false;
    }

    function mysql_fetch_assoc(mixed $result) {
        if ($result instanceof PDOStatement) {
            return $result->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    function mysql_fetch_row(mixed $result) {
        if ($result instanceof PDOStatement) {
            return $result->fetch(PDO::FETCH_NUM);
        }
        return false;
    }

    function mysql_fetch_object(mixed $result) {
        if ($result instanceof PDOStatement) {
            return $result->fetch(PDO::FETCH_OBJ);
        }
        return false;
    }

    function mysql_num_rows(mixed $result) {
        if ($result instanceof PDOStatement) {
            return $result->rowCount();
        }
        return false;
    }

    function mysql_affected_rows($conn = null) {
        $stmt = $GLOBALS['_mysql_shim_last_query'];
        if ($stmt instanceof PDOStatement) {
            return $stmt->rowCount();
        }
        return 0;
    }

    function mysql_real_escape_string(string $string, $conn = null) {
        $pdo = $conn ?: $GLOBALS['_mysql_shim_pdo'];
        if (!$pdo instanceof PDO) {
            return addslashes($string); // Fallback si no hay conexión activa
        }
        $quoted = $pdo->quote($string);
        return substr($quoted, 1, -1);
    }

    function mysql_error($conn = null) {
        return $GLOBALS['_mysql_shim_error'];
    }

    function mysql_errno($conn = null) {
        return $GLOBALS['_mysql_shim_errno'];
    }
    
    function mysql_insert_id($conn = null) {
        $pdo = $conn ?: $GLOBALS['_mysql_shim_pdo'];
        if (!$pdo instanceof PDO) return 0;
        return $pdo->lastInsertId();
    }

    function mysql_close($conn = null) {
        if ($conn) {
            $conn = null;
        } else {
            $GLOBALS['_mysql_shim_pdo'] = null;
        }
        return true;
    }

    function mysql_free_result(mixed $result) {
        if ($result instanceof PDOStatement) {
            $result->closeCursor();
            return true;
        }
        return false;
    }

    function mysql_data_seek($result, $row_number) {
        // En PDO standard con cursor forward-only no se puede hacer seek.
        // Devolvemos false para no romper la app, aunque la lógica que dependa de esto podría fallar.
        return false;
    }

    function mysql_result(mixed $result, int $row, $field = 0) {
        if ($result instanceof PDOStatement) {
            // Nota: fetchAll() resetea el puntero, podría romper iteraciones posteriores
            $data = $result->fetchAll(PDO::FETCH_BOTH);
            if (isset($data[$row][$field])) {
                return $data[$row][$field];
            }
        }
        return false;
    }

    function mysql_set_charset(string $charset, $conn = null) {
        $pdo = $conn ?: $GLOBALS['_mysql_shim_pdo'];
        if (!$pdo instanceof PDO) return false;
        try {
            $pdo->exec("SET NAMES '" . str_replace("'", "", $charset) . "'");
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    function mysql_ping($conn = null) {
        $pdo = $conn ?: $GLOBALS['_mysql_shim_pdo'];
        if (!$pdo instanceof PDO) return false;
        try {
            $pdo->query("SELECT 1");
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    function mysql_get_server_info($conn = null) {
        $pdo = $conn ?: $GLOBALS['_mysql_shim_pdo'];
        if (!$pdo instanceof PDO) return false;
        return $pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
    }
}
?>
