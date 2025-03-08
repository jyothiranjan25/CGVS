<?php
require_once '../../../config/dbconfig.php';
include_once($Base_Path . "/public/code/Queries.php");

$returnData = ["status" => "failed", "message" => "Failed to generate certificates"];

try {
    $customColumns = ['status' => '1'];
    $allActiveCertificates = getCertificateByCustomColumns($customColumns, true);

    foreach ($allActiveCertificates as $certificate) {
        $certificateId = $certificate['id'];
        $get_single_certificate = getCertificateById($certificateId);

        $name = $get_single_certificate['full_name'];
        $regNo = $get_single_certificate['registration_number'];
        $startDate = $get_single_certificate['start_date'];
        $endDate = $get_single_certificate['end_date'];
        $course = $get_single_certificate['course_name'];
        $qrCode = $get_single_certificate['qr_code'];
        $generateCertificate = generateCertificate($regNo, $name, $startDate, $endDate, $course, $qrCode, "tempCert/");
        $certificatePath = $generateCertificate['path'];
    }

    $directory = dirname($certificatePath);

    // Create a zip file
    $zipFile = $directory . "/bulkCert.zip";
    $zip = new ZipArchive();

    if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
        // Scan directory for files
        $files = glob($directory . "/*");

        foreach ($files as $file) {
            if (is_file($file)) {
                $zip->addFile($file, basename($file)); // Add file with its base name
            }
        }

        $zip->close();
    } else {
        throw new Exception("Could not create zip file.");
    }

    $returnData = ["status" => "success", "message" => "Certificates generated successfully", "zipFile" => $zipFile];

} catch (Exception $e) {
    $returnData = ["status" => "failed", "message" => $e->getMessage()];
    CatchErrorLogs($e, null);
} finally {
    echo json_encode($returnData);
}
