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

foreach ($students_for_courses as $student) {
    $data[] = $student['total_certificates'];
}

$labels = json_encode($labels);
$data = json_encode($data);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once("./includes/header.php") ?>
    <title>Dashboard</title>
</head>

<body>

    <div class="container-scroller">
        <i class="typcn typcn-delete-outline" id="bannerClose" style="display: none;"></i>
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
                                                        <h4 class="card-title mb-3">Students for courses</h4>
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
    <script>
        var labels = <?php echo $labels; ?>;
        var data = <?php echo $data; ?>;

        var barChartStackedData = {
            labels: labels,
            datasets: [{
                label: 'Students',
                data: data,
                backgroundColor: [
                    '#2b80ff',
                    '#2b80ff',
                    '#2b80ff',
                    '#2b80ff',
                    '#2b80ff',
                    '#2b80ff',
                    '#2b80ff',
                    '#2b80ff',
                    '#2b80ff',
                    '#2b80ff',
                    '#2b80ff',
                    '#2b80ff',
                ],
                borderColor: [
                    '#2b80ff',
                    '#2b80ff',
                    '#2b80ff',
                    '#2b80ff',
                    '#2b80ff',
                    '#2b80ff',
                    '#2b80ff',
                    '#2b80ff',
                    '#2b80ff',
                    '#2b80ff',
                    '#2b80ff',
                    '#2b80ff',
                ],
                borderWidth: 1,
                fill: false
            }]
        };
        var barChartStackedOptions = {
            scales: {
                xAxes: [{
                    display: false,
                    stacked: true,
                    gridLines: {
                        display: false //this will remove only the label
                    },
                }],
                yAxes: [{
                    stacked: true,
                    display: false,
                }]
            },
            legend: {
                display: false,
                position: "bottom"
            },
            legendCallback: function (chart) {
                var text = [];
                text.push('<div class="row">');
                for (var i = 0; i < chart.data.datasets.length; i++) {
                    text.push('<div class="col-sm-5 mr-3 ml-3 ml-sm-0 mr-sm-0 pr-md-0 mt-3"><div class="row align-items-center"><div class="col-2"><span class="legend-label" style="background-color:' + chart.data.datasets[i].backgroundColor[i] + '"></span></div><div class="col-9"><p class="text-dark m-0">' + chart.data.datasets[i].label + '</p></div></div>');
                    text.push('</div>');
                }
                text.push('</div>');
                return text.join("");
            },
            elements: {
                point: {
                    radius: 0
                }
            }
        };

        if ($("#barChartStacked").length) {
            var barChartCanvas = $("#barChartStacked").get(0).getContext("2d");
            // This will get the first returned node in the jQuery collection.
            var barChart = new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartStackedData,
                options: barChartStackedOptions
            });
        }
    </script>
</body>

</html>