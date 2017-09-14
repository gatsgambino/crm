<?php

define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBNAME', 'hrcrm');
try {
    $db = new PDO('mysql:host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Unable to connect to server.';
}

date_default_timezone_set('Europe/London');

// Report all errors except E_NOTICE
error_reporting(E_ALL & ~E_NOTICE);