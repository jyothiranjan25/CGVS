<?php
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

    // return the base64 string
    return 'data:image/png;base64,' . $base64;
}

function generateQRCodeImage($base64String)
{
    global $imgPathFolder;

    // imageTempPath
    $imageTempPath = $imgPathFolder . "/qr_codes/";
    // if the folder doesn't exist, create it
    if (!file_exists($imageTempPath)) {
        mkdir($imageTempPath, 0777, true);
    }
    // getuniquename
    $uniqueName = uniqid() . ".png";
    // add the unique name to the imageTempPath
    $imageTempPath = $imageTempPath . $uniqueName;

    // 1. Remove the metadata (optional, if exists)
    if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $matches)) {
        $imageType = $matches[1]; // png, jpg, jpeg, etc.
        $base64String = substr($base64String, strpos($base64String, ',') + 1);
        $base64String = base64_decode($base64String);
    } else {
        die("Invalid Base64 image string.");
    }

    // 2. Save the image to the public/images/qr_codes folder
    file_put_contents($imageTempPath, $base64String);

    return $imageTempPath;
}
