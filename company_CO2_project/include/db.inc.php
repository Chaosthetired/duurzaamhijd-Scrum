<?php

$str_path = "";
if (stristr($_SERVER['SCRIPT_NAME'], "include")) {
    $str_path = "../";
}
require_once($str_path . 'classes/database_abstractie_class.php');
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
