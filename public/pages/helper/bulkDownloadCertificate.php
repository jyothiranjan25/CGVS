<?php
require_once '../../../config/dbconfig.php';
include_once($Base_Path . "/public/code/Queries.php");

$status = 'failed';

try {
    $customColumns = ['status' => '1'];
    $allActiveCertificates = getCertificateByCustomColumns($customColumns, true);

    foreach ($allActiveCertificates as $certificate) {
        $certificateId = $certificate['id'];
        echo $certificateId;
        exit;
    }





    $status = 'success';

} catch (Exception $e) {
    $status = 'error';
    CatchErrorLogs($e, null);
}
// finally {
//     echo json_encode(['status' => $status]);
// }
