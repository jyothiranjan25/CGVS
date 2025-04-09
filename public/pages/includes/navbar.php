<?php

if (isset($_GET['logout'])) {
    $RedirectTo = $Base_URL . '/config/session_destroy.php';
    header("location: $RedirectTo ");
    exit;
}

$RedirextToSamePage = $Extract_File_name_with_params;

if (isset($_POST['resetPassword'])) {
    $username = mysqli_real_escape_string($conn, trim($_SESSION['login_user_name']));
    $email = mysqli_real_escape_string($conn, trim($_SESSION['login_user_email']));
    $oldPassword = mysqli_real_escape_string($conn, trim($_POST['oldPassword']));
    $newPassword = mysqli_real_escape_string($conn, trim($_POST['newPassword']));
    try {
        $customColumns = ['username' => $username, 'OR', 'email' => $email];
        $user = getAdminByCustomColumns($customColumns, false);

        if (!empty($user)) {
            if (md5($oldPassword) === $user['password']) {

                $updatedColumns = [
                    'password' => $newPassword,
                ];

                updateAdminById($user['id'], $updatedColumns);
                $_SESSION['toasts_title'] = "Password Change";
                $_SESSION['toasts_message'] = "Password updated successfully.";
                $_SESSION['toasts_type'] = "success";
            } else {
                $_SESSION['toasts_title'] = "Invalid Password";
                $_SESSION['toasts_message'] = "Old password is incorrect.";
                $_SESSION['toasts_type'] = "error";
            }
        } else {
            $_SESSION['toasts_title'] = "User Not Found";
            $_SESSION['toasts_message'] = "User not found, please try again.";
            $_SESSION['toasts_type'] = "error";
        }
    } catch (Exception $e) {
        CatchErrorLogs($e, $RedirextToSamePage);
    } finally {
        header("Location: $RedirextToSamePage");
        exit;
    }
}

?>
<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="./"><img src="../images/EF-logo.png" alt="logo" /></a>
        <a class="navbar-brand brand-logo-mini" href="./"><img src="../images/EF-icon.png" alt="logo" /></a>
        <button class="navbar-toggler navbar-toggler align-self-center d-none d-lg-flex" type="button"
            data-toggle="minimize">
            <span class="typcn typcn-th-menu"></span>
        </button>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle pl-0 pr-0" href="#" data-toggle="dropdown" id="profileDropdown">
                    <i class="typcn typcn-user-outline mr-0"></i>
                    <span class="nav-profile-name"> <?php echo $_SESSION['login_user_name'] ?> </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" data-toggle="modal" data-target="#changePassword">
                        <i class="typcn typcn-lock-closed-outline text-primary"></i>
                        Change Password
                    </a>
                    <a class="dropdown-item" href="?logout=1">
                        <i class="typcn typcn-power text-primary"></i>
                        Logout
                    </a>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="typcn typcn-th-menu"></span>
        </button>
    </div>
</nav>

<!-- Add Modal -->
<div class="modal fade bd-example-modal-lg" id="changePassword" tabindex="-1" role="dialog"
    aria-labelledby="changePasswordLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordLabel">Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <form class="form-sample" method="POST" onsubmit="return validateForm()">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Old Password</label>
                                        <div class="col-sm-8">
                                            <input type="password" name="oldPassword" id="oldPassword"
                                                class="form-control" required autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">New Password</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="newPassword" id="newPassword"
                                                class="form-control" required autocomplete="off" onkeyup="checkPasswordMatch()" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Confirm Password</label>
                                        <div class="col-sm-8">
                                            <input type="password" name="cPassword" id="cPassword"
                                                class="form-control" required autocomplete="off" onkeyup="checkPasswordMatch()" />
                                            <small id="matchMsg" style="color: red; display: none;">Passwords do not match.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="display: flex; justify-content:end; gap: 10px;">
                                <button type="button" class="btn btn-light"
                                    data-dismiss="modal">Close</button>
                                <button type="submit" name="resetPassword" id="resetPassword"
                                    class="btn btn-dark" disabled>Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Add Modal -->
<script>
    function checkPasswordMatch() {
        const newPassword = document.getElementById("newPassword").value;
        const confirmPassword = document.getElementById("cPassword").value;
        const saveBtn = document.getElementById("resetPassword");
        const msg = document.getElementById("matchMsg");

        if (newPassword && confirmPassword && newPassword === confirmPassword) {
            saveBtn.disabled = false;
            msg.style.display = "none";
        } else {
            saveBtn.disabled = true;
            if (confirmPassword !== "") {
                msg.style.display = "block";
            } else {
                msg.style.display = "none";
            }
        }
    }

    function validateForm() {
        const newPassword = document.getElementById("newPassword").value;
        const confirmPassword = document.getElementById("cPassword").value;
        return newPassword === confirmPassword;
    }
</script>