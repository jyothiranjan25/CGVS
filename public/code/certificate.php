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
        "completion_date DATE NOT NULL",
        'qr_code TEXT DEFAULT NULL',
        'FOREIGN KEY (student_id) REFERENCES ' . $studentTable . '(id) ON DELETE CASCADE ON UPDATE CASCADE',
        'FOREIGN KEY (course_id) REFERENCES ' . $courseTable . '(id) ON DELETE CASCADE ON UPDATE CASCADE',
    ];
    $extraColumns = ['created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'];
    // Merge common columns with extra columns
    $columns = array_merge($commonColumns, $extraColumns);
    // Construct the SQL query
    $sql = "CREATE TABLE IF NOT EXISTS $certificateTable (" . implode(', ', $columns) . ")";
    $TableCreated = runCreateTable($conn, $certificateTable, $sql);
}

function insertCertificate($studentId, $courseId, $registrationNumber, $completionDate, $qr_code)
{
    global $conn, $certificateTable;

    $DucplicateCheckColumn = ['student_id' => $studentId, 'AND', 'course_id' => $courseId, 'AND', 'registration_number' => $registrationNumber];
    $DuplicateRecord = CheckDuplicateRecordBeforeInsert($conn, $certificateTable, $DucplicateCheckColumn);

    if ($DuplicateRecord == FALSE) {
        $stmt = $conn->prepare("INSERT INTO $certificateTable (student_id, course_id, registration_number, completion_date, qr_code) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisss", $studentId, $courseId, $registrationNumber, $completionDate, $qr_code);
        return insertDatastmtQuery($conn, $certificateTable, $stmt);
    } else {
        return ["data" => 'DUPLICATE', "id" => $DuplicateRecord];
    }
}

function getAllCertificates()
{
    global $conn, $certificateTable;
    return getAllData($conn, $certificateTable);
}

function getCertificateById($id)
{
    global $conn, $certificateTable;
    return getDataById($conn, $certificateTable, $id);
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
    return deleteTableDataByIdQuery($conn, $certificateTable, $id);
}