<?php

// Function to run create table query with modifiedby columns
function runQuery($conn, $tableName, $query)
{
    if ($conn->query($query) === TRUE) {
        return TRUE;
    } else {
        throw new Exception("MySQLi Query Error: " . $conn->error);
    }
}

// Function to get table data in array query
function getAllData($conn, $tableName)
{
    $query = "SELECT * FROM $tableName ORDER BY id DESC";
    return isArrayData($conn, $query);
}

// Function to get table data for single record query
function getDataById($conn, $tableName, $Id)
{
    $query = "SELECT * FROM $tableName WHERE id = $Id";
    return isSingleRowData($conn, $query);
}

// Function to get table data by custom columns
function getTableDataByCustomColumnsQuery($conn, $tableName, $customColumns, $array)
{
    $query = "SELECT * FROM $tableName WHERE ";
    foreach ($customColumns as $key => $value) {
        if (is_numeric($key)) {
            $query .= " " . $value . " ";
        } else {
            $query .= $key . " = " . '"' . $value . '"';
        }
    }
    $query .= ' ORDER BY id DESC';

    if ($array == TRUE) {
        return isArrayData($conn, $query);
    } else {
        return isSingleRowData($conn, $query);
    }
}

//Function to get data in Array
function isArrayData($conn, $query)
{
    $result = $conn->query($query);
    if ($result === FALSE) {
        throw new Exception("MySQLi Query Error: " . $conn->error);
    }
    // Fetch the results into an associative array
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    // Free the result set
    $result->free_result();
    return $data;
}

//Function to get data in Single Row
function isSingleRowData($conn, $query)
{
    $result = $conn->query($query);
    if ($result === FALSE) {
        throw new Exception("MySQLi Query Error: " . $conn->error);
    }
    $row_result = mysqli_fetch_array($result);
    return $row_result;
}


// Function to check is Array Data
function CheckDataIsArray($conn, $tableName, $customColumns)
{
    $query = "SELECT * FROM $tableName WHERE ";

    foreach ($customColumns as $key => $value) {
        $upperValue = strtoupper($value);
        if (is_numeric($key)) {
            $query .= " " . $upperValue . " ";
        } else {
            $query .= $key . " = " . '"' . $value . '"';
        }
    }
    $result = $conn->query($query);

    if ($result === FALSE) {
        throw new Exception("MySQLi Query Error: " . $conn->error);
    }

    if ($result->num_rows > 1) {
        return TRUE;
    } else {
        return FALSE;
    }
}

// Function to check table data by custom columns Without array Parameter WITH ID
// USED FOR UPDATE THE RECORD
function CheckDuplicateRecordBeforeInsert($conn, $tableName, $customColumns)
{
    $query = "SELECT * FROM $tableName WHERE ";

    foreach ($customColumns as $key => $value) {
        $upperValue = strtoupper($value);
        if (is_numeric($key)) {
            $query .= " " . $upperValue . " ";
        } else {
            $query .= $key . " = " . '"' . $value . '"';
        }
    }

    $result = $conn->query($query);

    if ($result === FALSE) {
        throw new Exception("MySQLi Query Error: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        $_SESSION['toasts_title'] = 'Duplicate Data';
        $_SESSION['toasts_message'] = 'Duplicate data entries have been identified.';
        $_SESSION['toasts_type'] = 'warning';
        $row_result = mysqli_fetch_array($result);
        return $row_result['id'];
    } else {
        return FALSE;
    }
}

// Function to check duplicate data to update
function CheckDuplicateRecordToUpdate($conn, $Id, $tableName, $customColumns)
{
    $query = "SELECT * FROM $tableName WHERE NOT id = $Id AND ";

    foreach ($customColumns as $key => $value) {
        $upperValue = strtoupper($value);
        if (is_numeric($key)) {
            $query .= " " . $upperValue . " ";
        } else {
            $query .= $key . " = " . '"' . $value . '"';
        }
    }

    $result = $conn->query($query);

    if ($result === FALSE) {
        throw new Exception("MySQLi Query Error: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        $_SESSION['toasts_title'] = 'Duplicate Data';
        $_SESSION['toasts_message'] = 'Duplicate data entries have been identified.';
        $_SESSION['toasts_type'] = 'warning';
        return TRUE;
    } else {
        return FALSE;
    }
}

// Function to run query
function runConnectionQuery($conn, $query)
{
    if ($conn->query($query) === False) {
        throw new Exception("MySQLi Query Error: " . $conn->error);
    }
    $_SESSION['toasts_title'] = 'Data Updated Successfully';
    $_SESSION['toasts_message'] = 'Your data has been updated successfully.';
    $_SESSION['toasts_type'] = 'success';
    return TRUE;
}


// Function to Insert data 
function insertDatastmtQuery($conn, $tableName, $stmt)
{
    if ($stmt->execute()) {
        $_SESSION['toasts_title'] = 'Data Saved Successfully';
        $_SESSION['toasts_message'] = 'Your data has been saved successfully.';
        $_SESSION['toasts_type'] = 'success';
        $insertedId = $conn->insert_id;
        $_SESSION['inserted_id'] = $insertedId;
        $stmt->close();
        return ["data" => 'SUCCESS', "id" => $insertedId];
    } else {
        echo "Error inserting data into table $tableName: " . $conn->error;
        $_SESSION['toasts_title'] = 'Something Went Wrong';
        $_SESSION['toasts_message'] = 'Oops! Something went wrong. Please try again later.';
        $_SESSION['toasts_type'] = 'error';
        $stmt->close();
        throw new Exception("MySQLi Execute Error: " . $stmt->error);
    }
}

// Function to Update data By Id
function updateTableDataByIdQuery($conn, $tableName, $Id, $updatedColumns)
{
    $setClause = '';
    foreach ($updatedColumns as $column => $value) {
        if ($value === null || $value === 'null' || $value === 'NULL' || $value === '') {
            $setClause .= "$column = NULL, ";
        } else {
            $setClause .= "$column = '$value', ";
        }
    }
    $setClause = rtrim($setClause, ', ');
    $updateSql = "UPDATE $tableName SET $setClause WHERE id = $Id";

    if ($conn->query($updateSql) === TRUE) {
        $_SESSION['toasts_title'] = 'Data Updated Successfully';
        $_SESSION['toasts_message'] = 'Your data has been updated successfully.';
        $_SESSION['toasts_type'] = 'success';
        return ["data" => 'SUCCESS', "id" => $Id];
    } else {
        $_SESSION['toasts_title'] = 'Something Went Wrong';
        $_SESSION['toasts_message'] = $updateSql . $conn->error;
        $_SESSION['toasts_type'] = 'error';
        throw new Exception("MySQLi Query Error: " . $conn->error);
    }
}

// Function to Update data By Custom columns
function updateTableDataByCustomColumnsQuery($conn, $tableName, $updatedColumns, $customColumns)
{
    $Array = CheckDataIsArray($conn, $tableName, $customColumns);

    $getTableRowQuery = getTableDataByCustomColumnsQuery($conn, $tableName, $customColumns, $Array);

    if ($Array == False) {
        $Id = $getTableRowQuery['id'];
        if (!empty($Id))
            return updateTableDataByIdQuery($conn, $tableName, $Id, $updatedColumns);
    } else {
        foreach ($getTableRowQuery as $row) {
            $Id = $row['id'];
            if (!empty($Id))
                updateTableDataByIdQuery($conn, $tableName, $Id, $updatedColumns);
        }
    }
    $conn->close();
}

// Function to delete data by Id
function deleteTableDataByIdQuery($conn, $tableName, $id)
{
    $deleteSql = "DELETE FROM $tableName WHERE id = $id";

    if ($conn->query($deleteSql) === FALSE) {
        $_SESSION['toasts_title'] = 'Something Went Wrong';
        $_SESSION['toasts_message'] = 'Data is linked with other tables. Please delete the linked data first.';
        $_SESSION['toasts_type'] = 'error';
        throw new Exception("MySQLi Query Error: " . $conn->error);
    }
    $_SESSION['toasts_title'] = 'Data Deleted Successfully';
    $_SESSION['toasts_message'] = 'The data has been deleted successfully.';
    $_SESSION['toasts_type'] = 'info';
    return TRUE;
}

// Function to delete data by Custom Columns
function deleteTabledataByCustomColumnsQuery($conn, $tableName, $customColumns)
{
    $deleteSql = "DELETE FROM $tableName WHERE ";
    foreach ($customColumns as $key => $value) {
        $upperValue = strtoupper($value);
        if (is_numeric($key)) {
            $deleteSql .= " " . $upperValue . " ";
        } else {
            $deleteSql .= $key . " = " . '"' . $value . '"';
        }
    }
    if ($conn->query($deleteSql) === FALSE) {
        $_SESSION['toasts_title'] = 'Something Went Wrong';
        $_SESSION['toasts_message'] = 'Oops! Something went wrong. Please try again later.';
        $_SESSION['toasts_type'] = 'error';
        throw new Exception("MySQLi Query Error: " . $conn->error);
    }
    $_SESSION['toasts_title'] = 'Data Deleted Successfully';
    $_SESSION['toasts_message'] = 'The data has been deleted successfully.';
    $_SESSION['toasts_type'] = 'info';
    return TRUE;
}

function getCount($conn, $tableName)
{
    $query = "SELECT COUNT(*) FROM $tableName";
    $result = isSingleRowData($conn, $query);
    return $result['COUNT(*)'];
}
