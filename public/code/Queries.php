<?php

// Don't Change the Name of the file
$codePathFolder = $Base_Path . "/public/code";

// Include Enum class
include_once $codePathFolder . "/Enums.php";

// Include Core Queries
include_once $codePathFolder . "/CoreQueries.php";

/**
 *    <------Tables------->
 * 
 * Don't Change the order of including tables
 */

// Include Student Table
include_once $codePathFolder . "/admin.php";
include_once $codePathFolder . "/student.php";


function CatchErrorLogs($e, $Redirect_URL)
{
    global $Base_Path;
    $error_log = "Error: " . $e->getMessage() . " - " . date('d-M-Y h:i:s A') . "\r";
    error_log($error_log, 3, $Base_Path . "/logs/data.log");
    header("Location: $Redirect_URL");
    exit;
}