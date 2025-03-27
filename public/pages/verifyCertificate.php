<?php
// include database context file and other required
include_once("../../config/dbconfig.php");
include_once($Base_Path . "/public/code/Queries.php");

if (!isset($_REQUEST['verify'])) {
    $QUERY_STRING = $_SERVER['QUERY_STRING'];
    $Registration_No = explode("&", $QUERY_STRING);
    $Registration_No = $Registration_No[0];
    $Redirect_URL = $Extract_File_name . "?registration_number=$Registration_No&verify=true";
    header("Location: $Redirect_URL");
}

if (isset($_REQUEST['verify'])) {
    try {
        $reqistration_no = mysqli_real_escape_string($conn, trim($_REQUEST['registration_number']));
        $certificate = getverificationDetailsByRegNo($reqistration_no);

        $certificateId = $certificate['id'];
        $registration_number = $certificate['registration_number'];
        $Student_Name = $certificate['full_name'];
        $Course_Name = $certificate['course_name'];
        $Course_Duration = $certificate['duration'];
        $Course_Evaluation_Methodology = $certificate['evaluation_methodology'];
        $Completion_Date = $certificate['completion_date'];
        $Modules_Covered = $certificate['modules_covered'];
        $projects = $certificate['projects'];

        // get certificate path
        $certificatePath = getcertificatePath($Student_Name, $reqistration_no);
        if (file_exists($certificatePath['path'])) {
            $certificateExists = true;
            $certificateUrl = $certificatePath['url'];
        } else if ($registration_number != null) {
            $certificateExists = true;
            $start_date = $certificate['start_date'];
            $end_date = $certificate['end_date'];
            $qr_code = $certificate['qr_code'];
            $certificateUrl = generateCertificate($registration_number, $Student_Name, $start_date, $end_date, $Course_Name, $qr_code);
            $certificateUrl = $certificatePath['url'];
        }

        // insert data in certificate verification table
        if ($certificate && $certificateExists) {
            // store data in database
            $ipAddress = $_SERVER['REMOTE_ADDR'];
            $customColumns = ['certificate_id' => $certificateId, 'AND', 'ip_address' => $ipAddress];
            $checkData = getCertificateVerificationByCustomColumns($customColumns, false);
            $checkData = $checkData['created_at'];
            $createdAt = date('Y-m-d H:i:s', strtotime($checkData));
            $checkTime = date('Y-m-d H:i:s', strtotime('-30 minutes'));
            if ($checkData == false || $createdAt < $checkTime) {
                $storeData = insertCertificateVerification($certificateId, $ipAddress);
            }
        }

        $share_url = $Base_Path_URL . "verifyCertificate.php?$registration_number";
        $title = "Certificate Verification - Edflix";
        $description = "Verify and authenticate course completion certificates.";
        $image = $certificateUrl;
        $url = urlencode("https://" . $share_url);
    } catch (Exception $e) {
        CatchErrorLogs($e, null);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- css -->
    <link rel="stylesheet" href="../vendors/typicons.font/font/typicons.css" />
    <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css" />
    <link rel="stylesheet" href="../vendors/datatables.net-bs4/dataTables.bootstrap4.css" />
    <!-- inject:css -->
    <link rel="stylesheet" href="../css/vertical-layout-light/style.css" />
    <link rel="stylesheet" href="../css/butterup.min.css" />

    <!-- favicon -->
    <link rel="shortcut icon" href="../images/EF-icon.png" />

    <title>Certificate Verification</title>

    <!-- Test LinkedIn -->
    <meta property="og:title" content="Certificate Verification - Edflix" />
    <meta property="og:description" content="Verify and authenticate course completion certificates for <?php echo htmlentities($Student_Name); ?>." />
    <meta property="og:image" content="<?= htmlentities($certificateUrl); ?>" />
    <meta property="og:url" content="https://<?= htmlentities($share_url); ?>" />
    <meta property="og:type" content="website" />
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center">
                <a class="navbar-brand brand-logo"><img src="../images/EF-logo.png" alt="logo" /></a>
                <a class="navbar-brand brand-logo-mini"><img src="../images/EF-icon.png" alt="logo" /></a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end"></div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel" style="width: 100%;">
                <?php if (isset($_REQUEST['verify']) && isset($_REQUEST['registration_number'])) {
                    if ($certificate && $certificateExists) {
                ?>
                        <div class="content-wrapper">
                            <div class="row">
                                <div class="col-lg-12 d-flex grid-margin stretch-card">
                                    <div class="card" style="min-height: calc(97vh - 100px);">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <h6 class="mb-3 font-weight-bold">Course Certificate</h6>
                                                    <p>
                                                    <h1 style="font-weight: 300;margin-top: 10px;margin-bottom: 50px;">
                                                        <?php echo $Course_Name; ?>
                                                    </h1>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="card" style="background-color: #d6edf6;">
                                                                <div class="card-body mb-4">
                                                                    <h2 class="mb-3 font-weight-bold">
                                                                        Completed by <?php echo $Student_Name; ?>
                                                                    </h2>

                                                                    <h3 class="mb-3 font-weight-bold">
                                                                        <?php echo date('F j, Y', strtotime($Completion_Date)); ?>
                                                                    </h3>

                                                                    <h3 class="mb-3 font-weight-bold">
                                                                        <?php echo $Course_Duration; ?> (approximately)
                                                                    </h3>

                                                                    <h4 class="mb-3 font-weight-bold">
                                                                        <?php echo $Student_Name; ?>'s
                                                                        account is verified. Edflix certifies their
                                                                        successful completion of
                                                                        <u><?php echo $Course_Name; ?></u>
                                                                    </h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="card-body">
                                                                <div class="mt-4">
                                                                    <label class="font-weight-bold">Share this
                                                                        Certificate</label>

                                                                    <div class="d-flex mb-3"
                                                                        style="gap: 20px;align-items: baseline;">
                                                                        <!-- LinkedIn Share Button -->
                                                                        <button type="button" class="btn btn-rounded btn-icon"
                                                                            onclick="shareOnLinkedin()">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" x="0px"
                                                                                y="0px" width="50" height="50"
                                                                                viewBox="0 0 48 48">
                                                                                <path fill="#0288D1"
                                                                                    d="M42,37c0,2.762-2.238,5-5,5H11c-2.761,0-5-2.238-5-5V11c0-2.762,2.239-5,5-5h26c2.762,0,5,2.238,5,5V37z">
                                                                                </path>
                                                                                <path fill="#FFF"
                                                                                    d="M12 19H17V36H12zM14.485 17h-.028C12.965 17 12 15.888 12 14.499 12 13.08 12.995 12 14.514 12c1.521 0 2.458 1.08 2.486 2.499C17 15.887 16.035 17 14.485 17zM36 36h-5v-9.099c0-2.198-1.225-3.698-3.192-3.698-1.501 0-2.313 1.012-2.707 1.99C24.957 25.543 25 26.511 25 27v9h-5V19h5v2.616C25.721 20.5 26.85 19 29.738 19c3.578 0 6.261 2.25 6.261 7.274L36 36 36 36z">
                                                                                </path>
                                                                            </svg>
                                                                        </button>

                                                                        <!-- Twitter/X Share Button -->
                                                                        <button type="button" class="btn btn-rounded btn-icon"
                                                                            onclick="shareOnFacebook()">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" x="0px"
                                                                                y="0px" width="50" height="50"
                                                                                viewBox="0 0 48 48">
                                                                                <path fill="#3F51B5"
                                                                                    d="M42,37c0,2.762-2.238,5-5,5H11c-2.761,0-5-2.238-5-5V11c0-2.762,2.239-5,5-5h26c2.762,0,5,2.238,5,5V37z">
                                                                                </path>
                                                                                <path fill="#FFF"
                                                                                    d="M34.368,25H31v13h-5V25h-3v-4h3v-2.41c0.002-3.508,1.459-5.59,5.592-5.59H35v4h-2.287C31.104,17,31,17.6,31,18.723V21h4L34.368,25z">
                                                                                </path>
                                                                            </svg>
                                                                        </button>

                                                                        <!-- Facebook Share Button -->
                                                                        <button type="button" class="btn btn-icon"
                                                                            onclick="shareOnTwitter()">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" x="0px"
                                                                                y="0px" width="50" height="50"
                                                                                viewBox="0 0 50 50">
                                                                                <path
                                                                                    d="M 11 4 C 7.134 4 4 7.134 4 11 L 4 39 C 4 42.866 7.134 46 11 46 L 39 46 C 42.866 46 46 42.866 46 39 L 46 11 C 46 7.134 42.866 4 39 4 L 11 4 z M 13.085938 13 L 21.023438 13 L 26.660156 21.009766 L 33.5 13 L 36 13 L 27.789062 22.613281 L 37.914062 37 L 29.978516 37 L 23.4375 27.707031 L 15.5 37 L 13 37 L 22.308594 26.103516 L 13.085938 13 z M 16.914062 15 L 31.021484 35 L 34.085938 35 L 19.978516 15 L 16.914062 15 z">
                                                                                </path>
                                                                            </svg>
                                                                        </button>

                                                                        <a href="<?php echo $certificateUrl; ?>" download
                                                                            class="btn btn btn-dark d-none d-sm-block">
                                                                            <i class="mdi mdi-download"></i> Download
                                                                            Certificate
                                                                        </a>


                                                                        <a href="<?php echo $certificateUrl; ?>" download
                                                                            class="btn btn-icon d-block d-sm-none">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" x="0px"
                                                                                y="0px" width="45" height="45"
                                                                                viewBox="0 0 24 24" fill="none"
                                                                                stroke="currentColor" stroke-width="2"
                                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                                <path
                                                                                    d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                                                                <polyline points="7 10 12 15 17 10" />
                                                                                <line x1="12" y1="15" x2="12" y2="3" />
                                                                            </svg>
                                                                        </a>
                                                                    </div>

                                                                    <div class="d-flex align-items-center mb-3">
                                                                        <input type="text" class="form-control"
                                                                            id="certificateUrl"
                                                                            value="<?php echo $share_url; ?>" readonly>
                                                                        <button class="btn  btn-dark ml-2" onclick="copyUrl()">
                                                                            <i class="mdi mdi-content-copy"></i> Copy
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <img src="<?php echo $certificateUrl; ?>" alt="Certificate"
                                                            width="100%">
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if ($projects || $Modules_Covered) { ?>
                                                <div class="row">
                                                    <?php if ($Modules_Covered) { ?>
                                                        <div class="col-lg-6 mb-4">
                                                            <div class="card h-100"> <!-- Ensures equal height -->
                                                                <div class="card-body d-flex flex-column">
                                                                    <!-- Makes content stretch -->
                                                                    <h3 class="mb-3 font-weight-bold">WHAT YOU WILL LEARN</h3>
                                                                    <div class="d-flex flex-wrap">
                                                                        <?php foreach ($Modules_Covered as $Modules) { ?>
                                                                            <div class="w-50 p-1"
                                                                                style="display: flex; align-items: flex-start; gap: 10px;">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                                                                    width="20" height="20" viewBox="0 0 48 48">
                                                                                    <path fill="#43A047"
                                                                                        d="M40.6 12.1L17 35.7 7.4 26.1 4.6 29 17 41.3 43.4 14.9z">
                                                                                    </path>
                                                                                </svg>
                                                                                <span class="font-weight-bold">
                                                                                    <?php echo htmlspecialchars($Modules['module_name']); ?>
                                                                                </span>
                                                                            </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                    <div class="mt-auto"></div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    <?php }
                                                    if ($projects) { ?>
                                                        <div class="col-lg-6 mb-4">

                                                            <div class="card h-100">
                                                                <div class="card-body d-flex flex-column">
                                                                    <!-- Makes content stretch -->
                                                                    <h3 class="mb-3 font-weight-bold">
                                                                        Projects Completed
                                                                    </h3>
                                                                    <div class="flex-grow-1">
                                                                        <?php foreach ($projects as $project) { ?>
                                                                            <ul>
                                                                                <li>
                                                                                    <h4 class="mb-3 font-weight-bold">
                                                                                        <?php echo $project['project_title']; ?>
                                                                                    </h4>
                                                                                    <?php if ($project['description']) { ?>
                                                                                        <p>
                                                                                            <?php echo $project['description']; ?>
                                                                                        </p>
                                                                                    <?php } ?>
                                                                                </li>
                                                                            </ul>
                                                                        <?php } ?>
                                                                    </div>
                                                                    <div class="mt-auto"></div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    <?php } ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="content-wrapper align-items-center text-center" style="align-content: center;">
                            <div class="row">
                                <div class="col-lg-12">
                                    <img src=" ../images/svg/404.svg" alt="Certificate" width="50%">
                                </div>
                            </div>
                        </div>
                    <?php }
                } else { ?>
                    <div class="content-wrapper align-items-center text-center" style="align-content: center;">
                        <div class="row">
                            <div class="col-lg-12">
                                <img src=" ../images/svg/400.svg" alt="Certificate" width="50%">
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
    </div>
    <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <script src="../vendors/js/vendor.bundle.base.js"></script>
    <script>
        function copyUrl() {
            var copyText = document.getElementById("certificateUrl");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            document.execCommand("copy");
        }
    </script>

    <script>
        function shareOnLinkedin() {
            window.open("https://www.linkedin.com/sharing/share-offsite/?url=<?= htmlentities($share_url); ?>", "_blank");
        }

        function shareOnFacebook() {
            window.open("https://www.facebook.com/sharer/sharer.php?u=<?= htmlentities($share_url); ?>", "_blank");
        }

        function shareOnTwitter() {
            window.open("https://twitter.com/intent/tweet?url=<?= htmlentities($share_url); ?>&text=Check out this verified certificate!", "_blank");
        }
    </script>
</body>

</html>