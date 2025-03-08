<?php

// Don't Change the Name of the file
$codePathFolder = $Base_Path . "/public/code";

// Don't Change the Name of the file
$libPathFolder = $Base_Path . "/public/libraries";

// Don't Change the Name of the file
$imgPathFolder = $Base_Path . "/public/images";
$imgUrlPathFolder = $Base_URL . "/public/images";

// Include Enum class
include_once $codePathFolder . "/Enums.php";

// Include Core Queries
include_once $codePathFolder . "/CoreQueries.php";

// included External Libraries
require $libPathFolder . "/vendor/autoload.php";

// Include QR Code Generator
include_once $codePathFolder . "/QRCodeGenerator.php";

// Include Certificate Generation
include_once $codePathFolder . "/certificateGeneration.php";

/**
 *    <------Tables------->
 * 
 * Don't Change the order of including tables
 */

// Include Student Table
include_once $codePathFolder . "/admin.php";
include_once $codePathFolder . "/student.php";
include_once $codePathFolder . "/course.php";
include_once $codePathFolder . "/module.php";
include_once $codePathFolder . "/project.php";
include_once $codePathFolder . "/certificate.php";
include_once $codePathFolder . "/certificateVerification.php";

function CatchErrorLogs($e, $Redirect_URL)
{

    global $Base_Path;
    $error_log = "Error: " . $e->getMessage() . " - " . date('d-M-Y h:i:s A') . "\r";
    $fileName = date('d_M_Y') . "_error_log.log";
    $filePath = $Base_Path . "/logs/" . $fileName;
    if (!file_exists($Base_Path . "/logs")) {
        mkdir($Base_Path . "/logs", 0777, true);
    }
    error_log($error_log, 3, $filePath);
    if ($Redirect_URL) {
        header("Location: $Redirect_URL");
        exit;
    }
}