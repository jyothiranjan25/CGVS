<?php
$courseTable = 'course';

// Check if the table already exists
$result = $conn->query("SHOW TABLES LIKE '$courseTable'");

if (!$result->num_rows > 0) {
    $commonColumns = [
        'id INT(11) AUTO_INCREMENT PRIMARY KEY',
        'course_name VARCHAR(256) NOT NULL',
        'duration VARCHAR(64) NOT NULL',
        'description VARCHAR(256) DEFAULT NULL',
        'evaluation_methodology TEXT DEFAULT NULL',
    ];
    $extraColumns = ['created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'];
    // Merge common columns with extra columns
    $columns = array_merge($commonColumns, $extraColumns);
    // Construct the SQL query
    $sql = "CREATE TABLE IF NOT EXISTS $courseTable (" . implode(', ', $columns) . ")";
    $TableCreated = runCreateTable($conn, $courseTable, $sql);
}

function insertCourse($name, $duration, $description, $methodology)
{
    global $conn, $courseTable;

    $DucplicateCheckColumn = ['course_name' => $name, 'AND', 'duration' => $duration];
    $DuplicateRecord = CheckDuplicateRecordBeforeInsert($conn, $courseTable, $DucplicateCheckColumn);


    if ($DuplicateRecord == FALSE) {
        $stmt = $conn->prepare("INSERT INTO $courseTable (course_name, duration, description, evaluation_methodology) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $duration, $description, $methodology);
        return insertDatastmtQuery($conn, $courseTable, $stmt);
    } else {
        return ["data" => 'DUPLICATE', "id" => $DuplicateRecord];
    }
}

function getAllCourses()
{
    global $conn, $courseTable;
    return getAllData($conn, $courseTable);
}

function getCourseById($id)
{
    global $conn, $courseTable;
    return getDataById($conn, $courseTable, $id);
}


function getCourseByCustomColumns($customColumns, $array)
{
    global $conn, $courseTable;
    return getTableDataByCustomColumnsQuery($conn, $courseTable, $customColumns, $array);
}

function updateCourseById($id, $updatedColumns)
{
    global $conn, $courseTable;

    // To find duplicate record
    $name = $updatedColumns['course_name'];
    $duration = $updatedColumns['duration'];
    $DucplicateCheckColumn = ['course_name' => $name, 'AND', 'duration' => $duration];
    $DuplicateRecord = CheckDuplicateRecordToUpdate($conn, $id, $courseTable, $DucplicateCheckColumn);

    if ($DuplicateRecord == FALSE) {
        return updateTableDataByIdQuery($conn, $courseTable, $id, $updatedColumns);
    } else {
        $duplicate_data = ["data" => 'DUPLICATE', "id" => $DuplicateRecord];
        return $duplicate_data;
    }
}

function deleteCourseById($id)
{
    global $conn, $courseTable;
    return deleteTableDataByIdQuery($conn, $courseTable, $id);
}