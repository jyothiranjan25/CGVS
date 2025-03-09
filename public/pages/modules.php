<?php
// include database context file and other required
include_once("../../config/dbconfig.php");
include_once($Base_Path . "/public/code/Queries.php");
include_once($Base_Path . "/public/code/sessionCheck.php");

$Redirect_URL = "modules.php";


if (isset($_POST['submit'])) {
    $course_id = mysqli_real_escape_string($conn, trim($_POST['courseId']));
    $module_name = mysqli_real_escape_string($conn, trim($_POST['moduleName']));
    try {
        $insert = insertModule($course_id, $module_name);
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
        $get = getModuleById($Id);

        $module_id = $get['id'];
        $course_id = $get['course_id'];
        $module_name = $get['module_name'];
    } catch (Exception $e) {
        CatchErrorLogs($e, $Redirect_URL);
    }
}

if (isset($_POST['update'])) {
    $Id = mysqli_real_escape_string($conn, trim($_POST['id']));
    $course_id = mysqli_real_escape_string($conn, trim($_POST['courseId']));
    $module_name = mysqli_real_escape_string($conn, trim($_POST['moduleName']));

    try {
        $updatedColumns = ["course_id" => "$course_id", "module_name" => "$module_name"];
        $update = updateModuleById($Id, $updatedColumns);
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
        $delete = deleteModuleById($id);
    } catch (Exception $e) {
        CatchErrorLogs($e, $Redirect_URL);
    } finally {
        header("Location: $Redirect_URL");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once("./includes/header.php") ?>
    <title>Modules</title>
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
                                            <h4 class="card-title mb-0">Module table</h4>
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
                                                    <th>Course Name</th>
                                                    <th>Module Name</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $data_result = getAllModules();
                                                // Check if there are any rows returned
                                                
                                                // Output data of each row
                                                $cnt = 1;
                                                foreach ($data_result as $row) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo htmlentities($cnt); ?></td>
                                                        <td><?php echo htmlentities($row['course_name']); ?></td>
                                                        <td><?php echo htmlentities($row['module_name']); ?></td>
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
                                    <h5 class="modal-title" id="addModalLabel">Add Module</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="card">
                                        <div class="card-body">
                                            <form class="form-sample" method="POST">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Course</label>
                                                            <div class="col-sm-8">
                                                                <select name="courseId" id="courseId"
                                                                    class="form-control select2" required>
                                                                    <?php
                                                                    $array_query_data = getAllCourses();
                                                                    foreach ($array_query_data as $row) {
                                                                        ?>
                                                                        <option required=" required"
                                                                            value="<?php echo $row['id']; ?>">
                                                                            <?php echo $row['course_name']; ?>
                                                                        </option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Module Name</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" name="moduleName" id="moduleName"
                                                                    class="form-control" required
                                                                    autocomplete="new-password" />
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
                                    <h5 class="modal-title" id="editModalLabel">Edit Module</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                        onclick="removeQueryParams()">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="card">
                                        <div class="card-body">
                                            <form class="form-sample" method="POST">
                                                <input type="hidden" name="id" id="id"
                                                    value="<?php echo $module_id ?>" />
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Course</label>
                                                            <div class="col-sm-8">
                                                                <select name="courseId" id="courseId"
                                                                    class="form-control select2" required>
                                                                    <?php
                                                                    $array_query_data = getAllCourses();
                                                                    foreach ($array_query_data as $row) {
                                                                        $selected = ($row['id'] === $course_id) ? "selected" : "";
                                                                        ?>
                                                                        <option required=" required"
                                                                            value="<?php echo $row['id']; ?>" <?= $selected ?>><?php echo $row['course_name']; ?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Module Name</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" name="moduleName" id="moduleName"
                                                                    class="form-control" required
                                                                    autocomplete="new-password"
                                                                    value="<?php echo $module_name ?>" />
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