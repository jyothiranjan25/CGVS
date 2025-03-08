<?php
if ((!isset($_SESSION['login_user_role_name']) || !isset($_SESSION['login_user_name'])) && !isset($NoLogin)) {
    unset($_SESSION['login_user_id']);
    unset($_SESSION['login_user_name']);
    unset($_SESSION['login_user_email']);
    unset($_SESSION['login_user_role_name']);
    session_destroy();
    echo '<script>window.location.href = "' . $Base_URL . '"</script>';
}