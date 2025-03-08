<?php

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Typography\FontFactory;
function generateCertificate($regNo, $name, $startDate, $endDate, $course, $QrCode)
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


    // corner with 10px offset and an opacity of 25%
    $image->place(
        $qrCodeImage,
        'top-right',
        300,
        200,
        100
    );


    // Set Text
    $image->text($name, 1830, 1160, function (FontFactory $font) use ($GreatVibesfont) {
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

    // create lines
    $line1_start = "has completed an internship at EDFLIX™ from ";
    $line1_start_date = $startDate;
    $line1_to = " to ";
    $line1_end_date = $endDate;
    $line1_as = " as a ";
    $line1_course = $course . ".";

    $line1 = $line1_start . $line1_start_date . $line1_to . $line1_end_date . $line1_as . $line1_course;



    $image->text($line1, 456, 1440, function (FontFactory $font) use ($Arialfont) {
        $font->file($Arialfont);
        $font->size(50);
        $font->color('#000000');
        $font->valign('middle');
    });

    // $image->text($line1_start_date, 1510, 1440, function (FontFactory $font) use ($ArialBoldfont) {
    //     $font->file($ArialBoldfont);
    //     $font->size(50);
    //     $font->color('#000000');
    //     // $font->align('center');
    //     $font->valign('middle');
    // });

    // $image->text($line1_to, 2050, 1440, function (FontFactory $font) use ($Arialfont) {
    //     $font->file($Arialfont);
    //     $font->size(50);
    //     $font->color('#000000');
    //     // $font->align('center');
    //     $font->valign('middle');
    // });

    // $image->text($line1_end_date, 2100, 1440, function (FontFactory $font) use ($ArialBoldfont) {
    //     $font->file($ArialBoldfont);
    //     $font->size(50);
    //     $font->color('#000000');
    //     // $font->align('center');
    //     $font->valign('middle');
    // });

    // $image->text($line1_as, 2100, 1440, function (FontFactory $font) use ($Arialfont) {
    //     $font->file($Arialfont);
    //     $font->size(50);
    //     $font->color('#000000');
    //     // $font->align('center');
    //     $font->valign('middle');
    // });

    // $image->text($line1_course, 9000, 1440, function (FontFactory $font) use ($Arialfont) {
    //     $font->file($Arialfont);
    //     $font->size(50);
    //     $font->color('#000000');
    //     // $font->align('center');
    //     $font->valign('middle');
    // });

    $line2 = "During the internship, he was punctual and has displayed professionalism, hardworking and inquisitive.";

    $image->text($line2, 1700, 1560, function (FontFactory $font) use ($Arialfont) {
        $font->file($Arialfont);
        $font->size(50);
        $font->color('#000000');
        $font->align('center');
        $font->valign('middle');
    });

    $line3 = "During his time with us, he worked under the guidance and leadership team who have expressed their gratitude for his contributions to the team";
    $image->text($line3, 1750, 1720, function (FontFactory $font) use ($Arialfont) {
        $font->file($Arialfont);
        $font->size(50);
        $font->color('#000000');
        $font->align('center');
        $font->valign('middle');
        $font->lineHeight(2);
        $font->wrap(2700);
    });

    $savePath = getCertificatePath($name, $regNo);
    $image->save($savePath['path']);

    // remove the qr code image
    unlink($qrCodeImage);


    return $savePath['url'];

    // Test the certificate
    $certificateUrl = $savePath['url'];
    echo "<img src='$certificateUrl' alt='Certificate' width='100%' />";
    exit;
}

function getCertificatePath($name, $regNo)
{
    global $imgPathFolder, $imgUrlPathFolder;

    // folder name
    $folderName = "/certificates/";

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

function deleteCertificate($name, $regNo)
{
    $savePath = getCertificatePath($name, $regNo);

    if (file_exists($savePath['path'])) {
        unlink($savePath['path']);
    }

    return true;
}
