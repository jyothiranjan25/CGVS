<?php
require_once '../../../config/dbconfig.php';
include_once($Base_Path . "/public/code/Queries.php");


function setProgress($percent)
{
    $_SESSION['bulk_progress'] = $percent;
}

function getProgress()
{
    return isset($_SESSION['bulk_progress']) ? $_SESSION['bulk_progress'] : 0;
}
function clearProgress()
{
    unset($_SESSION['bulk_progress']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['type']) && $_POST['type'] == 'getProgress') {
    echo json_encode(array('status' => 'success', 'progress' => getProgress()));
    exit;
}
