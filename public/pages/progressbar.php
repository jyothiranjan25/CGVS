<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CelestialUI Admin</title>
    <!-- base:css -->
    <link rel="stylesheet" href="../vendors/typicons.font/font/typicons.css">
    <link rel="stylesheet" href="../vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../css/vertical-layout-light/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="../images/favicon.png" />
</head>

<body>
    <div class="container-scroller">
        <!-- partial:../../partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo" href="../../index.html"><img src="../../../assets/images/logo.svg" alt="logo" /></a>
                <a class="navbar-brand brand-logo-mini" href="../../index.html"><img src="../../../assets/images/logo-mini.svg" alt="logo" /></a>
                <button class="navbar-toggler navbar-toggler align-self-center d-none d-lg-flex" type="button" data-bs-toggle="minimize">
                    <span class="typcn typcn-th-menu"></span>
                </button>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <ul class="navbar-nav me-lg-2">
                    <li class="nav-item  d-none d-lg-flex">
                        <a class="nav-link" href="#">
                            Calendar
                        </a>
                    </li>
                    <li class="nav-item  d-none d-lg-flex">
                        <a class="nav-link active" href="#">
                            Statistic
                        </a>
                    </li>
                    <li class="nav-item  d-none d-lg-flex">
                        <a class="nav-link" href="#">
                            Employee
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item d-none d-lg-flex  me-2">
                        <a class="nav-link" href="#">
                            Help
                        </a>
                    </li>
                    <li class="nav-item dropdown d-flex">
                        <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="messageDropdown" href="#" data-bs-toggle="dropdown">
                            <i class="typcn typcn-message-typing"></i>
                            <span class="count bg-success">2</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                            <p class="mb-0 fw-normal float-start dropdown-header">Messages</p>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <img src="../../../assets/images/faces/face4.jpg" alt="image" class="profile-pic">
                                </div>
                                <div class="preview-item-content flex-grow">
                                    <h6 class="preview-subject ellipsis fw-normal">David Grey
                                    </h6>
                                    <p class="fw-light small-text mb-0">
                                        The meeting is cancelled
                                    </p>
                                </div>
                            </a>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <img src="../../../assets/images/faces/face2.jpg" alt="image" class="profile-pic">
                                </div>
                                <div class="preview-item-content flex-grow">
                                    <h6 class="preview-subject ellipsis fw-normal">Tim Cook
                                    </h6>
                                    <p class="fw-light small-text mb-0">
                                        New product launch
                                    </p>
                                </div>
                            </a>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <img src="../../../assets/images/faces/face3.jpg" alt="image" class="profile-pic">
                                </div>
                                <div class="preview-item-content flex-grow">
                                    <h6 class="preview-subject ellipsis fw-normal"> Johnson
                                    </h6>
                                    <p class="fw-light small-text mb-0">
                                        Upcoming board meeting
                                    </p>
                                </div>
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown  d-flex">
                        <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                            <i class="typcn typcn-bell me-0"></i>
                            <span class="count bg-danger">2</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                            <p class="mb-0 fw-normal float-start dropdown-header">Notifications</p>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-success">
                                        <i class="typcn typcn-info-large mx-0"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject fw-normal">Application Error</h6>
                                    <p class="fw-light small-text mb-0">
                                        Just now
                                    </p>
                                </div>
                            </a>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-warning">
                                        <i class="typcn typcn-cog mx-0"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject fw-normal">Settings</h6>
                                    <p class="fw-light small-text mb-0">
                                        Private message
                                    </p>
                                </div>
                            </a>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-info">
                                        <i class="typcn typcn-user-outline mx-0"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject fw-normal">New user registration</h6>
                                    <p class="fw-light small-text mb-0">
                                        2 days ago
                                    </p>
                                </div>
                            </a>
                        </div>
                    </li>
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle  pl-0 pr-0" href="#" data-bs-toggle="dropdown" id="profileDropdown">
                            <i class="typcn typcn-user-outline me-0"></i>
                            <span class="nav-profile-name">Evan Morales</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                            <a class="dropdown-item">
                                <i class="typcn typcn-cog text-primary"></i>
                                Settings
                            </a>
                            <a class="dropdown-item">
                                <i class="typcn typcn-power text-primary"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
                    <span class="typcn typcn-th-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:../../partials/_settings-panel.html -->
            <div class="theme-setting-wrapper">
                <div id="cta-trigger">
                    <div class="cta-img">
                        <img src="../../../assets/images/crown-black.svg" alt="bootstrapdash-crown" class="crown-black" />
                        <img src="../../../assets/images/crown-white.svg" alt="bootstrapdash-crown" class="crown-white cta-hover" />
                    </div>
                    <div class="cta-text mt-2">
                        <p class="text-black fw-bold">
                            <a href="https://www.bootstrapdash.com/product/celestial-admin-template" target="_blank" class="text-black"> Upgrade to Pro </a>
                        </p>
                    </div>
                </div>
                <div id="settings-trigger"><i class="typcn typcn-cog-outline"></i></div>
                <div id="theme-settings" class="settings-panel">
                    <i class="settings-close typcn typcn-delete-outline"></i>
                    <p class="settings-heading">SIDEBAR SKINS</p>
                    <div class="sidebar-bg-options" id="sidebar-light-theme">
                        <div class="img-ss rounded-circle bg-light border me-3"></div>
                        Light
                    </div>
                    <div class="sidebar-bg-options selected" id="sidebar-dark-theme">
                        <div class="img-ss rounded-circle bg-dark border me-3"></div>
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
            <!-- partial:../../partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item">
                        <div class="d-flex sidebar-profile">
                            <div class="sidebar-profile-image">
                                <img src="../../../assets/images/faces/face29.png" alt="image">
                                <span class="sidebar-status-indicator"></span>
                            </div>
                            <div class="sidebar-profile-name">
                                <p class="sidebar-name">
                                    Kenneth Osborne
                                </p>
                                <p class="sidebar-designation">
                                    Welcome
                                </p>
                            </div>
                        </div>
                        <div class="nav-search">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Type to search..." aria-label="search" aria-describedby="search">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="search">
                                        <i class="typcn typcn-zoom"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <p class="sidebar-menu-title">Dash menu</p>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../index.html">
                            <i class="typcn typcn-device-desktop menu-icon"></i>
                            <span class="menu-title">Dashboard <span class="badge badge-primary ms-3">New</span></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#layouts" aria-expanded="false" aria-controls="layouts">
                            <i class="menu-icon mdi mdi-page-layout-body"></i>
                            <span class="menu-title">Layouts</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="layouts">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    <a href="https://demo.bootstrapdash.com/celestial/themes/vertical-default-light/"
                                        onclick="event.preventDefault(); redirection('https://demo.bootstrapdash.com/celestial/themes/vertical-default-light/')"
                                        class="nav-link">
                                        Vertical Light
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="https://demo.bootstrapdash.com/celestial/themes/vertical-default-dark/"
                                        onclick="event.preventDefault(); redirection('https://demo.bootstrapdash.com/celestial/themes/vertical-default-dark/')"
                                        class="nav-link">
                                        Vertical Dark
                                    </a>
                                    <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span>
                                </li>
                                <li class="nav-item">
                                    <a href="https://demo.bootstrapdash.com/celestial/themes/horizontal-default-light/"
                                        onclick="event.preventDefault(); redirection('https://demo.bootstrapdash.com/celestial/themes/horizontal-default-light/')"
                                        class="nav-link">
                                        Horizontal Light
                                    </a>
                                    <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span>
                                </li>
                                <li class="nav-item">
                                    <a href="https://demo.bootstrapdash.com/celestial/themes/horizontal-default-dark/"
                                        onclick="event.preventDefault(); redirection('https://demo.bootstrapdash.com/celestial/themes/horizontal-default-dark/')"
                                        class="nav-link">
                                        Horizontal Dark
                                    </a>
                                    <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span>
                                </li>
                                <li class="nav-item">
                                    <a href="https://demo.bootstrapdash.com/celestial/themes/vertical-dark-sidebar/"
                                        onclick="event.preventDefault(); redirection('https://demo.bootstrapdash.com/celestial/themes/vertical-dark-sidebar/')"
                                        class="nav-link">
                                        Dark Menu
                                    </a>
                                    <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span>
                                </li>
                                <li class="nav-item">
                                    <a href="https://demo.bootstrapdash.com/celestial/themes/vertical-boxed/"
                                        onclick="event.preventDefault(); redirection('https://demo.bootstrapdash.com/celestial/themes/vertical-boxed/')"
                                        class="nav-link">
                                        Vertical Boxed
                                    </a>
                                    <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span>
                                </li>
                                <li class="nav-item">
                                    <a href="https://demo.bootstrapdash.com/celestial/themes/vertical-compact/"
                                        onclick="event.preventDefault(); redirection('https://demo.bootstrapdash.com/celestial/themes/vertical-compact/')"
                                        class="nav-link">
                                        Vertical Compact
                                    </a>
                                    <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span>
                                </li>
                                <li class="nav-item">
                                    <a href="https://demo.bootstrapdash.com/celestial/themes/vertical-fixed/"
                                        onclick="event.preventDefault(); redirection('https://demo.bootstrapdash.com/celestial/themes/vertical-fixed/')"
                                        class="nav-link">
                                        Vertical Fixed
                                    </a>
                                    <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span>
                                </li>
                                <li class="nav-item">
                                    <a href="https://demo.bootstrapdash.com/celestial/themes/vertical-hidden-toggle/"
                                        onclick="event.preventDefault(); redirection('https://demo.bootstrapdash.com/celestial/themes/vertical-hidden-toggle/')"
                                        class="nav-link">
                                        Sidebar Overlay </a><span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span>
                                </li>
                                <li class="nav-item">
                                    <a href="https://demo.bootstrapdash.com/celestial/themes/vertical-icon-menu/"
                                        onclick="event.preventDefault(); redirection('https://demo.bootstrapdash.com/celestial/themes/vertical-icon-menu/')"
                                        class="nav-link">
                                        Vertical Icon
                                    </a>
                                    <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span>
                                </li>
                                <li class="nav-item">
                                    <a href="https://demo.bootstrapdash.com/celestial/themes/vertical-toggle-overlay/"
                                        onclick="event.preventDefault(); redirection('https://demo.bootstrapdash.com/celestial/themes/vertical-toggle-overlay/')"
                                        class="nav-link">
                                        Vertical Toggle
                                    </a>
                                    <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../pages/widgets/widgets.html">
                            <i class="typcn typcn-archive menu-icon"></i>
                            <span class="menu-title">Widgets</span>
                            <span class="badge badge-outline-primary rounded fw-bold"> PRO </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                            <i class="typcn typcn-briefcase menu-icon"></i>
                            <span class="menu-title">UI Elements</span>
                            <i class="typcn typcn-chevron-right menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="../../pages/ui-features/accordions.html">Accordions</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/ui-features/buttons.html">Buttons</a></li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/ui-features/badges.html">Badges</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/ui-features/breadcrumbs.html">Breadcrumbs</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/ui-features/dropdowns.html">Dropdowns</a></li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/ui-features/modals.html">Modals</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/ui-features/progress.html">Progress bar</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/ui-features/pagination.html">Pagination</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/ui-features/tabs.html">Tabs</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/ui-features/typography.html">Typography</a></li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/ui-features/tooltips.html">Tooltips</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-advanced" aria-expanded="false" aria-controls="ui-advanced">
                            <i class="typcn typcn-cog-outline menu-icon"></i>
                            <span class="menu-title">Advanced UI</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-advanced">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="../../pages/ui-features/dragula.html">Dragula</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/ui-features/clipboard.html">Clipboard</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/ui-features/context-menu.html">Context menu</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/ui-features/slider.html">Sliders</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/ui-features/carousel.html">Carousel</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/ui-features/colcade.html">Colcade</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/ui-features/loaders.html">Loaders</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/ui-features/treeview.html">Tree View</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
                            <i class="typcn typcn-film menu-icon"></i>
                            <span class="menu-title">Form elements</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="form-elements">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"><a class="nav-link" href="../../pages/forms/basic_elements.html">Basic Elements</a></li>
                                <li class="nav-item"><a class="nav-link" href="../../pages/forms/advanced_elements.html">Advanced Elements</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"><a class="nav-link" href="../../pages/forms/validation.html">Validation</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"><a class="nav-link" href="../../pages/forms/wizard.html">Wizard</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#editors" aria-expanded="false" aria-controls="editors">
                            <i class="typcn typcn-point-of-interest-outline menu-icon"></i>
                            <span class="menu-title">Editors</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="editors">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"><a class="nav-link" href="../../pages/forms/text_editor.html">Text editors</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"><a class="nav-link" href="../../pages/forms/code_editor.html">Code editors</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
                            <i class="typcn typcn-chart-pie-outline menu-icon"></i>
                            <span class="menu-title">Charts</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="charts">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="../../pages/charts/chartjs.html">ChartJs</a></li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/charts/morris.html">Morris</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/charts/flot-chart.html">Flot</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/charts/google-charts.html">Google charts</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/charts/sparkline.html">Sparkline js</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/charts/c3.html">C3 charts</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/charts/chartist.html">Chartists</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/charts/justGage.html">JustGage</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
                            <i class="typcn typcn-th-small-outline menu-icon"></i>
                            <span class="menu-title">Tables</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="tables">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="../../pages/tables/basic-table.html">Basic table</a></li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/tables/data-table.html">Data table</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/tables/js-grid.html">Js-grid</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/tables/sortable-table.html">Sortable table</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../pages/ui-features/popups.html">
                            <i class="typcn typcn-radar-outline menu-icon"></i>
                            <span class="menu-title">Popups</span>
                            <span class="badge badge-outline-primary rounded fw-bold"> PRO </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../pages/ui-features/notifications.html">
                            <i class="typcn typcn-bell menu-icon"></i>
                            <span class="menu-title">Notifications</span>
                            <span class="badge badge-outline-primary rounded fw-bold"> PRO </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
                            <i class="typcn typcn-compass menu-icon"></i>
                            <span class="menu-title">Icons</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="icons">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="../../pages/icons/flag-icons.html">Flag icons</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/icons/font-awesome.html">Font Awesome</a></li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/icons/simple-line-icon.html">Simple line icons</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/icons/themify.html">Themify icons</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>

                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#maps" aria-expanded="false" aria-controls="maps">
                            <i class="typcn typcn-map menu-icon"></i>
                            <span class="menu-title">Maps</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="maps">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="../../pages/maps/mapael.html">Mapael</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/maps/vector-map.html">Vector Map</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/maps/google-maps.html">Google Map</a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                            <i class="typcn typcn-user-add-outline menu-icon"></i>
                            <span class="menu-title">User Pages</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="auth">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/login.html"> Login </a></li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/login-2.html"> Login 2 </a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/multi-level-login.html"> Multi Step Login </a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/register.html"> Register </a></li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/register-2.html"> Register 2 </a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/lock-screen.html"> Lockscreen </a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#error" aria-expanded="false" aria-controls="error">
                            <i class="typcn typcn-globe-outline menu-icon"></i>
                            <span class="menu-title">Error pages</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="error">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/error-404.html"> 404 </a></li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/error-500.html"> 500 </a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#general-pages" aria-expanded="false" aria-controls="general-pages">
                            <i class="typcn typcn-document-delete menu-icon"></i>
                            <span class="menu-title">General Pages</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="general-pages">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/blank-page.html"> Blank Page </a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/profile.html"> Profile </a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/faq.html"> FAQ </a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/faq-2.html"> FAQ 2 </a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/news-grid.html"> News grid </a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/timeline.html"> Timeline </a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/search-results.html"> Search Results </a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/portfolio.html"> Portfolio </a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/user-listing.html"> User Listing </a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#e-commerce" aria-expanded="false" aria-controls="e-commerce">
                            <i class="typcn typcn-briefcase menu-icon"></i>
                            <span class="menu-title">E-commerce</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="e-commerce">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/invoice.html"> Invoice </a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/pricing-table.html"> Pricing Table </a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/orders.html"> Orders </a> <span class="mdi mdi-crown-circle fs-4 bg-custom-warning"></span> </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../pages/apps/email.html">
                            <i class="typcn typcn-mail menu-icon"></i>
                            <span class="menu-title">E-mail</span>
                            <span class="badge badge-outline-primary rounded fw-bold"> PRO </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../pages/apps/calendar.html">
                            <i class="typcn typcn-calendar-outline menu-icon"></i>
                            <span class="menu-title">Calendar </span>
                            <span class="badge badge-outline-primary rounded fw-bold"> PRO </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../pages/apps/todo.html">
                            <i class="typcn typcn-device-phone menu-icon"></i>
                            <span class="menu-title">Todo List</span>
                            <span class="badge badge-outline-primary rounded fw-bold"> PRO </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../pages/apps/gallery.html">
                            <i class="typcn typcn-image menu-icon"></i>
                            <span class="menu-title">Gallery</span>
                            <span class="badge badge-outline-primary rounded fw-bold"> PRO </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../pages/apps/kanban-board.html">
                            <i class="typcn typcn-th-small-outline menu-icon"></i>
                            <span class="menu-title">kanban Board</span>
                            <span class="badge badge-outline-primary rounded fw-bold"> PRO </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../pages/apps/tickets.html">
                            <i class="typcn typcn-business-card menu-icon"></i>
                            <span class="menu-title">Tickets</span>
                            <span class="badge badge-outline-primary rounded fw-bold"> PRO </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../pages/apps/chat.html">
                            <i class="typcn typcn-messages menu-icon"></i>
                            <span class="menu-title">Chat</span>
                            <span class="badge badge-outline-primary rounded fw-bold"> PRO </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../pages/documentation/documentation.html">
                            <i class="typcn typcn-document-text menu-icon"></i>
                            <span class="menu-title">Documentation</span>
                        </a>
                    </li>
                </ul>
                <ul class="sidebar-legend">
                    <li>
                        <p class="sidebar-menu-title">Category</p>
                    </li>
                    <li class="nav-item"><a href="#" class="nav-link">#Sales</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">#Marketing</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">#Growth</a></li>
                </ul>
                <div class="sidebar-cta">
                    <!-- <img src="../../../assets/images/crown-white.svg" alt=""> -->
                    <span class="mdi mdi-crown-circle fs-1 text-white"></span>
                    <p class="text-white fw-semibold"> Claim the Crown <br> Get Premium Features! </p>
                    <button>
                        <a href="https://www.bootstrapdash.com/product/celestial-admin-template" target="_blank"> UPGRADE NOW </a>
                    </button>
                </div>
            </nav>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Normal Progressbar</h4>
                                    <p class="card-description">Basic bootstrap progress bars</p>
                                    <div class="template-demo">
                                        <div class="progress progress-md">
                                            <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="progress progress-md">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="progress progress-md">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="progress progress-md">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="progress progress-md">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Colored Progressbar</h4>
                                    <p class="card-description">You can give bootstrap colors to progress bars</p>
                                    <div class="template-demo">
                                        <div class="progress progress-md">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="progress progress-md">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="progress progress-md">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="progress progress-md">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="progress progress-md">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Progressbar Striped</h4>
                                    <p class="card-description">Use class <code>.progress-bar-striped</code></p>
                                    <div class="template-demo">
                                        <div class="progress progress-md">
                                            <div class="progress-bar bg-danger progress-bar-striped" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="progress progress-md">
                                            <div class="progress-bar bg-warning progress-bar-striped" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="progress progress-md">
                                            <div class="progress-bar bg-info progress-bar-striped" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="progress progress-md">
                                            <div class="progress-bar bg-primary progress-bar-striped" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="progress progress-md">
                                            <div class="progress-bar bg-success progress-bar-striped" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Striped Animated</h4>
                                    <p class="card-description">Use class<code>progress-bar-striped progress-bar-animated</code></p>
                                    <div class="template-demo">
                                        <div class="progress progress-md">
                                            <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="progress progress-md">
                                            <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="progress progress-md">
                                            <div class="progress-bar bg-info progress-bar-striped progress-bar-animated" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="progress progress-md">
                                            <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="progress progress-md">
                                            <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">With Label</h4>
                                    <p class="card-description">Progress bar with labels</p>
                                    <div class="template-demo">
                                        <div class="d-flex justify-content-between">
                                            <small>Filled percentage</small>
                                            <small>60%</small>
                                        </div>
                                        <div class="progress progress-lg mt-2">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">60%</div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-2">
                                            <small>Photoshop</small>
                                        </div>
                                        <div class="progress progress-lg mt-2">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="progress progress-lg">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">60% completed</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Progressbar Sizes</h4>
                                    <p class="card-description">Add class <code>progress-{size}</code></p>
                                    <div class="template-demo">
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="progress progress-md">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="progress progress-lg">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="progress progress-xl">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 grid-margin grid-margin-md-0 stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Circle progress bar</h4>
                                    <div class="row px-2 template-demo">
                                        <div class="col-sm-3 col-md-4 col-6 circle-progress-block">
                                            <div id="circleProgress1" class="progressbar-js-circle border rounded p-3"></div>
                                        </div>
                                        <div class="col-sm-3 col-md-4 col-6 circle-progress-block">
                                            <div id="circleProgress2" class="progressbar-js-circle border rounded p-3"></div>
                                        </div>
                                        <div class="col-sm-3 col-md-4 col-6 circle-progress-block">
                                            <div id="circleProgress3" class="progressbar-js-circle border rounded p-3"></div>
                                        </div>
                                        <div class="col-sm-3 col-md-4 col-6 circle-progress-block">
                                            <div id="circleProgress4" class="progressbar-js-circle border rounded p-3"></div>
                                        </div>
                                        <div class="col-sm-3 col-md-4 col-6 circle-progress-block">
                                            <div id="circleProgress5" class="progressbar-js-circle border rounded p-3"></div>
                                        </div>
                                        <div class="col-sm-3 col-md-4 col-6 circle-progress-block">
                                            <div id="circleProgress6" class="progressbar-js-circle border rounded p-3"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 grid-margin grid-margin-md-0 stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Skill Bars</h4>
                                    <div class="template-demo">
                                        <div class="d-flex justify-content-between mt-2">
                                            <small>Photoshop</small>
                                            <small>90%</small>
                                        </div>
                                        <div class="progress progress-sm mt-2">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-3">
                                            <small>After effects</small>
                                            <small>68%</small>
                                        </div>
                                        <div class="progress progress-sm mt-2">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 68%" aria-valuenow="68" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-3">
                                            <small>Flash</small>
                                            <small>55%</small>
                                        </div>
                                        <div class="progress progress-sm mt-2">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-3">
                                            <small>Illustrator</small>
                                            <small>35%</small>
                                        </div>
                                        <div class="progress progress-sm mt-2">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-3">
                                            <small>Corel Draw</small>
                                            <small>85%</small>
                                        </div>
                                        <div class="progress progress-sm mt-2">
                                            <div class="progress-bar bg-dark" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-3">
                                            <small>Dreamweaver</small>
                                            <small>75%</small>
                                        </div>
                                        <div class="progress progress-sm mt-2">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:../../partials/_footer.html -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-center text-sm-left d-block d-sm-inline-block">Copyright © 2024 <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrapdash</a>. All rights reserved.</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="typcn typcn-heart text-danger"></i></span>
                    </div>
                </footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- base:js -->
    <script src="../vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="../js/off-canvas.js"></script>
    <script src="../js/hoverable-collapse.js"></script>
    <script src="../js/template.js"></script>
    <script src="../js/settings.js"></script>
    <script src="../js/todolist.js"></script>
    <!-- endinject -->
    <!-- plugin js for this page -->
    <script src="../vendors/progressbar.js/progressbar.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- Custom js for this page-->
    <script src="../js/progress-bar.js"></script>
    <!-- End custom js for this page-->
</body>

</html>