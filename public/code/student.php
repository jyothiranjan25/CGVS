<?php
$studentTable = 'student';

// Check if the table already exists
$result = $conn->query("SHOW TABLES LIKE '$studentTable'");

if (!$result->num_rows > 0) {
    $commonColumns = [
        'id INT(11) AUTO_INCREMENT PRIMARY KEY',
        'full_name VARCHAR(256) NOT NULL',
        'email VARCHAR(256) NOT NULL',
        'mobile VARCHAR(64) DEFAULT NULL',
    ];
    $extraColumns = ['created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'];
    // Merge common columns with extra columns
    $columns = array_merge($commonColumns, $extraColumns);
    // Construct the SQL query
    $sql = "CREATE TABLE IF NOT EXISTS $studentTable (" . implode(', ', $columns) . ")";
    $TableCreated = runCreateTable($conn, $studentTable, $sql);
}

function insertStudent($name, $email, $mobile)
{
    global $conn, $studentTable;

    $DucplicateCheckColumn = ['email' => $email];
    $DuplicateRecord = CheckDuplicateRecordBeforeInsert($conn, $studentTable, $DucplicateCheckColumn);


    if ($DuplicateRecord == FALSE) {
        $stmt = $conn->prepare("INSERT INTO $studentTable (full_name, email, mobile) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $mobile);
        return insertDatastmtQuery($conn, $studentTable, $stmt);
    } else {
        return ["data" => 'DUPLICATE', "id" => $DuplicateRecord];
    }
}

function getAllStudents()
{
    global $conn, $studentTable;
    return getAllData($conn, $studentTable);
}

function getStudentById($id)
{
    global $conn, $studentTable;
    return getDataById($conn, $studentTable, $id);
}


function getStudentByCustomColumns($customColumns, $array)
{
    global $conn, $studentTable;
    return getTableDataByCustomColumnsQuery($conn, $studentTable, $customColumns, $array);
}

function updateStudentById($id, $updatedColumns)
{
    global $conn, $studentTable;

    // To find duplicate record
    $email = $updatedColumns['email'];
    $DucplicateCheckColumn = ['email' => $email];
    $DuplicateRecord = CheckDuplicateRecordToUpdate($conn, $id, $studentTable, $DucplicateCheckColumn);

    if ($DuplicateRecord == FALSE) {
        return updateTableDataByIdQuery($conn, $studentTable, $id, $updatedColumns);
    } else {
        $duplicate_data = ["data" => 'DUPLICATE', "id" => $DuplicateRecord];
        return $duplicate_data;
    }
}

function deleteStudentById($id)
{
    global $conn, $studentTable;
    return deleteTableDataByIdQuery($conn, $studentTable, $id);
}