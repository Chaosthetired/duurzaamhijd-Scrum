<?php

declare(strict_types=1);

// Path to project root (db.inc.php is in /include, so go one up)
$ROOT = dirname(__DIR__);

// NEVER rely on CWD; always use absolute paths
require_once $ROOT . '/classes/database_abstractie_class.php';   // <- no trailing space!
require_once $ROOT . '/classes/company_class.php';    

function connect()
{
    // mySQL
    // $host = 'localhost';
    // $dbname = '';
    // $user = 'root@localhost';
    // $pass = '';

    // postgresSQL:
     $host = 'localhost';
     $dbname = 'company_co2_DB';
     $user = 'postgres';
     $pass = 'SQL_joan_arc_postgres';
    $port = '5432';
    $pdo = new PdoDatabase($host, $user, $pass, $dbname);
    $pdo->__construct($host, $user, $pass, $dbname);
    return $pdo;
}
