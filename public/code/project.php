<?php
$projectTable = 'project';

// Check if the table already exists
$result = $conn->query("SHOW TABLES LIKE '$projectTable'");

if (!$result->num_rows > 0) {
    $commonColumns = [
        'id INT(11) AUTO_INCREMENT PRIMARY KEY',
        'student_id INT(11) NOT NULL',
        'course_id INT(11) NOT NULL',
        'project_title VARCHAR(256) NOT NULL',
        'description TEXT DEFAULT NULL',
        'FOREIGN KEY (student_id) REFERENCES ' . $studentTable . '(id) ON DELETE CASCADE ON UPDATE CASCADE',
        'FOREIGN KEY (course_id) REFERENCES ' . $courseTable . '(id) ON DELETE CASCADE ON UPDATE CASCADE',
    ];
    $extraColumns = ['created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'];
    // Merge common columns with extra columns
    $columns = array_merge($commonColumns, $extraColumns);
    // Construct the SQL query
    $sql = "CREATE TABLE IF NOT EXISTS $projectTable (" . implode(', ', $columns) . ")";
    $TableCreated = runCreateTable($conn, $projectTable, $sql);
}

function insertProject($studentId, $courseId, $projectTitle, $description)
{
    global $conn, $projectTable;

    $DucplicateCheckColumn = ['student_id' => $studentId, 'AND', 'course_id' => $courseId];
    $DuplicateRecord = CheckDuplicateRecordBeforeInsert($conn, $projectTable, $DucplicateCheckColumn);

    if ($DuplicateRecord == FALSE) {
        $stmt = $conn->prepare("INSERT INTO $projectTable (student_id, course_id, project_title, description ) VALUES (?, ?, ?,?)");
        $stmt->bind_param("iiss", $studentId, $courseId, $projectTitle, $description);
        return insertDatastmtQuery($conn, $projectTable, $stmt);
    } else {
        return ["data" => 'DUPLICATE', "id" => $DuplicateRecord];
    }
}

function getAllProjects()
{
    global $conn, $projectTable, $studentTable, $courseTable;
    $sql = "SELECT s.full_name,c.course_name,p.* FROM $projectTable p
    LEFT JOIN $studentTable s ON p.student_id = s.id
    LEFT JOIN $courseTable c ON p.course_id = c.id";
    return isArrayData($conn, $sql);
}

function getProjectById($id)
{
    global $conn, $projectTable;
    return getDataById($conn, $projectTable, $id);
}


function getProjectByCustomColumns($customColumns, $array)
{
    global $conn, $projectTable;
    return getTableDataByCustomColumnsQuery($conn, $projectTable, $customColumns, $array);
}

function updateProjectById($id, $updatedColumns)
{
    global $conn, $projectTable;

    // To find duplicate record
    $studentId = $updatedColumns['student_id'];
    $courseId = $updatedColumns['course_id'];
    $DucplicateCheckColumn = ['student_id' => $studentId, 'AND', 'course_id' => $courseId];
    $DuplicateRecord = CheckDuplicateRecordToUpdate($conn, $id, $projectTable, $DucplicateCheckColumn);

    if ($DuplicateRecord == FALSE) {
        return updateTableDataByIdQuery($conn, $projectTable, $id, $updatedColumns);
    } else {
        $duplicate_data = ["data" => 'DUPLICATE', "id" => $DuplicateRecord];
        return $duplicate_data;
    }
}

function deleteProjectById($id)
{
    global $conn, $projectTable;
    return deleteTableDataByIdQuery($conn, $projectTable, $id);
}