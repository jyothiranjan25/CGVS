<?php
// include database context file and other required
include_once("../../config/dbconfig.php");
include_once($Base_Path . "/public/code/Queries.php");

$Redirect_URL = "courses.php";


if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $mobile = mysqli_real_escape_string($conn, trim($_POST['mobile']));
    try {
        $insert = insertStudent($name, $email, $mobile);
    } catch (Exception $e) {
        CatchErrorLogs($e, $Redirect_URL);
    } finally {
        header("Location: $Redirect_URL");
        exit;
    }
}

if (isset($_REQUEST['edit'])) {
    try {
        $Id = $_GET['edit'];
        $get = getStudentById($Id);
    } catch (Exception $e) {
        CatchErrorLogs($e, $Redirect_URL);
    }
    $student_id = $get['id'];
    $name = $get['full_name'];
    $email = $get['email'];
    $mobile = $get['mobile'];
}

if (isset($_POST['update'])) {
    $Id = mysqli_real_escape_string($conn, trim($_POST['id']));
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $mobile = mysqli_real_escape_string($conn, trim($_POST['mobile']));
    try {
        $updatedColumns = ["full_name" => "$name", "email" => "$email", "mobile" => "$mobile"];
        $update = updateStudentById($Id, $updatedColumns);
    } catch (Exception $e) {
        CatchErrorLogs($e, $Redirect_URL);
    } finally {
        header("Location: $Redirect_URL");
        exit;
    }
}

if (isset($_GET['delete'])) {
    try {
        $id = $_GET['delete'];
        $delete = deleteStudentById($id);
    } catch (Exception $e) {
        CatchErrorLogs($e, "students.php");
    } finally {
        header('Location: students.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once("./includes/header.php") ?>
    <title>Students</title>
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <?php include_once("./includes/navbar.php") ?>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <?php include_once("./includes/leftmenu.php") ?>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6 grid-margin stretch-card d-flex align-items-center">
                                            <h4 class="card-title mb-0">Students table</h4>
                                        </div>
                                        <div
                                            class="col-lg-6 grid-margin stretch-card d-flex justify-content-end align-items-center">
                                            <button type="button" class="btn btn-light btn-sm" data-toggle="modal"
                                                data-target="#addModal">
                                                Add
                                            </button>
                                        </div>
                                    </div>

                                    <div class=" table-responsive pt-3">
                                        <table class="table table-bordered" id="order-listing">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Mobile</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $data_result = getAllStudents();
                                                // Check if there are any rows returned
                                                
                                                // Output data of each row
                                                $cnt = 1;
                                                foreach ($data_result as $row) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo htmlentities($cnt); ?></td>
                                                        <td><?php echo htmlentities($row['full_name']); ?></td>
                                                        <td><?php echo htmlentities($row['email']); ?></td>
                                                        <td><?php echo htmlentities($row['mobile']); ?></td>
                                                        <td style="text-align: center;">
                                                            <a href="<?php echo $Redirect_URL ?>?edit=<?php echo ($row['id']); ?>"
                                                                style="font-size: 25px; color: #007bff;">
                                                                <i class="typcn typcn-edit"></i>
                                                            </a>
                                                            &nbsp;
                                                            <a href="<?php echo $Redirect_URL ?>?delete=<?php echo ($row['id']); ?>"
                                                                style="font-size: 25px; color: #dc3545;">
                                                                <i class="typcn typcn-delete"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $cnt++;
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add Modal -->
                    <div class="modal fade bd-example-modal-lg" id="addModal" tabindex="-1" role="dialog"
                        aria-labelledby="addModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addModalLabel">Add Student</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="card">
                                        <div class="card-body">
                                            <form class="form-sample" method="POST">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Full Name</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" name="name" id="name"
                                                                    class="form-control" required autocomplete="off" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Email</label>
                                                            <div class="col-sm-8">
                                                                <input type="email" name="email" id="email"
                                                                    class="form-control" required
                                                                    autocomplete="new-password" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Mobile</label>
                                                            <div class="col-sm-8">
                                                                <input type="number" name="mobile" id="mobile"
                                                                    class="form-control" autocomplete="new-password"
                                                                    minlength="10" maxlength="10" pattern="[0-9]{10}"
                                                                    oninput="if(this.value.length > 10) this.value = this.value.slice(0, 10);"
                                                                    required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="display: flex; justify-content:end; gap: 10px;">
                                                    <button type="button" class="btn btn-light"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" name="submit" id="submit"
                                                        class="btn btn-dark">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Add Modal -->

                    <!-- Edit Modal -->
                    <div class="modal fade bd-example-modal-lg" id="editModal" tabindex="-1" role="dialog"
                        aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel">Edit Student</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                        onclick="removeQueryParams()">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="card">
                                        <div class="card-body">
                                            <form class="form-sample" method="POST">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Full Name</label>
                                                            <div class="col-sm-8">
                                                                <input type="hidden" name="id" id="id"
                                                                    value="<?php echo $student_id ?>" />
                                                                <input type="text" name="name" id="name"
                                                                    class="form-control" required autocomplete="off"
                                                                    value="<?php echo $name ?>" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Email</label>
                                                            <div class="col-sm-8">
                                                                <input type="email" name="email" id="email"
                                                                    class="form-control" required
                                                                    autocomplete="new-password"
                                                                    value="<?php echo $email ?>" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Mobile</label>
                                                            <div class="col-sm-8">
                                                                <input type="number" name="mobile" id="mobile"
                                                                    class="form-control" autocomplete="new-password"
                                                                    minlength="10" maxlength="10" pattern="[0-9]{10}"
                                                                    oninput="if(this.value.length > 10) this.value = this.value.slice(0, 10);"
                                                                    required value="<?php echo $mobile ?>" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="display: flex; justify-content:end; gap: 10px;">
                                                    <button type="button" class="btn btn-light" data-dismiss="modal"
                                                        onclick="removeQueryParams()">Close</button>
                                                    <button type="submit" name="update" id="update"
                                                        class="btn btn-dark">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Edit Modal -->
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                <?php include_once("./includes/footer.php") ?>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
</body>

</html>