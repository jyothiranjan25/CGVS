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

    $tempImgPath = $imgPathFolder . "/certificateTem/sampletemp.png";
    $GreatVibesfont = $Base_Path . "/public/fonts/Greatvibes/GreatVibes-Regular.ttf";
    $Arialfont = $Base_Path . "/public/fonts/Arialfont/Arial.ttf";

    // create image manager with desired driver
    $manager = new ImageManager(new Driver());

    // read image from file system
    $image = $manager->read($tempImgPath);

    // Set Text
    $image->text($name, 1830, 1180, function (FontFactory $font) use ($GreatVibesfont) {
        $font->file($GreatVibesfont); // Add your font path
        $font->size(250);
        $font->color('#000000');
        $font->align('center');
        $font->valign('middle');
    });

    // formate dates
    $startDate = date("Y-m-d", strtotime($startDate));
    $endDate = date("Y-m-d", strtotime($endDate));

    // formate date as 2024 april 12
    $startDate = date("jS F, Y", strtotime($startDate));
    $endDate = date("jS F, Y", strtotime($endDate));



    $line1 = "has completed an internship at EDFLIX™ from $startDate to $endDate as a $course.";

    $image->text($line1, 1750, 1450, function (FontFactory $font) use ($Arialfont) {
        $font->file($Arialfont);
        $font->size(50);
        $font->color('#000000');
        $font->align('center');
        $font->valign('middle');
    });

    $line2 = "During the internship, he was punctual and has displayed professionalism, hardworking and inquisitive.";

    $image->text($line2, 1700, 1580, function (FontFactory $font) use ($Arialfont) {
        $font->file($Arialfont);
        $font->size(50);
        $font->color('#000000');
        $font->align('center');
        $font->valign('middle');
    });

    $line3 = "During his time with us, he worked under the guidance and leadership team who have expressed their gratitude for his contributions to the team";
    $image->text($line3, 1750, 1750, function (FontFactory $font) use ($Arialfont) {
        $font->file($Arialfont);
        $font->size(50);
        $font->color('#000000');
        $font->align('center');
        $font->valign('middle');
        $font->lineHeight(2);
        $font->wrap(2700);
    });

    // Save the generated certificate
    $fileName = strtolower(str_replace(' ', '_', $name)) . '_certificate.png';
    $savePath = $imgPathFolder . "/certificates/";

    // create directory if not exists
    if (!file_exists($savePath)) {
        mkdir($savePath, 0777, true);
    }
    $savePath .= $fileName;
    $image->save($savePath);
    return $savePath;
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
    $fileName = date('d_M_Y') . "_error_log.log";
    $filePath = $Base_Path . "/logs/" . $fileName;
    if (!file_exists($Base_Path . "/logs")) {
        mkdir($Base_Path . "/logs", 0777, true);
    }
    error_log($error_log, 3, $filePath);
    header("Location: $Redirect_URL");
    exit;
}