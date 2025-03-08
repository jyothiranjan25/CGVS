<?php
$certificateVerificationTable = 'certificate_verification';

// Check if the table already exists
$result = $conn->query("SHOW TABLES LIKE '$certificateVerificationTable'");

if (!$result->num_rows > 0) {
    $commonColumns = [
        'id INT(11) AUTO_INCREMENT PRIMARY KEY',
        'certificate_id INT(11) NOT NULL',
        'ip_address VARCHAR(64) NOT NULL',
        'FOREIGN KEY (certificate_id) REFERENCES ' . $certificateTable . '(id) ON DELETE CASCADE ON UPDATE CASCADE',
    ];
    $extraColumns = ['created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'];
    // Merge common columns with extra columns
    $columns = array_merge($commonColumns, $extraColumns);
    // Construct the SQL query
    $sql = "CREATE TABLE IF NOT EXISTS $certificateVerificationTable (" . implode(', ', $columns) . ")";
    $TableCreated = runCreateTable($conn, $certificateVerificationTable, $sql);
}

function insertCertificateVerification($certificateId, $ipAddress)
{
    try {
        global $conn, $certificateVerificationTable;
        $stmt = $conn->prepare("INSERT INTO $certificateVerificationTable (certificate_id, ip_address) VALUES (?, ?)");
        $stmt->bind_param("is", $certificateId, $ipAddress);
        return insertDatastmtQuery($conn, $certificateVerificationTable, $stmt);
    } finally {
        unset($_SESSION['toasts_title']);
        unset($_SESSION['toasts_message']);
        unset($_SESSION['toasts_type']);
        unset($_SESSION['inserted_id']);
    }
}

function getAllCertificateVerifications()
{
    global $conn, $certificateVerificationTable, $certificateTable;
    $sql = "SELECT cv.*, c.registration_number FROM $certificateVerificationTable cv JOIN $certificateTable c ON cv.certificate_id = c.id ORDER BY cv.id DESC";
    return isArrayData($conn, $sql);
}

function getCertificateVerificationByCustomColumns($customColumns, $array)
{
    global $conn, $certificateVerificationTable;
    return getTableDataByCustomColumnsQuery($conn, $certificateVerificationTable, $customColumns, $array);
}