<?php

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Typography\FontFactory;

function generateCertificate($regNo, $name, $startDate, $endDate, $course, $QrCode, $otherData = [], $path = null)
{
    global $imgPathFolder, $Base_Path;

    $tempImgPath = $imgPathFolder . "/certificateTem/certificatetemp.png";
    $tempImgPath = $imgPathFolder . "/certificateTem/sampletemp.png";
    $GreatVibesfont = $Base_Path . "/public/fonts/Greatvibes/GreatVibes-Regular.ttf";
    $Arialfont = $Base_Path . "/public/fonts/Arialfont/Arial.ttf";
    $ArialBoldfont = $Base_Path . "/public/fonts/Arialfont/ARIBL0.ttf";

    // create image manager with desired driver
    $manager = new ImageManager(new Driver());

    // read image from file system
    $image = $manager->read($tempImgPath);


    // create qr code image based on the qr code string
    $qrCodeImage = generateQRCodeImage($QrCode);

    /**
     * $font->align('left');
     * Define the horizontal alignment of the text to be written starting from the base point. Possible values are left, right and center. Default: left
     * 
     * $font->valign('bottom');
     * Define the vertical alignment of the text to be written starting from the base point. Possible values are top, bottom and middle. Default: bottom
     */


    // Set Name Text
    $image->text($name, 1750, 1160, function (FontFactory $font) use ($GreatVibesfont) {
        $font->file($GreatVibesfont); // Add your font path
        $font->size(250);
        $font->color('#000000');
        $font->align('center');
        $font->valign('middle');
    });

    // formate dates
    $startDate = date("Y-m-d", strtotime($startDate));
    $endDate = date("Y-m-d", strtotime($endDate));

    // formate date as 2024 april 12 (jS F, Y )
    $startDate = date("F, Y", strtotime($startDate));
    $endDate = date("F, Y", strtotime($endDate));

    $evaluation_methodology = $otherData["evaluation_methodology"] ?? "";

    $line1 = "has successfully completed the $course from $startDate to $endDate, demonstrating proficiency in $evaluation_methodology";

    // Set Context
    $image->text($line1, 1750, 1700, function (FontFactory $font) use ($Arialfont) {
        $font->file($Arialfont);
        $font->size(50);
        $font->color('#000000');
        $font->align(value: 'center');
        // $font->valign('middle');
        $font->angle(0);
        $font->lineHeight(2);
        $font->wrap(2700);
    });


    // set Registration Number
    $image->text($regNo, 1750, 1850, function (FontFactory $font) use ($ArialBoldfont) {
        $font->file($ArialBoldfont); // Add your font path
        $font->size(value: 50);
        $font->color('#000000');
        $font->align('center');
        $font->valign('middle');
    });

    /**
     * Positions
     * top-left (default), top, top-right, left, center, right, bottom-left, bottom, bottom-right
     */
    // Set Qr Code Image
    $image->place(
        $qrCodeImage,
        'bottom',
        0,
        250,
        100
    );

    $savePath = getCertificatePath($name, $regNo, $path);
    $image->save($savePath['path']);

    // remove the qr code image
    unlink($qrCodeImage);


    return $savePath;

    // Test the certificate
    $certificateUrl = $savePath['url'];
    echo "<img src='$certificateUrl' alt='Certificate' width='100%' />";
    exit;
}

function getCertificatePath($name, $regNo, $path = null)
{
    global $imgPathFolder, $imgUrlPathFolder;

    // folder name
    $folderName = "/certificates/";

    if ($path != null) {
        $folderName = "/certificates/" . $path;
    }

    // Save the generated certificate
    $fileName = strtolower(str_replace(' ', '_', $name)) . "_" . $regNo . '_certificate.png';

    // base folder path
    $savePath = $imgPathFolder . $folderName;

    // create directory if not exists
    if (!file_exists($savePath)) {
        mkdir($savePath, 0777, true);
    }

    $savePath .= $fileName;

    // base url path
    $saveUrlPath = $imgUrlPathFolder . $folderName . $fileName;

    $date = [
        "path" => $savePath,
        "url" => $saveUrlPath
    ];

    return $date;
}

function deleteCertificate($name, $regNo, $path = null)
{
    $savePath = getCertificatePath($name, $regNo, $path);

    if (file_exists($savePath['path'])) {
        unlink($savePath['path']);
    }
    return true;
}

    // // Set Modules Covered
    // $modules_covered = $otherData["modules_covered"] ?? [];
    // $module_names = [];
    // foreach ($modules_covered as $module) {
    //     if (isset($module["module_name"])) {
    //         $module_names[] = strtolower($module["module_name"]);
    //     }
    // }

    // // Format the list with commas and "and" before the last item
    // $final_modules_list = implode(', ', array_slice($module_names, 0, -1));
    // if (count($module_names) > 1) {
    //     $final_modules_list .= ', and ' . end($module_names);
    // } else {
    //     $final_modules_list = implode('', $module_names);
    // }
