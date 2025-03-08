<?php
$certificateTable = 'certificate';

// Check if the table already exists
$result = $conn->query("SHOW TABLES LIKE '$certificateTable'");

if (!$result->num_rows > 0) {
    $commonColumns = [
        'id INT(11) AUTO_INCREMENT PRIMARY KEY',
        'student_id INT(11) NOT NULL',
        'course_id INT(11) NOT NULL',
        'registration_number VARCHAR(256) NOT NULL',
        'start_date DATE NOT NULL',
        'completion_date DATE NOT NULL',
        'qr_code LONGTEXT DEFAULT NULL',
        'FOREIGN KEY (student_id) REFERENCES ' . $studentTable . '(id) ON DELETE RESTRICT ON UPDATE CASCADE',
        'FOREIGN KEY (course_id) REFERENCES ' . $courseTable . '(id) ON DELETE RESTRICT ON UPDATE CASCADE',
    ];
    $extraColumns = ["status CHAR(1) DEFAULT '1'", 'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'];
    // Merge common columns with extra columns
    $columns = array_merge($commonColumns, $extraColumns);
    // Construct the SQL query
    $sql = "CREATE TABLE IF NOT EXISTS $certificateTable (" . implode(', ', $columns) . ")";
    $TableCreated = runCreateTable($conn, $certificateTable, $sql);
}

function insertCertificate($studentId, $courseId, $registrationNumber, $startDate, $completionDate, $qr_code)
{
    global $conn, $certificateTable;

    $DucplicateCheckColumn = ['student_id' => $studentId, 'AND', 'course_id' => $courseId, 'AND', 'registration_number' => $registrationNumber];
    $DuplicateRecord = CheckDuplicateRecordBeforeInsert($conn, $certificateTable, $DucplicateCheckColumn);

    if ($DuplicateRecord == FALSE) {
        $stmt = $conn->prepare("INSERT INTO $certificateTable (student_id, course_id, registration_number,start_date, completion_date, qr_code) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissss", $studentId, $courseId, $registrationNumber, $startDate, $completionDate, $qr_code);
        return insertDatastmtQuery($conn, $certificateTable, $stmt);
    } else {
        return ["data" => 'DUPLICATE', "id" => $DuplicateRecord];
    }
}

function getAllCertificates()
{
    global $conn, $certificateTable, $studentTable, $courseTable;
    $sql = "SELECT s.full_name,c.course_name, ct.* FROM $certificateTable ct
            LEFT JOIN $studentTable s ON ct.student_id = s.id
            LEFT JOIN $courseTable c ON ct.course_id = c.id ORDER BY ct.id DESC";
    return isArrayData($conn, $sql);
}

function getCertificateById($id)
{
    global $conn, $certificateTable, $studentTable, $courseTable;
    $sql = "SELECT s.full_name,c.course_name, ct.* FROM $certificateTable ct
            LEFT JOIN $studentTable s ON ct.student_id = s.id
            LEFT JOIN $courseTable c ON ct.course_id = c.id
            WHERE ct.id = $id";
    return isSingleRowData($conn, $sql);
}


function getCertificateByCustomColumns($customColumns, $array)
{
    global $conn, $certificateTable;
    return getTableDataByCustomColumnsQuery($conn, $certificateTable, $customColumns, $array);
}

function updateCertificateById($id, $updatedColumns)
{
    global $conn, $certificateTable;

    // To find duplicate record
    $studentId = $updatedColumns['student_id'];
    $courseId = $updatedColumns['course_id'];
    $registrationNumber = $updatedColumns['registration_number'];
    $DucplicateCheckColumn = ['student_id' => $studentId, 'AND', 'course_id' => $courseId, 'AND', 'registration_number' => $registrationNumber];
    $DuplicateRecord = CheckDuplicateRecordToUpdate($conn, $id, $certificateTable, $DucplicateCheckColumn);

    if ($DuplicateRecord == FALSE) {
        return updateTableDataByIdQuery($conn, $certificateTable, $id, $updatedColumns);
    } else {
        $duplicate_data = ["data" => 'DUPLICATE', "id" => $DuplicateRecord];
        return $duplicate_data;
    }
}

function deleteCertificateById($id)
{
    global $conn, $certificateTable;

    // get certificate details
    $certificateDetails = getCertificateById($id);
    $name = $certificateDetails['full_name'];
    $regNo = $certificateDetails['registration_number'];

    // delete certificate from database
    $deleted = deleteTableDataByIdQuery($conn, $certificateTable, $id);
    if ($deleted) {
        deleteCertificate($name, $regNo);
    }
    return $deleted;
}

function getCertificateDetailsByRegNo($registrationNumber)
{
    global $conn, $certificateTable, $studentTable, $courseTable;
    $sql = "SELECT s.full_name, c.course_name, cert.registration_number, cert.start_date, cert.completion_date, cert.qr_code
            FROM $certificateTable cert
            JOIN $studentTable s ON cert.student_id = s.id
            JOIN $courseTable c ON cert.course_id = c.id
            WHERE cert.registration_number = '$registrationNumber'";

    return isSingleRowData($conn, $sql);
}

function getverificationDetailsByRegNo($registrationNumber)
{
    global $conn, $certificateTable, $studentTable, $courseTable, $moduleTable, $projectTable;
    $sql = "SELECT s.full_name, c.course_name, c.duration, c.evaluation_methodology,
                    GROUP_CONCAT(m.module_name SEPARATOR ', ') AS modules_covered,
                    GROUP_CONCAT(p.project_title SEPARATOR ', ') AS projects_completed,
                    cert.*
            FROM $certificateTable cert
            JOIN $studentTable s ON cert.student_id = s.id
            JOIN $courseTable c ON cert.course_id = c.id
            LEFT JOIN $moduleTable m ON c.id = m.course_id
            LEFT JOIN $projectTable p ON s.id = p.student_id AND c.id = p.course_id
            WHERE cert.registration_number = '$registrationNumber'";

    return isSingleRowData($conn, $sql);
}