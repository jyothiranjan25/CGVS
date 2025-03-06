<?php
$adminTable = 'admin';

// Check if the table already exists
$result = $conn->query("SHOW TABLES LIKE '$adminTable'");

if (!$result->num_rows > 0) {
    $commonColumns = [
        'id INT(11) AUTO_INCREMENT PRIMARY KEY',
        'username VARCHAR(100) NOT NULL',
        'password VARCHAR(256) NOT NULL',
        'email VARCHAR(256) NOT NULL',
        'role VARCHAR(64) DEFAULT "' . UserRolesENUM::ADMIN . '"',
    ];
    $extraColumns = ['created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'];
    // Merge common columns with extra columns
    $columns = array_merge($commonColumns, $extraColumns);
    // Construct the SQL query
    $sql = "CREATE TABLE IF NOT EXISTS $adminTable (" . implode(', ', $columns) . ")";
    $TableCreated = runCreateTable($conn, $adminTable, $sql);
    if ($TableCreated) {
        insertInitialData();
    }
}

function insertAdmin($name, $email, $password, $role)
{
    global $conn, $adminTable;

    // check for duplicate record
    $duplicateCheckColumn = ['username' => $name, 'OR', 'email' => $email];
    $duplicateRecord = CheckDuplicateRecordBeforeInsert($conn, $adminTable, $duplicateCheckColumn);

    // If no duplicate record found, insert the data
    if ($duplicateRecord === FALSE) {
        if ($role === null)
            $role = UserRolesENUM::ADMIN;

        $password = md5($password);

        $stmt = $conn->prepare("INSERT INTO $adminTable (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $password, $role);
        return insertDatastmtQuery($conn, $adminTable, $stmt);
    } else {
        return ["data" => 'DUPLICATE', "id" => $duplicateRecord];
    }
}

function getAllAdmins()
{
    global $conn, $adminTable;
    return getAllData($conn, $adminTable);
}

function getAdminById($id)
{
    global $conn, $adminTable;
    return getDataById($conn, $adminTable, $id);
}


function getAdminByCustomColumns($customColumns, $array)
{
    global $conn, $adminTable;
    return getTableDataByCustomColumnsQuery($conn, $adminTable, $customColumns, $array);
}

function updateAdminById($id, $updatedColumns)
{
    global $conn, $adminTable;

    // To find duplicate record
    $email = $updatedColumns['email'];
    $name = $updatedColumns['username'];
    $DucplicateCheckColumn = ['username' => $name, 'OR', 'email' => $email];
    $DuplicateRecord = CheckDuplicateRecordToUpdate($conn, $id, $adminTable, $DucplicateCheckColumn);

    if ($DuplicateRecord == FALSE) {
        $passw = $updatedColumns['password'];
        $updatedColumns['password'] = md5($passw);
        return updateTableDataByIdQuery($conn, $adminTable, $id, $updatedColumns);
    } else {
        $duplicate_data = ["data" => 'DUPLICATE', "id" => $DuplicateRecord];
        return $duplicate_data;
    }
}

function deleteAdminById($id)
{
    global $conn, $adminTable;
    return deleteTableDataByIdQuery($conn, $adminTable, $id);
}

function insertInitialData()
{
    insertAdmin('admin', 'admin@gmail.com', 'admin', null);
}