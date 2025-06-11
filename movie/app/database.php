<?php

/* database connection stuff here
 * 
 */

function db_connect() {
    try { 
        // Default to MySQL if DB_DRIVER is not set
        $driver = defined('DB_DRIVER') ? DB_DRIVER : 'mysql';
        $port = defined('DB_PORT') ? DB_PORT : ($driver === 'pgsql' ? '5432' : '3306');
        
        if ($driver === 'pgsql') {
            // PostgreSQL connection string
            $dsn = "pgsql:host=" . DB_HOST . ";port=" . $port . ";dbname=" . DB_DATABASE . ";";
        } else {
            // MySQL connection string (default)
            $dsn = "mysql:host=" . DB_HOST . ";port=" . $port . ";dbname=" . DB_DATABASE . ";charset=utf8mb4";
        }
        
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        
        $dbh = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $dbh;
        
    } catch (PDOException $e) {
        error_log("Database connection error: " . $e->getMessage());
        // We should set a global variable here so we know the DB is down.
        $_SESSION['DB_DOWN'] = true;
        echo "Database connection error. Please try again later.";
        exit;
    }
}
?>