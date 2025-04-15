<?php
require_once '../../../config/dbconfig.php';
include_once($Base_Path . "/public/code/Queries.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['type']) && $_POST['type'] == 'bulkDownlaod') {
    try {
        $customColumns = ['status' => '1'];
        $allActiveCertificates = getCertificateByCustomColumns($customColumns, true);


        $total = count($allActiveCertificates);
        $current = 0;

        $ProgressStatus = [];
        $ProgressStatus['totalRecords'] = $total;
        $currentStatus = [];

        foreach ($allActiveCertificates as $certificate) {
            $certificateId = $certificate['id'];
            $get_single_certificate = getCertificateById($certificateId);

            $name = $get_single_certificate['full_name'];
            $regNo = $get_single_certificate['registration_number'];
            $startDate = $get_single_certificate['start_date'];
            $endDate = $get_single_certificate['completion_date'];
            $course = $get_single_certificate['course_name'];
            $qrCode = $get_single_certificate['qr_code'];
            $otherData = [
                'evaluation_methodology' => $get_single_certificate['evaluation_methodology'],
                'modules_covered' => $get_single_certificate['modules_covered']
            ];
            $generateCertificate = generateCertificate($regNo, $name, $startDate, $endDate, $course, $qrCode, $otherData, "tempCert/");
            $certificatePath = $generateCertificate['path'];
            $certificateURL = $generateCertificate['url'];

            // for percentage calcuation
            $current++;
            $progress = intval(($current / $total) * 100);
            setProgress($progress); // Update progress in session
            $currentStatus[$current] = $progress;
        }
        $ProgressStatus['currentStatus'] = $currentStatus;
        $ProgressStatus['successPercent'] = getProgress();

        $directory = dirname($certificatePath);
        $directoryURL = dirname($certificateURL);

        // Create a zip file
        $zipFile = $directory . "/bulkCert.zip";
        $zipFileURL = $directoryURL . "/bulkCert.zip";
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

        $returnData = ["status" => "success", "message" => "Certificates generated successfully", "zipFile" => $zipFile, "zipFileURL" => $zipFileURL, "zipFolder" => $directory, "progress" => $ProgressStatus];
    } catch (Exception $e) {
        $returnData = ["status" => "failed", "message" => $e->getMessage()];
        CatchErrorLogs($e, null);
    } finally {
        echo json_encode($returnData);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['type']) && $_POST['type'] == 'deleteZipFolder') {
    try {
        $zipFolder = $_POST['value'];

        if (is_dir($zipFolder)) {
            // Delete all files and subdirectories
            $files = array_diff(scandir($zipFolder), ['.', '..']);
            foreach ($files as $file) {
                $filePath = $zipFolder . DIRECTORY_SEPARATOR . $file;
                if (is_dir($filePath)) {
                    deleteFolderRecursively($filePath); // Recursively delete subfolders
                } else {
                    unlink($filePath); // Delete file
                }
            }
            // Try to delete the folder after it's empty
            if (rmdir($zipFolder)) {
                $returnData = ["status" => "success", "message" => "Zip folder deleted successfully"];
            } else {
                $returnData = ["status" => "failed", "message" => "Zip folder not deleted"];
            }
        } else {
            $returnData = ["status" => "failed", "message" => "Zip folder not found"];
        }
    } catch (Exception $e) {
        $returnData = ["status" => "failed", "message" => $e->getMessage()];
        CatchErrorLogs($e, null);
    } finally {
        echo json_encode($returnData);
    }
}

// Helper function to delete a folder recursively
function deleteFolderRecursively($folderPath)
{
    $files = array_diff(scandir($folderPath), ['.', '..']);
    foreach ($files as $file) {
        $filePath = $folderPath . DIRECTORY_SEPARATOR . $file;
        if (is_dir($filePath)) {
            deleteFolderRecursively($filePath); // Recursively delete subfolders
        } else {
            unlink($filePath); // Delete file
        }
    }
    rmdir($folderPath); // Delete the empty folder
}


function setProgress($percent)
{
    $_SESSION['bulk_progress'] = $percent;
}

function getProgress()
{
    return isset($_SESSION['bulk_progress']) ? $_SESSION['bulk_progress'] : 0;
}
function clearProgress()
{
    unset($_SESSION['bulk_progress']);
}
