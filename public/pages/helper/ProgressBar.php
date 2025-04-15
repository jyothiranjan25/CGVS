<?php
require_once '../../../config/dbconfig.php';
include_once($Base_Path . "/public/code/Queries.php");

function setProgress($percent)
{
    session_start();
    $_SESSION['bulk_progress'] = $percent;
    session_write_close();
}

function getProgress()
{
    $ProgressPoll = isset($_SESSION['bulk_progress']) ? $_SESSION['bulk_progress'] : 0;

    if ($ProgressPoll >= 100) {
        clearProgress();
    }

    return $ProgressPoll;
}
function clearProgress()
{
    unset($_SESSION['bulk_progress']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['type']) && $_POST['type'] == 'getProgress') {
    echo json_encode(array('status' => 'success', 'progress' => getProgress()));
    exit;
}
