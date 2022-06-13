<?php
/**
 * Test runner bootstrap.
 *
 * Add additional configuration/setup your application needs when running
 * unit tests in this file.
 */
require dirname(__DIR__) . '/config/bootstrap.php';

$server = "10.1.1.204\TST";
$user = "sa";
$pass = "Barradorio2015";
$database = "Sara_db";
define('SQLSERVER_DSN', "dblib:host=" . $server . "; dbname=" . $database . ";");
//define('SQLSERVER_DSN', "odbc:Driver={SQL Server};Database=" . $database . "; Server=" . $server);
define('SQLSERVER_USER', $user);
define('SQLSERVER_PASS', $pass);

