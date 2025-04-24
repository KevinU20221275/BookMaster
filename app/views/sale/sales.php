<?php
session_start();
if ($_SESSION['user_name'] == "") {
    header("Location: ../../../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Book Master | Ventas</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="../assets/img/favicon.ico" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="../assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["../assets/css/fonts.min.css"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- CSS Files -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/plugins.min.css" />
    <link rel="stylesheet" href="../assets/css/kaiadmin.min.css" />
</head>
<style>
    .detailTable {
        animation: fadeIn .7s ease-in-out forwards;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        } to {
            opacity: 1;
        }
    }
</style>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <?php include_once('../includes/sidebar.php') ?>
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <!-- Logo Header -->
                    <div class="logo-header" data-background-color="dark">
                        <div class="nav-toggle">
                            <button class="btn btn-toggle toggle-sidebar">
                                <i class="gg-menu-right"></i>
                            </button>
                            <button class="btn btn-toggle sidenav-toggler">
                                <i class="gg-menu-left"></i>
                            </button>
                        </div>
                        <button class="topbar-toggler more">
                            <i class="gg-more-vertical-alt"></i>
                        </button>
                    </div>
                    <!-- End Logo Header -->
                </div>
                <!-- Navbar Header -->
                <?php include_once('../includes/navbar.php') ?>
                <!-- End Navbar -->
            </div>

            <div class="container">
                <div class="page-inner">

                    <!-- FORMULARIOS MODALES -->
                    <?php
                    include_once('createModal.php');
                    include_once('saleDetailsModal.php');
                    include_once('deleteModal.php');
                    include_once('addClientModal.php');
                    ?>

                    <div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h4 class="card-title">Listado de Ventas</h4>
                                        <button
                                            class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">
                                            <i class="fa fa-plus"></i>
                                            Registrar Venta
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <div class="table-responsive">
                                        <table
                                            id="saleTable"
                                            class="display table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Empleado</th>
                                                    <th>Cliente</th>
                                                    <th>Total</th>
                                                    <th>Fecha</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Empleado</th>
                                                    <th>Cliente</th>
                                                    <th>Total</th>
                                                    <th>Fecha</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                            <tbody id="content">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FOOTER -->
                <?php include_once('../includes/footer.php') ?>
                <!-- End Footer -->
            </div>
        </div>
        <!--   Core JS Files   -->
        <script src="../assets/js/core/jquery-3.7.1.min.js"></script>
        <script src="../assets/js/core/popper.min.js"></script>
        <script src="../assets/js/core/bootstrap.min.js"></script>

        <!-- jQuery Scrollbar -->
        <script src="../assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

        <!-- Datatables -->
        <script src="../assets/js/plugin/datatables/datatables.min.js"></script>

        <!-- Bootstrap Notify -->
        <script src="../assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

        <!-- Kaiadmin JS -->
        <script src="../assets/js/kaiadmin.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script type="module" src="logic/logic.js"></script>
</body>

</html>