<?php

// Don't Change the Name of the file
$codePathFolder = $Base_Path . "/public/code";

// Don't Change the Name of the file
$libPathFolder = $Base_Path . "/public/libraries";

// Don't Change the Name of the file
$imgPathFolder = $Base_Path . "/public/images";

// Include Enum class
include_once $codePathFolder . "/Enums.php";

// Include Core Queries
include_once $codePathFolder . "/CoreQueries.php";

// included External Libraries
require $libPathFolder . "/vendor/autoload.php";


/**
 *    <------Libraries------->
 *  QrCode Library
 */

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

function generateQRCodeBase64($text)
{
    $qr_Code = new QrCode(trim($text)); // Create QR Code instance
    $writer = new PngWriter(); // Initialize PNG Writer

    // Write QR Code
    $result = $writer->write($qr_Code);

    // Convert image content to Base64
    $base64 = base64_encode($result->getString());

    return 'data:image/png;base64,' . $base64;
}


/**
 * End of QrCode Library
 */

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Typography\FontFactory;
function generateCertificate($name, $startDate, $endDate, $course)
{

    global $imgPathFolder, $Base_URL, $Base_Path;

    $tempImgPath = $imgPathFolder . "/certificateTem/certificatetemp.jpg";
    $GreatVibesfont = $Base_Path . "/fonts/Greatvibes/GreatVibes-Regular.ttf";
    $Arialfont = $Base_Path . "/fonts/Arialfont/Arial.ttf";

    // create image manager with desired driver
    $manager = new ImageManager(new Driver());

    // read image from file system
    $image = $manager->read($tempImgPath);

    // Set Text
    $image->text($name, 540, 340, function (FontFactory $font) use ($GreatVibesfont) {
        $font->file($GreatVibesfont); // Add your font path
        $font->size(80);
        $font->color('#000000');
        $font->align('center');
    });

    $image->text("from $startDate to $endDate", 540, 420, function (FontFactory $font) use ($Arialfont) {
        $font->file($Arialfont);
        $font->size(30);
        $font->color('#000000');
        $font->align('center');
    });

    $image->text("as a $course.", 540, 470, function (FontFactory $font) use ($Arialfont) {
        $font->file($Arialfont);
        $font->size(30);
        $font->color('#000000');
        $font->align('center');
    });

    // Save the generated certificate
    $fileName = strtolower(str_replace(' ', '_', $name)) . '_certificate.png';
    $image->save($fileName);

    return "Certificate generated: $fileName";
}


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
    error_log($error_log, 3, $Base_Path . "/logs/data.log");
    header("Location: $Redirect_URL");
    exit;
}