<?php
session_start();
date_default_timezone_set('Asia/Kolkata');
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_WARNING);
error_reporting(0);

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

// define the database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cgv";

try {

  $connection = new mysqli($servername, $username, $password);

  if ($connection->connect_error) {
    // If connection fails, log the error and optionally redirect to an error page
    error_log("Failed to connect to MySQL: " . $connection->connect_error);
    exit;
  } else {
    // Check if the database exists
    $check_db_query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dbname'";
    $check_db_query_result = $connection->query($check_db_query);

    if ($check_db_query_result->num_rows === 0) {
      // Database doesn't exist, create it
      $createDbQuery = "CREATE DATABASE $dbname";
      if ($connection->query($createDbQuery) === FALSE) {
        // Failed to create database, log the error
        error_log("Error creating database: " . $connection->error);
        exit;
      }
    }
  }

  // Connect to the created or existing database
  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    // If connection fails, log the error and optionally redirect to an error page
    error_log("Failed to connect to MySQL: " . $conn->connect_error);
    exit;
  }
} catch (mysqli_sql_exception $e) {
  // If connection fails, redirect to error page
  error_log("Failed to connect to database: " . mysqli_connect_error(), 0);
  exit;
}

// Domain URL's
$config['base_url'] = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
$config['base_url'] .= "://" . $_SERVER['HTTP_HOST'];
$Domain_URL = $config['base_url'];

// Project URL's
$config['base_url'] .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
$Base_Path_URL = $config['base_url'];

/**
 * Start of Base URL's
 * comment this lines if not using subfolder in production
 * Extract Folder Name from URL
 */
$urlParts = parse_url($Base_Path_URL);
// $Domain_URL = $urlParts['scheme'] . '://' . $urlParts['host'] . '/' . explode('/', trim($urlParts['path'], '/'), 3)[0];
/**
 * END of Base URL's
 * comment this lines if not using subfolder in production
 * Extract Folder Name from URL
 */

// Base Path
$Base_Path = dirname(__DIR__);
// Base URL
$Base_URL = $Domain_URL;

// Extract URL
$Extract_URL = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; // Full URL path
// Extract query params from URL
$Extract_Query_params = $_SERVER['QUERY_STRING']; // Extract query params
// Extract filename from URL
$Extract_File_name = basename(parse_url($Extract_URL, PHP_URL_PATH));
// Extract filename with params from URL
$Extract_File_name_with_params = $Extract_File_name . !empty($Extract_Query_params) ? '?' . $Extract_Query_params : '';
