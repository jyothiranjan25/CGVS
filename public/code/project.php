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
    $TableCreated = runQuery($conn, $projectTable, $sql);
}

function insertProject($studentId, $courseId, $projectTitle, $description)
{
    global $conn, $projectTable;

    $stmt = $conn->prepare("INSERT INTO $projectTable (student_id, course_id, project_title, description ) VALUES (?, ?, ?,?)");
    $stmt->bind_param("iiss", $studentId, $courseId, $projectTitle, $description);
    return insertDatastmtQuery($conn, $projectTable, $stmt);
}

function getAllProjects()
{
    global $conn, $projectTable, $studentTable, $courseTable;
    $sql = "SELECT s.full_name,c.course_name,p.* FROM $projectTable p
    LEFT JOIN $studentTable s ON p.student_id = s.id
    LEFT JOIN $courseTable c ON p.course_id = c.id ORDER BY p.id DESC";
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
    return updateTableDataByIdQuery($conn, $projectTable, $id, $updatedColumns);
}

function deleteProjectById($id)
{
    global $conn, $projectTable;
    return deleteTableDataByIdQuery($conn, $projectTable, $id);
}

function getTotalProjects()
{
    global $conn, $projectTable;
    $count = getCount($conn, $projectTable);
    return $count;
}