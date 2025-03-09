<?php

// include database context file and other required
include_once("../../config/dbconfig.php");
include_once($Base_Path . "/public/code/Queries.php");
include_once($Base_Path . "/public/code/sessionCheck.php");

$total_students = getTotalStudents();
$total_courses = getTotalCourses();
$total_projects = getTotalProjects();
$total_certificates = getTotalCertificates();
$students_for_courses = getStudentsForCourses();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once("./includes/header.php") ?>
    <title>Dashboard</title>
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
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card" style="min-height: calc(97vh - 100px);">
                                <div class="card-body">
                                    <h4 class="card-title">Dashboard</h4>
                                    <p class="card-description">
                                        Welcome to the dashboard
                                    </p>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h6 class="card-title">Total Students</h6>
                                                    <h3 class="card-text"><?php echo $total_students; ?></h3>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h6 class="card-title">Total Courses</h6>
                                                    <h3 class="card-text"><?php echo $total_courses; ?></h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h6 class="card-title">Total Projects</h6>
                                                    <h3 class="card-text"><?php echo $total_projects; ?></h3>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h6 class="card-title">Total certificates</h6>
                                                    <h3 class="card-text"><?php echo $total_certificates; ?></h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xl-6 d-flex grid-margin stretch-card">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex flex-wrap justify-content-between">
                                                        <h4 class="card-title mb-3">Card Title</h4>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <canvas id="barChartStacked"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
</body>

</html>