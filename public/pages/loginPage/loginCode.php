<?php

// include database context file and other required
include_once("../../../config/dbconfig.php");
include_once($Base_Path . "/public/code/Queries.php");

// unset any active sessions
unset($_SESSION['login_user_id']);
unset($_SESSION['login_user_name']);
unset($_SESSION['login_user_email']);
unset($_SESSION['login_user_role_name']);

// redirect URL's
$RedirectToLoginPage = $Extract_File_name;
$RedirectToDashboard = $Base_Path . '/public/pages/index.php';

function AppUserLogin($email)
{
    global $Base_Path, $RedirectToLoginPage, $RedirectToDashboard;

    // get user details
    $customColumns = ['email' => $email];
    $get_user_query = getAdminByCustomColumns($customColumns, false);
    if ($get_user_query == true) {
        $_SESSION['login_user_id'] = $get_user_query['id'];
        $_SESSION['login_user_name'] = $get_user_query['username'];
        $_SESSION['login_user_email'] = $get_user_query['email'];
        $_SESSION['login_user_role_name'] = $get_user_query['role'];
        header("Location: $RedirectToDashboard");
        exit;
    } else {
        $_SESSION['toasts_title'] = 'User Not Found';
        $_SESSION['toasts_login'] = 'User not found. Please try again.';
        $_SESSION['toasts_type'] = 'error';
        header("Location: $RedirectToLoginPage");
        exit;
    }
}
