<?php
// include database context file and other required
include_once("../../config/dbconfig.php");
include_once($Base_Path . "/public/code/Queries.php");

$Redirect_URL = "certificates.php";


if (isset($_POST['submit'])) {
    $student_id = mysqli_real_escape_string($conn, trim($_POST['student_id']));
    $course_id = mysqli_real_escape_string($conn, trim($_POST['course_id']));
    $registration_number = mysqli_real_escape_string($conn, trim($_POST['registration_number']));
    $start_date = mysqli_real_escape_string($conn, trim($_POST['start_date']));
    $completion_date = mysqli_real_escape_string($conn, trim($_POST['completion_date']));
    $QrText = $Base_Path_URL . "verifyCertificate.php?registration_number=$registration_number&student_id=$student_id&course_id=$course_id&start_date=$start_date&completion_date=$completion_date";
    $Qrcode = generateQRCodeBase64($QrText);
    try {
        $insert = insertCertificate($student_id, $course_id, $registration_number, $start_date, $completion_date, $Qrcode);
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
        $get = getCertificateById($Id);
    } catch (Exception $e) {
        CatchErrorLogs($e, $Redirect_URL);
    }
    $certificate_id = $get['id'];
    $student_id = $get['student_id'];
    $course_id = $get['course_id'];
    $registration_number = $get['registration_number'];
    $start_date = $get['start_date'];
    $completion_date = $get['completion_date'];
}

if (isset($_POST['update'])) {
    $Id = mysqli_real_escape_string($conn, trim($_POST['id']));
    $student_id = mysqli_real_escape_string($conn, trim($_POST['student_id']));
    $course_id = mysqli_real_escape_string($conn, trim($_POST['course_id']));
    $registration_number = mysqli_real_escape_string($conn, trim($_POST['registration_number']));
    $start_date = mysqli_real_escape_string($conn, trim($_POST['start_date']));
    $completion_date = mysqli_real_escape_string($conn, trim($_POST['completion_date']));
    $QrText = $Base_Path_URL . "verifyCertificate.php?registration_number=$registration_number&student_id=$student_id&course_id=$course_id&start_date=$start_date&completion_date=$completion_date";
    $Qrcode = generateQRCodeBase64($QrText);
    try {
        $updatedColumns = ["student_id" => "$student_id", "course_id" => "$course_id", "registration_number" => "$registration_number", "start_date" => $start_date, "completion_date" => "$completion_date", "qr_code" => "$Qrcode"];
        $update = updateCertificateById($Id, $updatedColumns);
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
        $delete = deleteCertificateById($id);
    } catch (Exception $e) {
        CatchErrorLogs($e, $Redirect_URL);
    } finally {
        header("Location: $Redirect_URL");
        exit;
    }
}

if (isset($_GET['generateCertificate'])) {
    try {
        $regNo = $_GET['generateCertificate'];
        $certificate_details = getCertificateDetailsByRegNo($regNo);
        $student_name = $certificate_details['full_name'];
        $start_date = $certificate_details['start_date'];
        $completion_date = $certificate_details['completion_date'];
        $course_name = $certificate_details['course_name'];
        $certificate = generateCertificate($student_name, $start_date, $completion_date, $course_name);
    } catch (Exception $e) {
        CatchErrorLogs($e, $Redirect_URL);
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once("./includes/header.php") ?>
    <title>Certificates</title>
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
                                            <h4 class="card-title mb-0">Certificates table</h4>
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
                                                    <th>Student Name</th>
                                                    <th>Course Name</th>
                                                    <th>Registration Number</th>
                                                    <th>Start Date</th>
                                                    <th>Completion Date</th>
                                                    <th>QR Code</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $data_result = getAllCertificates();
                                                // Check if there are any rows returned
                                                
                                                // Output data of each row
                                                $cnt = 1;
                                                foreach ($data_result as $row) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo htmlentities($cnt); ?></td>
                                                        <td><?php echo htmlentities($row['full_name']); ?></td>
                                                        <td><?php echo htmlentities($row['course_name']); ?></td>
                                                        <td><?php echo htmlentities($row['registration_number']); ?></td>
                                                        <td><?php echo htmlentities($row['start_date']); ?></td>
                                                        <td><?php echo htmlentities($row['completion_date']); ?></td>
                                                        <td>
                                                            <button type="button" class="btn" data-toggle="modal"
                                                                style="padding: 0" data-target="#imageViewModal"
                                                                data-whatever="<?php echo htmlentities($row['qr_code']); ?>">
                                                                <img src="<?php echo htmlentities($row['qr_code']); ?>"
                                                                    width="100" height="100" alt="QR Code">
                                                            </button>
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <a href="<?php echo $Redirect_URL ?>?generateCertificate=<?php echo ($row['registration_number']); ?>"
                                                                style="font-size: 25px; color: #007bff;">
                                                                <i class="typcn typcn-document"></i>
                                                            </a>
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
                                    <h5 class="modal-title" id="addModalLabel">Add Certificate</h5>
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
                                                            <label class="col-sm-4 col-form-label">Student</label>
                                                            <div class="col-sm-8">
                                                                <select name="student_id" id="student_id"
                                                                    class="form-control select2" required>
                                                                    <?php
                                                                    $array_query_data = getAllStudents();
                                                                    foreach ($array_query_data as $row) {
                                                                        ?>
                                                                        <option required=" required"
                                                                            value="<?php echo $row['id']; ?>">
                                                                            <?php echo $row['full_name']; ?>
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
                                                            <label class="col-sm-4 col-form-label">Course</label>
                                                            <div class="col-sm-8">
                                                                <select name="course_id" id="course_id"
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
                                                            <label class="col-sm-4 col-form-label">Registration Number
                                                            </label>
                                                            <div class="col-sm-8">
                                                                <input type="text" name="registration_number"
                                                                    id="registration_number" class="form-control"
                                                                    required autocomplete="new-password" required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Start
                                                                Date</label>
                                                            <div class="col-sm-8">
                                                                <input class="form-control" type="date"
                                                                    name="start_date" id="start_date" required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Completion
                                                                Date</label>
                                                            <div class="col-sm-8">
                                                                <input class="form-control" type="date"
                                                                    name="completion_date" id="completion_date"
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
                                    <h5 class="modal-title" id="editModalLabel">Edit Certificate</h5>
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
                                                    value="<?php echo $certificate_id ?>" />
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Course</label>
                                                            <div class="col-sm-8">
                                                                <select name="student_id" id="student_id"
                                                                    class="form-control select2" required>
                                                                    <?php
                                                                    $array_query_data = getAllStudents();
                                                                    foreach ($array_query_data as $row) {
                                                                        $selected = ($row['id'] === $student_id) ? "selected" : "";
                                                                        ?>
                                                                        <option required=" required"
                                                                            value="<?php echo $row['id']; ?>" <?= $selected ?>><?php echo $row['full_name']; ?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Course</label>
                                                            <div class="col-sm-8">
                                                                <select name="course_id" id="course_id"
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
                                                            <label class="col-sm-4 col-form-label">Registration Number
                                                            </label>
                                                            <div class="col-sm-8">
                                                                <input type="text" name="registration_number"
                                                                    id="registration_number" class="form-control"
                                                                    required autocomplete="new-password" required
                                                                    value="<?php echo $registration_number ?>" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Start
                                                                Date</label>
                                                            <div class="col-sm-8">
                                                                <input class="form-control" type="date"
                                                                    name="start_date" id="start_date" required
                                                                    value="<?php echo $start_date ?>" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Completion
                                                                Date</label>
                                                            <div class="col-sm-8">
                                                                <input class="form-control" type="date"
                                                                    name="completion_date" id="completion_date" required
                                                                    value="<?php echo $completion_date ?>" />
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

                    <!-- View Modal -->
                    <div class="modal fade" id="imageViewModal" tabindex="-1" role="dialog"
                        aria-labelledby="imageViewLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="imageViewLabel">Qr Code</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <img src="" id="qr_code" width="100%" height="100%" alt="QR Code">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End View Modal -->
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
    <script>
        $('#imageViewModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('whatever') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('#qr_code').attr('src', recipient);
        })
    </script>
</body>

</html>