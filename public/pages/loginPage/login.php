<?php
include_once "loginCode.php";

if (isset($_POST['submit'])) {

  $email = mysqli_real_escape_string($conn, trim($_POST['email']));
  $password = mysqli_real_escape_string($conn, trim($_POST['password']));
  $password = md5($password);
  try {
    $customColumns = ['email' => $email, "OR", "username" => $email];
    $get_user_query = getAdminByCustomColumns($customColumns, false);

    if ($get_user_query == true) {
      $email = $get_user_query['email'];
      $customColumns = ['email' => $email, 'AND', 'password' => $password];
      $get_user_query = getAdminByCustomColumns($customColumns, false);
      if ($get_user_query == true) {
        AppUserLogin($email);
      } else {
        $_SESSION['toasts_title'] = 'Invalid Password';
        $_SESSION['toasts_login'] = 'Invalid password. Please try again.';
        $_SESSION['toasts_type'] = 'error';
        header("Location: $RedirectToLoginPage");
        exit;
      }
    } else {
      $_SESSION['toasts_title'] = 'User Not Found';
      $_SESSION['toasts_login'] = 'User not found. Please try again.';
      $_SESSION['toasts_type'] = 'error';
      header("Location: $RedirectToLoginPage");
      exit;
    }
  } catch (Exception $e) {
    $_SESSION['toasts_title'] = 'Something Went Wrong';
    $_SESSION['toasts_login'] = 'Oops! Something went wrong. Please try again later.';
    $_SESSION['toasts_type'] = 'error';
    $error_log = "Error: " . $e->getMessage() . " - " . date('d-M-Y h:i:s A') . "\r";
    error_log($error_log, 3, "../../logs/data.log");
    header("Location: $RedirectToLoginPage");
    exit;
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login</title>
  <link rel="stylesheet" href="../../vendors/typicons.font/font/typicons.css">
  <link rel="stylesheet" href="../../vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="../../css/vertical-layout-light/style.css">
  <link rel="shortcut icon" href="../../images/EF-icon.png" />
  <link rel="stylesheet" href="../../css/butterup.min.css" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img src="../../images/EF-logo.png" alt="logo">
              </div>
              <h4>Hello! let's get started</h4>
              <h6 class="font-weight-light">Sign in to continue.</h6>
              <form class="pt-3" method="POST" id="login-form">
                <div class="form-group">
                  <input type="text" name="email" id="email" class="form-control form-control-lg"
                    id="exampleInputEmail1" placeholder="Username" required>
                </div>
                <div class="form-group">
                  <input type="password" name="password" id="password" class="form-control form-control-lg"
                    id="exampleInputPassword1" placeholder="Password" required>
                </div>
                <div class="mt-3">
                  <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" type="submit"
                    name="submit" id="submit">SIGN IN</button>
                </div>
                <!-- <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input">
                      Keep me signed in
                    </label>
                  </div>
                  <a href="#" class="auth-link text-black">Forgot password?</a>
                </div> -->
                <!-- <div class="mb-2">
                  <button type="button" class="btn btn-block btn-facebook auth-form-btn">
                    <i class="typcn typcn-social-facebook-circular mr-2"></i>Connect using facebook
                  </button>
                </div> -->
                <!-- <div class="text-center mt-4 font-weight-light">
                  Don't have an account? <a href="register.html" class="text-primary">Create</a>
                </div> -->
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
  <script src="../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <script src="../../js/settings.js"></script>
  <script src="../../js/todolist.js"></script>
  <script src="../../js/butterup.min.js"></script>
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