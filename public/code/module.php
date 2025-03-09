<?php
$moduleTable = 'module';

// Check if the table already exists
$result = $conn->query("SHOW TABLES LIKE '$moduleTable'");

if (!$result->num_rows > 0) {
    $commonColumns = [
        'id INT(11) AUTO_INCREMENT PRIMARY KEY',
        'course_id INT(11) NOT NULL',
        'module_name VARCHAR(255) NOT NULL',
        'FOREIGN KEY (course_id) REFERENCES ' . $courseTable . '(id) ON DELETE CASCADE ON UPDATE CASCADE',
    ];
    $extraColumns = ['created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'];
    // Merge common columns with extra columns
    $columns = array_merge($commonColumns, $extraColumns);
    // Construct the SQL query
    $sql = "CREATE TABLE IF NOT EXISTS $moduleTable (" . implode(', ', $columns) . ")";
    $TableCreated = runQuery($conn, $moduleTable, $sql);
}


function insertModule($courseId, $moduleName)
{
    global $conn, $moduleTable;

    $DuplicateCheckColumn = ['course_id' => $courseId, 'AND', 'module_name' => $moduleName];
    $DuplicateRecord = CheckDuplicateRecordBeforeInsert($conn, $moduleTable, $DuplicateCheckColumn);


    if ($DuplicateRecord == FALSE) {
        $stmt = $conn->prepare("INSERT INTO $moduleTable (course_id, module_name) VALUES (?, ?)");
        $stmt->bind_param("is", $courseId, $moduleName);
        return insertDatastmtQuery($conn, $moduleTable, $stmt);
    } else {
        return ["data" => 'DUPLICATE', "id" => $DuplicateRecord];
    }
}

function getAllModules()
{
    global $conn, $moduleTable, $courseTable;
    $sql = "SELECT c.course_name,m.* FROM $moduleTable m 
    LEFT JOIN $courseTable c ON m.course_id = c.id ORDER BY m.id DESC";
    return isArrayData($conn, $sql);
}

function getModuleById($id)
{
    global $conn, $moduleTable;
    return getDataById($conn, $moduleTable, $id);
}


function getModuleByCustomColumns($customColumns, $array)
{
    global $conn, $moduleTable;
    return getTableDataByCustomColumnsQuery($conn, $moduleTable, $customColumns, $array);
}

function updateModuleById($id, $updatedColumns)
{
    global $conn, $moduleTable;

    // To find duplicate record
    $courseID = $updatedColumns['course_id'];
    $moduleName = $updatedColumns['module_name'];
    $DuplicateCheckColumn = ['course_id' => $courseID, 'AND', 'module_name' => $moduleName];
    $DuplicateRecord = CheckDuplicateRecordToUpdate($conn, $id, $moduleTable, $DuplicateCheckColumn);

    if ($DuplicateRecord == FALSE) {
        return updateTableDataByIdQuery($conn, $moduleTable, $id, $updatedColumns);
    } else {
        $duplicate_data = ["data" => 'DUPLICATE', "id" => $DuplicateRecord];
        return $duplicate_data;
    }
}

function deleteModuleById($id)
{
    global $conn, $moduleTable;
    return deleteTableDataByIdQuery($conn, $moduleTable, $id);
}