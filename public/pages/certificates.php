<?php
// include database context file and other required
include_once("../../config/dbconfig.php");
include_once($Base_Path . "/public/code/Queries.php");
include_once($Base_Path . "/public/code/sessionCheck.php");
$Redirect_URL = $Extract_File_name;

if (isset($_POST['submit'])) {
    $student_id = mysqli_real_escape_string($conn, trim($_POST['student_id']));
    $course_id = mysqli_real_escape_string($conn, trim($_POST['course_id']));
    $registration_number = mysqli_real_escape_string($conn, trim($_POST['registration_number']));
    $start_date = mysqli_real_escape_string($conn, trim($_POST['start_date']));
    $completion_date = mysqli_real_escape_string($conn, trim($_POST['completion_date']));
    $QrText = $Base_Path_URL . "verifyCertificate.php?$registration_number";
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

        $certificate_id = $get['id'];
        $student_id = $get['student_id'];
        $course_id = $get['course_id'];
        $registration_number = $get['registration_number'];
        $start_date = $get['start_date'];
        $completion_date = $get['completion_date'];
        $status = $get['status'];
    } catch (Exception $e) {
        CatchErrorLogs($e, $Redirect_URL);
    }
}

if (isset($_POST['update'])) {
    $Id = mysqli_real_escape_string($conn, trim($_POST['id']));
    $student_id = mysqli_real_escape_string($conn, trim($_POST['student_id']));
    $course_id = mysqli_real_escape_string($conn, trim($_POST['course_id']));
    $registration_number = mysqli_real_escape_string($conn, trim($_POST['registration_number']));
    $start_date = mysqli_real_escape_string($conn, trim($_POST['start_date']));
    $completion_date = mysqli_real_escape_string($conn, trim($_POST['completion_date']));
    $status = mysqli_real_escape_string($conn, trim($_POST['status']));
    $QrText = $Base_Path_URL . "verifyCertificate.php?$registration_number";
    $Qrcode = generateQRCodeBase64($QrText);

    try {
        $updatedColumns = ["student_id" => "$student_id", "course_id" => "$course_id", "registration_number" => "$registration_number", "start_date" => $start_date, "completion_date" => "$completion_date", "qr_code" => "$Qrcode", "status" => "$status"];
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
        $qr_code = $certificate_details['qr_code'];
        $otherData = [
            "evaluation_methodology" => $certificate_details['evaluation_methodology'],
            'modules_covered' => $certificate_details['modules_covered']
        ];
        $certificate = generateCertificate($regNo, $student_name, $start_date, $completion_date, $course_name, $qr_code, $otherData);
        $certificatePath = $certificate['path'];

        // download the certificate
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $student_name . '_certificate.png"');
        readfile($certificatePath);
    } catch (Exception $e) {
        CatchErrorLogs($e, $Redirect_URL);
    } finally {
        header("Location: $Redirect_URL");
        exit;
    }
}


if (isset($_POST['bulkupload'])) {
    try {
        $add_student = $_POST['add_student'] == "on" ? true : false;
        $add_course = $_POST['add_course'] == "on" ? true : false;

        $error_File_temp = "certificate.csv";
        $hasErrors = false; // Flag to track if errors occurred

        // Check if a CSV file is uploaded
        if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
            $csv_file = $_FILES['csv_file']['tmp_name'];
            // Open the CSV file
            if (($handle = fopen($csv_file, "r")) !== FALSE) {
                // Open the error log file for writing
                $error_File = fopen($error_File_temp, "w");

                // Loop through the rows of data
                $i = 1;
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    //Get data from Excel
                    $student_name = trim($conn->real_escape_string($data[0]));
                    $email = trim($conn->real_escape_string($data[1]));
                    $mobile = trim($conn->real_escape_string($data[2]));
                    $course_name = trim($conn->real_escape_string($data[3]));
                    $duration = trim($conn->real_escape_string($data[4]));
                    $registration_number = trim($conn->real_escape_string($data[5]));
                    $start_date_raw = trim($conn->real_escape_string($data[6]));
                    $completion_date_raw = trim($conn->real_escape_string($data[7]));
                    //Get data from Excel

                    // Skip the first row (header)
                    if ($i != 1) {
                        $error_message = "";

                        if (!empty($email)) {
                            // get student id
                            $student_filter = ["email" => $email];
                            $student = getStudentByCustomColumns($student_filter, false);

                            if ($student == false) {
                                if ($add_student) {
                                    if (empty($student_name) || empty($email) || empty($mobile)) {
                                        $error_message .= "Student name, email and mobile is required - ";
                                    } else {
                                        $new_student = insertStudent($student_name, $email, $mobile);
                                        if ($insert["data"] == "DUPLICATE") {
                                            $error_message .= " Duplicate Email - $email";
                                        } else {
                                            $student_id = $new_student['id'];
                                        }
                                    }
                                } else {
                                    $error_message .= "Student is Not Found - ";
                                }
                            } else {
                                $student_id = $student['id'];
                            }
                        } else {
                            $error_message .= "Email is required - ";
                        }

                        if (!empty($course_name) && !empty($duration)) {
                            // get course id
                            $course_filter = ["course_name" => $course_name];
                            $course = getCourseByCustomColumns($course_filter, false);

                            if ($course == false) {
                                if ($add_course) {
                                    $new_course = insertCourse($course_name, $duration);
                                    $course_id = $new_course['id'];
                                } else {
                                    $error_message .= "Course is Not Found - ";
                                }
                            } else {
                                $course_id = $course['id'];
                            }
                        } else {
                            $error_message .= "Course is required and duration is required - ";
                        }

                        if (!empty($student_id) && !empty($course_id)) {
                            if (!empty($registration_number) && !empty($start_date_raw) && !empty($completion_date_raw)) {

                                // Split into parts
                                list($day1, $month1, $year1) = explode('/', $start_date_raw);
                                list($day2, $month2, $year2) = explode('/', $completion_date_raw);

                                // Create proper date strings
                                $start_date = "$year1-$month1-$day1";        // Y-m-d
                                $completion_date = "$year2-$month2-$day2";   // Y-m-d

                                $start_date = date('Y-m-d', strtotime($start_date));
                                $completion_date = date('Y-m-d', strtotime($completion_date));

                                $QrText = $Base_Path_URL . "verifyCertificate.php?$registration_number";
                                $Qrcode = generateQRCodeBase64($QrText);

                                $insert = insertCertificate($student_id, $course_id, $registration_number, $start_date, $completion_date, $Qrcode);
                                if ($insert["data"] == "DUPLICATE") {
                                    $error_message .= " Duplicate Registration Number - $registration_number";
                                }
                            } else {
                                $error_message .= " Registration number, start date and completion date is required";
                            }
                        } else {
                            CatchUploadErrorLogs(message: "Student id and course id is null");
                        }

                        if (!empty($error_message)) {
                            $hasErrors = true;
                            $data = [$student_name, $email, $mobile, $course_name, $duration, $registration_number, $start_date, $completion_date, $error_message];
                            fputcsv($error_File, $data);
                        }
                    } else {
                        $data = [$student_name, $email, $mobile, $course_name, $duration, $registration_number, $start_date, $completion_date];
                        fputcsv($error_File, $data);
                    }
                    $i++;
                }
                fclose($handle);
                fclose($error_File);

                if ($hasErrors) {
                    // Force download of error file
                    header('Content-Type: text/csv');
                    header('Content-Disposition: attachment; filename="certificate.csv"');
                    readfile($error_File_temp);
                    unlink($error_File_temp);
                    exit;
                } else {
                    $_SESSION['toasts_title'] = 'Success!';
                    $_SESSION['toasts_message'] = 'CSV file processed successfully!';
                    $_SESSION['toasts_type'] = 'success';
                }
            } else {
                $_SESSION['toasts_title'] = 'Oops!';
                $_SESSION['toasts_message'] = 'Error with csv file';
                $_SESSION['toasts_type'] = 'error';
            }
        }
    } catch (Exception $e) {
        $_SESSION['toasts_title'] = 'Oops!';
        $_SESSION['toasts_message'] = "Error with csv file";
        $_SESSION['toasts_type'] = 'error';
        CatchErrorLogs($e, $Redirect_URL);
    } finally {
        unlink($error_File_temp);
        header("Location: $Redirect_URL");
        exit;
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
                                        <div class="col-lg-6 grid-margin stretch-card d-flex justify-content-end align-items-center"
                                            style="gap: 10px;">
                                            <button type="button" class="btn btn-light btn-sm" data-toggle="modal"
                                                data-target="#addModal">
                                                Add
                                            </button>
                                            <button type="button" class="btn btn-light btn-sm" data-toggle="modal"
                                                data-target="#bulkAddModal">
                                                Bulk Add
                                            </button>
                                            <button type="button" class="btn btn-light btn-sm" id="bulkDownload">
                                                Bulk Download
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
                                                                style="font-size: 20px; color: #007bff;"><i
                                                                    class="typcn typcn-document"></i></a>
                                                            <a href="verifyCertificate.php?<?php echo ($row['registration_number']); ?>"
                                                                style="font-size: 20px; color: #007bff;"><i
                                                                    class=" typcn typcn-tick-outline"></i></a>
                                                            <a href="<?php echo $Redirect_URL ?>?edit=<?php echo ($row['id']); ?>"
                                                                style="font-size: 20px; color: #007bff;"><i
                                                                    class="typcn typcn-edit"></i></a>
                                                            <a data-toggle="modal" data-target="#deleteModal" data-whatever="<?php echo htmlentities($row['id']); ?>"
                                                                style="font-size: 20px; color: #dc3545;">
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
                                                    <div class="col-md-12">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Status</label>
                                                            <div class="col-sm-8">
                                                                <select name="status" id="status"
                                                                    class="form-control select2" required>
                                                                    <option value="1" <?= $status == '1' ? 'selected' : '' ?>>Active</option>
                                                                    <option value="0" <?= $status == '0' ? 'selected' : '' ?>>Inactive</option>
                                                                </select>
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

                    <!-- Bulk Add Modal -->
                    <div class="modal fade bd-example-modal-lg" id="bulkAddModal" tabindex="-1" role="dialog"
                        aria-labelledby="bulkAddModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="bulkAddModalLabel">Bulk Add Certificate</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="card">
                                        <div class="card-body">
                                            <form class="form-sample" method="POST" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Upload CSV</label>
                                                            <div class="col-sm-8">
                                                                <input type="file" class="form-control" name="csv_file"
                                                                    id="csv_file" accept=".csv" required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label">Upload CSV</label>
                                                            <div class="col-sm-8" style="align-content: center;">
                                                                <a href='../csvTemp/certificate.csv' download>sample
                                                                    File</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <center>
                                                            <p>Upload Settings</p>
                                                        </center>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group row">
                                                            <label class="col-sm-8 col-form-label">
                                                                Add new Student (Create new student if not found in system)
                                                            </label>
                                                            <div class="col-sm-4" style="align-content: center;">
                                                                <input type="checkbox" name="add_student"
                                                                    id="add_student" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group row">
                                                            <label class="col-sm-8 col-form-label">
                                                                Add Course (Create new course if not found in system)
                                                            </label>
                                                            <div class="col-sm-4" style="align-content: center;">
                                                                <input type="checkbox" name="add_course"
                                                                    id="add_course" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="display: flex; justify-content:end; gap: 10px;">
                                                    <button type="button" class="btn btn-light"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" name="bulkupload" id="bulkupload"
                                                        class="btn btn-dark">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Bulk Add Modal -->

                    <!-- delete Modal -->
                    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel">Alert</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Are you sure, you want to delete this record!</label>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                    <a type="button" class="btn btn-dark" id="deleteRecord" href="#">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
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
        $('#imageViewModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('whatever') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('#qr_code').attr('src', recipient);
        })
        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('whatever') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            var url = "<?php echo $Redirect_URL ?>?delete=" + recipient;
            modal.find('#deleteRecord').attr('href', url);
        })
    </script>
    <script>
        $(document).ready(function() {
            // Handle the subcribe button click
            $("#bulkDownload").click(function() {
                // Perform an AJAX request
                $.ajax({
                    type: "POST",
                    url: "./helper/bulkDownloadCertificate.php",
                    data: {
                        type: 'bulkDownlaod'
                    },
                    beforeSend: function() {
                        butterup.toast({
                            title: "Processing",
                            message: "Please wait while we prepare your download.",
                            type: "info",
                            dismissable: true,
                            icon: true,
                        });
                    },
                    success: function(response) {
                        var result = JSON.parse(response);
                        const responseObject = JSON.parse(response);
                        if (responseObject.status === "success") {
                            var zipFileURL = responseObject.zipFileURL;
                            try {
                                // Create a hidden anchor element and trigger a download
                                var downloadLink = document.createElement("a");
                                downloadLink.href = zipFileURL;
                                downloadLink.download = "bulkCert.zip"; // Set the filename
                                document.body.appendChild(downloadLink);
                                downloadLink.click();
                                document.body.removeChild(downloadLink);
                            } finally {
                                butterup.toast({
                                    title: "Success",
                                    message: responseObject.message,
                                    type: "success",
                                    dismissable: true,
                                    icon: true,
                                });
                                deleteZipFolder(responseObject.zipFolder);
                            }
                        } else {
                            // Handle other scenarios if needed
                            butterup.toast({
                                title: "Something went wrong",
                                message: responseObject.message,
                                type: "error",
                                dismissable: true,
                                icon: true,
                            });
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        // Handle any errors that occur during the AJAX request
                        console.error(error);
                    }
                });
            });
        });

        function deleteZipFolder(value) {
            $.ajax({
                type: "POST",
                url: "./helper/bulkDownloadCertificate.php",
                data: {
                    type: 'deleteZipFolder',
                    value: value
                },
                success: function(response) {
                    var result = JSON.parse(response);
                    const responseObject = JSON.parse(response);
                    if (responseObject.status === "success") {
                        // something
                    } else {
                        // something
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    // Handle any errors that occur during the AJAX request
                    console.error(error);
                }
            });
        }
    </script>
</body>

</html>