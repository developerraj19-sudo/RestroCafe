<?php
/**
 * Created by PhpStorm.
 * User: your name
 * Date: todays date
 * Time: todays time
 */

//=========== database connection variables ====================
define('DB_SERVER', getenv('DB_SERVER') ?: "localhost"); // e.g. aws-0-eu-central-1.pooler.supabase.com
define('DB_USER', getenv('DB_USER') ?: "postgres"); // e.g. postgres.yourprojectid
define('DB_DATABASE', getenv('DB_DATABASE') ?: 'postgres'); // usually 'postgres' for supabase
define('DB_PASSWORD', getenv('DB_PASSWORD') ?: ""); // your supabase password
define('DB_TYPE', getenv('DB_TYPE') ?: 'pgsql'); // pgsql for supabase

define('ENVIRONMENT', getenv('ENVIRONMENT') ?: 'development'); // Set to 'development' during development

if (ENVIRONMENT === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', __DIR__ . '/error.log');
}

// 	$HostName = "localhost";
// 	$DatabaseName = "sunsoft_easypro";
// 	$HostUser = "root";
// 	$HostPass = "";

// 	$con = new mysqli($HostName, $HostUser, $HostPass, $DatabaseName);
	
// if ($con->connect_error) {
// 	die("Database Connection Failed: ".$con-connect_error);
// 	}
?>
