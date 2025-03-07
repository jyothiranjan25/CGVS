<!-- partial:partials/_settings-panel.html -->
<div class="theme-setting-wrapper">
    <div id="settings-trigger">
        <i class="typcn typcn-cog-outline"></i>
    </div>
    <div id="theme-settings" class="settings-panel">
        <i class="settings-close typcn typcn-delete-outline"></i>
        <p class="settings-heading">SIDEBAR SKINS</p>
        <div class="sidebar-bg-options" id="sidebar-light-theme">
            <div class="img-ss rounded-circle bg-light border mr-3"></div>
            Light
        </div>
        <div class="sidebar-bg-options selected" id="sidebar-dark-theme">
            <div class="img-ss rounded-circle bg-dark border mr-3"></div>
            Dark
        </div>
        <p class="settings-heading mt-2">HEADER SKINS</p>
        <div class="color-tiles mx-0 px-4">
            <div class="tiles success"></div>
            <div class="tiles warning"></div>
            <div class="tiles danger"></div>
            <div class="tiles primary"></div>
            <div class="tiles info"></div>
            <div class="tiles dark"></div>
            <div class="tiles default border"></div>
        </div>
    </div>
</div>
<!-- partial -->

<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <div class="d-flex sidebar-profile">
                <div class="sidebar-profile-image">
                    <img src="../images/EF-icon.png" alt="image" />
                    <span class="sidebar-status-indicator"></span>
                </div>
                <div class="sidebar-profile-name">
                    <p class="sidebar-name"><?php echo $_SESSION['login_user_name'] ?></p>
                    <p class="sidebar-designation">Welcome</p>
                </div>
            </div>
            <p class="sidebar-menu-title">Dash menu</p>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./index.php">
                <i class="typcn typcn-device-desktop menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <!-- <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false"
                aria-controls="form-elements">
                <i class="typcn typcn-film menu-icon"></i>
                <span class="menu-title">Form elements</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="./forms/basic_elements.html">Basic Elements</a>
                    </li>
                </ul>
            </div>
        </li> -->
        <li class="nav-item">
            <a class="nav-link" href="./students.php">
                <i class="typcn typcn-user-add menu-icon"></i>
                <span class="menu-title">Students</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./courses.php">
                <i class="typcn typcn-document-add menu-icon"></i>
                <span class="menu-title">Courses</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./modules.php">
                <i class="typcn typcn-document-add menu-icon"></i>
                <span class="menu-title">Modules</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./projects.php">
                <i class="typcn typcn-document-add menu-icon"></i>
                <span class="menu-title">Projects</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./certificates.php">
                <i class="typcn typcn-document-add menu-icon"></i>
                <span class="menu-title">Certificates</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="./certificateVerification.php">
                <i class="typcn typcn-document-add menu-icon"></i>
                <span class="menu-title">Certificate Verification</span>
            </a>
        </li>
    </ul>
</nav>
<!-- partial -->