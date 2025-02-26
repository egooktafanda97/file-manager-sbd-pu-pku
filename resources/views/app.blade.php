<!DOCTYPE html>
<html data-layout="vertical" data-sidebar-image="none" data-sidebar-size="lg" data-sidebar="light" data-topbar="light"
    lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta
        content="Kanakku provides clean Admin Templates for managing Sales, Payment, Invoice, Accounts and Expenses in HTML, Bootstrap 5, ReactJs, Angular, VueJs and Laravel."
        name="description">
    <meta
        content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects"
        name="keywords">
    <meta content="Dreamguys - Bootstrap Admin Template" name="author">
    <!-- Twitter -->
    <meta content="summary_large_image" name="twitter:card">
    <meta content="@dreamstechnologies" name="twitter:site">
    <meta content="Finance & Accounting Admin Website Templates | Kanakku" name="twitter:title">
    <meta
        content="Kanakku is a Sales, Invoices & Accounts Admin template for Accountant or Companies/Offices with various features for all your needs. Try Demo and Buy Now."
        name="twitter:description">
    <meta content="https://kanakku.dreamstechnologies.com/assets/img/kanakku.jpg" name="twitter:image">
    <meta content="Kanakku" name="twitter:image:alt">

    <!-- Facebook -->
    <meta content="https://kanakku.dreamstechnologies.com/" property="og:url">
    <meta content="Finance & Accounting Admin Website Templates | Kanakku" property="og:title">
    <meta
        content="Kanakku is a Sales, Invoices & Accounts Admin template for Accountant or Companies/Offices with various features for all your needs. Try Demo and Buy Now."
        property="og:description">
    <meta content="https://kanakku.dreamstechnologies.com/assets/img/kanakku.jpg" property="og:image">
    <meta content="https://kanakku.dreamstechnologies.com/assets/img/kanakku.jpg" property="og:image:secure_url">
    <meta content="image/png" property="og:image:type">
    <meta content="1200" property="og:image:width">
    <meta content="600" property="og:image:height">
    <title>Kanakku - Bootstrap Admin HTML Template</title>

    <!-- Favicon -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="shortcut icon">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Font family -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Fontawesome CSS -->
    <link href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}" rel="stylesheet">

    <!-- Feather CSS -->
    <link href="{{ asset('assets/plugins/feather/feather.css') }}" rel="stylesheet">

    <!-- Datatables CSS -->
    <link href="{{ asset('assets/plugins/datatables/datatables.min.css') }}" rel="stylesheet">

    <!-- Main CSS -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <!-- Layout JS -->
    <script src="{{ asset('assets/js/layout.js') }}"></script>
    @livewireStyles
    {{-- vite --}}
    <link href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" rel="stylesheet" type="text/css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body>
    <!-- Main Wrapper -->
    <div class="main-wrapper">
        @livewire('layout.top-bar')
        @livewire('layout.sidebar')

        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <div class="content container-fluid">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="content-page-header">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Wrapper -->

    </div>
    <!-- /Main Wrapper -->

    <!--Theme Setting -->
    <div class="settings-icon">
        <span aria-controls="theme-settings-offcanvas" data-bs-target="#theme-settings-offcanvas"
            data-bs-toggle="offcanvas"><img alt="layout" class="feather-five"
                src="{{ asset('') }}assets/img/icons/siderbar-icon2.svg"></span>
    </div>
    <div class="offcanvas offcanvas-end border-0 " id="theme-settings-offcanvas" tabindex="-1">
        <div class="sidebar-headerset">
            <div class="sidebar-headersets">
                <h2>Customizer</h2>
                <h3>Customize your overview Page layout</h3>
            </div>
            <div class="sidebar-headerclose">
                <a aria-label="Close" data-bs-dismiss="offcanvas"><img alt="img" src="assets/img/close.png"></a>
            </div>
        </div>
        <div class="offcanvas-body p-0">
            <div class="h-100" data-simplebar>
                <div class="settings-mains">
                    <div class="layout-head">
                        <h5>Layout</h5>
                        <h6>Choose your layout</h6>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-check card-radio p-0">
                                <input class="form-check-input" id="customizer-layout01" name="data-layout"
                                    type="radio" value="vertical">
                                <label class="form-check-label avatar-md w-100" for="customizer-layout01">
                                    <img alt="img" src="assets/img/vertical.png">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Vertical</h5>
                        </div>
                        <div class="col-4">
                            <div class="form-check card-radio p-0">
                                <input class="form-check-input" id="customizer-layout02" name="data-layout"
                                    type="radio" value="horizontal">
                                <label class="form-check-label  avatar-md w-100" for="customizer-layout02">
                                    <img alt="img" src="assets/img/horizontal.png">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Horizontal</h5>
                        </div>
                        <div class="col-4 d-none">
                            <div class="form-check card-radio p-0">
                                <input class="form-check-input" id="customizer-layout03" name="data-layout"
                                    type="radio" value="twocolumn">
                                <label class="form-check-label  avatar-md w-100" for="customizer-layout03">
                                    <img alt="img" src="assets/img/two-col.png">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Two Column</h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between pt-3">
                        <div class="layout-head mb-0">
                            <h5>RTL Mode</h5>
                            <h6>Change Language Direction.</h6>
                        </div>
                        <div class="active-switch">
                            <div class="status-toggle">
                                <input class="check" id="rtl" type="checkbox">
                                <label class="checktoggle checkbox-bg" for="rtl">checkbox</label>
                            </div>
                        </div>
                    </div>
                    <div class="layout-head pt-3">
                        <h5>Color Scheme</h5>
                        <h6>Choose Light or Dark Scheme.</h6>
                    </div>
                    <div class="colorscheme-cardradio">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-check card-radio blue  p-0 ">
                                    <input class="form-check-input" id="layout-mode-blue" name="data-layout-mode"
                                        type="radio" value="blue">
                                    <label class="form-check-label  avatar-md w-100" for="layout-mode-blue">
                                        <img alt="img" src="assets/img/vertical.png">
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2 mb-2">Blue</h5>
                            </div>
                            <div class="col-4">
                                <div class="form-check card-radio p-0">
                                    <input class="form-check-input" id="layout-mode-light" name="data-layout-mode"
                                        type="radio" value="light">
                                    <label class="form-check-label  avatar-md w-100" for="layout-mode-light">
                                        <img alt="img" src="assets/img/vertical.png">
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2 mb-2">Light</h5>
                            </div>
                            <div class="col-4">
                                <div class="form-check card-radio dark  p-0 ">
                                    <input class="form-check-input" id="layout-mode-dark" name="data-layout-mode"
                                        type="radio" value="dark">
                                    <label class="form-check-label avatar-md w-100 " for="layout-mode-dark">
                                        <img alt="img" src="assets/img/vertical.png">
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2 mb-2">Dark</h5>
                            </div>
                            <div class="col-4 d-none">
                                <div class="form-check card-radio p-0">
                                    <input class="form-check-input" id="layout-mode-orange" name="data-layout-mode"
                                        type="radio" value="orange">
                                    <label class="form-check-label  avatar-md w-100 " for="layout-mode-orange">
                                        <img alt="img" src="assets/img/vertical.png">
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2 mb-2">Orange</h5>
                            </div>
                            <div class="col-4 d-none">
                                <div class="form-check card-radio maroon p-0">
                                    <input class="form-check-input" id="layout-mode-maroon" name="data-layout-mode"
                                        type="radio" value="maroon">
                                    <label class="form-check-label  avatar-md w-100 " for="layout-mode-maroon">
                                        <img alt="img" src="assets/img/vertical.png">
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2 mb-2">Brink Pink</h5>
                            </div>
                            <div class="col-4 d-none">
                                <div class="form-check card-radio purple p-0">
                                    <input class="form-check-input" id="layout-mode-purple" name="data-layout-mode"
                                        type="radio" value="purple">
                                    <label class="form-check-label  avatar-md w-100 " for="layout-mode-purple">
                                        <img alt="img" src="assets/img/vertical.png">
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2 mb-2">Green</h5>
                            </div>
                        </div>
                    </div>

                    <div id="layout-width">
                        <div class="layout-head pt-3">
                            <h5>Layout Width</h5>
                            <h6>Choose Fluid or Boxed layout.</h6>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-check card-radio p-0">
                                    <input class="form-check-input" id="layout-width-fluid" name="data-layout-width"
                                        type="radio" value="fluid">
                                    <label class="form-check-label avatar-md w-100" for="layout-width-fluid">
                                        <img alt="img" src="assets/img/vertical.png">
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Fluid</h5>
                            </div>
                            <div class="col-4">
                                <div class="form-check card-radio p-0 ">
                                    <input class="form-check-input" id="layout-width-boxed" name="data-layout-width"
                                        type="radio" value="boxed">
                                    <label class="form-check-label avatar-md w-100 px-2" for="layout-width-boxed">
                                        <img alt="img" src="assets/img/boxed.png">
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Boxed</h5>
                            </div>
                        </div>
                    </div>

                    <div class="d-none" id="layout-position">
                        <div class="layout-head pt-3">
                            <h5>Layout Position</h5>
                            <h6>Choose Fixed or Scrollable Layout Position.</h6>
                        </div>
                        <div class="btn-group bor-rad-50 overflow-hidden radio" role="group">
                            <input class="btn-check" id="layout-position-fixed" name="data-layout-position"
                                type="radio" value="fixed">
                            <label class="btn btn-light w-sm" for="layout-position-fixed">Fixed</label>

                            <input class="btn-check" id="layout-position-scrollable" name="data-layout-position"
                                type="radio" value="scrollable">
                            <label class="btn btn-light w-sm ms-0" for="layout-position-scrollable">Scrollable</label>
                        </div>
                    </div>
                    <div class="layout-head pt-3">
                        <h5>Topbar Color</h5>
                        <h6>Choose Light or Dark Topbar Color.</h6>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-check card-radio  p-0">
                                <input class="form-check-input" id="topbar-color-light" name="data-topbar"
                                    type="radio" value="light">
                                <label class="form-check-label avatar-md w-100" for="topbar-color-light">
                                    <img alt="img" src="assets/img/vertical.png">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Light</h5>
                        </div>
                        <div class="col-4">
                            <div class="form-check card-radio p-0">
                                <input class="form-check-input" id="topbar-color-dark" name="data-topbar"
                                    type="radio" value="dark">
                                <label class="form-check-label  avatar-md w-100" for="topbar-color-dark">
                                    <img alt="img" src="assets/img/dark.png">
                                </label>
                            </div>
                            <h5 class="fs-13 text-center mt-2">Dark</h5>
                        </div>
                    </div>

                    <div id="sidebar-size">
                        <div class="layout-head pt-3">
                            <h5>Sidebar Size</h5>
                            <h6>Choose a size of Sidebar.</h6>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-check sidebar-setting card-radio  p-0 ">
                                    <input class="form-check-input" id="sidebar-size-default"
                                        name="data-sidebar-size" type="radio" value="lg">
                                    <label class="form-check-label avatar-md w-100" for="sidebar-size-default">
                                        <img alt="img" src="assets/img/vertical.png">
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Default</h5>
                            </div>

                            <div class="col-4 d-none">
                                <div class="form-check sidebar-setting card-radio p-0">
                                    <input class="form-check-input" id="sidebar-size-compact"
                                        name="data-sidebar-size" type="radio" value="md">
                                    <label class="form-check-label  avatar-md w-100" for="sidebar-size-compact">
                                        <img alt="img" src="assets/img/compact.png">
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Compact</h5>
                            </div>

                            <div class="col-4">
                                <div class="form-check sidebar-setting card-radio p-0 ">
                                    <input class="form-check-input" id="sidebar-size-small-hover"
                                        name="data-sidebar-size" type="radio" value="sm-hover">
                                    <label class="form-check-label avatar-md w-100" for="sidebar-size-small-hover">
                                        <img alt="img" src="assets/img/small-hover.png">
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Small Sidebar</h5>
                            </div>
                        </div>
                    </div>

                    <div id="sidebar-view">
                        <div class="layout-head pt-3">
                            <h5>Sidebar View</h5>
                            <h6>Choose Default or Detached Sidebar view.</h6>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-check sidebar-setting card-radio  p-0">
                                    <input class="form-check-input" id="sidebar-view-default"
                                        name="data-layout-style" type="radio" value="default">
                                    <label class="form-check-label avatar-md w-100" for="sidebar-view-default">
                                        <img alt="img" src="assets/img/compact.png">
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Default</h5>
                            </div>
                            <div class="col-4">
                                <div class="form-check sidebar-setting card-radio p-0">
                                    <input class="form-check-input" id="sidebar-view-detached"
                                        name="data-layout-style" type="radio" value="detached">
                                    <label class="form-check-label  avatar-md w-100" for="sidebar-view-detached">
                                        <img alt="img" src="assets/img/detached.png">
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Detached</h5>
                            </div>
                        </div>
                    </div>
                    <div id="sidebar-color">
                        <div class="layout-head pt-3">
                            <h5>Sidebar Color</h5>
                            <h6>Choose a color of Sidebar.</h6>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-check sidebar-setting card-radio p-0"
                                    data-bs-target="#collapseBgGradient.show" data-bs-toggle="collapse">
                                    <input class="form-check-input" id="sidebar-color-light" name="data-sidebar"
                                        type="radio" value="light">
                                    <label class="form-check-label  avatar-md w-100" for="sidebar-color-light">
                                        <span class="bg-light bg-sidebarcolor"></span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Light</h5>
                            </div>
                            <div class="col-4">
                                <div class="form-check sidebar-setting card-radio p-0"
                                    data-bs-target="#collapseBgGradient.show" data-bs-toggle="collapse">
                                    <input class="form-check-input" id="sidebar-color-dark" name="data-sidebar"
                                        type="radio" value="dark">
                                    <label class="form-check-label  avatar-md w-100" for="sidebar-color-dark">
                                        <span class="bg-darks bg-sidebarcolor"></span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Dark</h5>
                            </div>
                            <div class="col-4 d-none">
                                <div class="form-check sidebar-setting card-radio p-0">
                                    <input class="form-check-input" id="sidebar-color-gradient" name="data-sidebar"
                                        type="radio" value="gradient">
                                    <label class="form-check-label avatar-md w-100" for="sidebar-color-gradient">
                                        <span class="bg-gradients bg-sidebarcolor"></span>
                                    </label>
                                </div>
                                <h5 class="fs-13 text-center mt-2">Gradient</h5>
                            </div>
                            <div class="col-4 d-none">
                                <button aria-expanded="false"
                                    class="btn btn-link avatar-md w-100 p-0 overflow-hidden border collapsed"
                                    data-bs-target="#collapseBgGradient" data-bs-toggle="collapse" type="button">
                                    <span class="d-flex gap-1 h-100">
                                        <span class="flex-shrink-0">
                                            <span class="bg-vertical-gradient d-flex h-100 flex-column gap-1 p-1">
                                                <span class="d-block p-1 px-2 bg-soft-light rounded mb-2"></span>
                                                <span class="d-block p-1 px-2 pb-0 bg-soft-light"></span>
                                                <span class="d-block p-1 px-2 pb-0 bg-soft-light"></span>
                                                <span class="d-block p-1 px-2 pb-0 bg-soft-light"></span>
                                            </span>
                                        </span>
                                        <span class="flex-grow-1">
                                            <span class="d-flex h-100 flex-column">
                                                <span class="bg-light d-block p-1"></span>
                                                <span class="bg-light d-block p-1 mt-auto"></span>
                                            </span>
                                        </span>
                                    </span>
                                </button>
                                <h5 class="fs-13 text-center mt-2">Gradient</h5>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <div class="offcanvas-footer border-top p-3 text-center">
            <div class="row">
                <div class="col-6">
                    <button class="btn btn-light w-100 bor-rad-50" id="reset-layout" type="button">Reset</button>
                </div>
                <div class="col-6">
                    <a class="btn btn-primary w-100 bor-rad-50"
                        href="https://themeforest.net/item/smarthr-bootstrap-admin-panel-template/21153150"
                        target="_blank">Buy Now</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /Theme Setting -->

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Feather Icon JS -->
    <script src="{{ asset('assets/js/feather.min.js') }}"></script>

    <!-- Slimscroll JS -->
    <script src="{{ asset('assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>


    <!-- Theme Settings JS -->
    <script src="{{ asset('assets/js/theme-settings.js') }}"></script>
    <script src="{{ asset('assets/js/greedynav.js') }}"></script>

    <!-- Custom JS -->
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.7.8/axios.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    @livewireScripts
    @stack('scripts')
</body>

</html>
