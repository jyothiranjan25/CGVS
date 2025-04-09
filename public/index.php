<?php
include_once(__DIR__ . "/../config/dbconfig.php");
include_once($Base_Path . "/public/code/Queries.php");

$RedirectPage =  "./";
$RedirectToVerifyPage = 'pages/verifyCertificate.php';


if (isset($_POST['submit'])) {

    $RegNo = mysqli_real_escape_string($conn, trim($_POST['RegNo']));
    try {
        $customColumns = ['registration_number' => $RegNo];
        $get_user_query = getCertificateByCustomColumns($customColumns, false);

        if ($get_user_query == true) {
            header("Location: $RedirectToVerifyPage?$RegNo");
            exit;
        } else {
            $_SESSION['toasts_title'] = 'Certificate Not Found';
            $_SESSION['toasts_login'] = 'Certificate Not Found. Please check your Registration Number.';
            $_SESSION['toasts_type'] = 'error';
            header("Location: $RedirectPage");
            exit;
        }
    } catch (Exception $e) {
        $_SESSION['toasts_title'] = 'Something Went Wrong';
        $_SESSION['toasts_login'] = 'Oops! Something went wrong. Please try again later.';
        $_SESSION['toasts_type'] = 'error';
        $error_log = "Error: " . $e->getMessage() . " - " . date('d-M-Y h:i:s A') . "\r";
        error_log($error_log, 3, "../../logs/data.log");
        header("Location: $RedirectPage");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- css -->
    <link rel="stylesheet" href="vendors/typicons.font/font/typicons.css" />
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css" />
    <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css" />
    <!-- inject:css -->
    <link rel="stylesheet" href="css/vertical-layout-light/style.css" />
    <link rel="stylesheet" href="css/butterup.min.css" />

    <!-- favicon -->
    <link rel="shortcut icon" href="images/EF-icon.png" />

    <title>EDFLIX™</title>
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link pl-0 pr-0" href="pages/loginPage/login.php">
                            <i class="typcn typcn-user-outline mr-0"></i>
                            <span class="nav-profile-name"><?php echo "Admin" ?></span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- partial -->
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo">
                                <img src="images/EF-logo.png" alt="logo">
                            </div>
                            <h4>Hello! let's get started</h4>
                            <h6 class="font-weight-light">Enter Registration Number to continue.</h6>
                            <form class="pt-3" method="POST" id="login-form">
                                <div class="form-group">
                                    <input type="text" name="RegNo" id="RegNo" class="form-control form-control-lg"
                                        id="exampleInputEmail1" placeholder="Registration Number" required autocomplete="off">
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" type="submit"
                                        name="submit" id="submit">CONTINUE</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- base:js -->
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/hoverable-collapse.js"></script>
    <script src="js/template.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/todolist.js"></script>
    <script src="js/butterup.min.js"></script>
    <!-- endinject -->
    <?php
    if ((isset($_SESSION['toasts_login']) && $_SESSION['toasts_login'])) {
    ?>
        <script>
            butterup.options.maxToasts = 3;
            butterup.options.toastLife = 3000;
            butterup.toast({
                title: "<?php echo $_SESSION['toasts_title']; ?>",
                message: "<?php echo $_SESSION['toasts_login']; ?>",
                type: "<?php echo $_SESSION['toasts_type']; ?>",
                dismissable: true,
                icon: true,
            });
        </script>
    <?php
        unset($_SESSION['toasts_title']);
        unset($_SESSION['toasts_login']);
        unset($_SESSION['toasts_type']);
    }
    ?>
</body>

</html>