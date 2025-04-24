<?php
session_start();
if ($_SESSION['user_name'] == "") {
  header("Location: ../index.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Book Master | Dashboard</title>
  <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
  <link rel="icon" href="views/assets/img/favicon.ico" type="image/x-icon" />

  <!-- Fonts and icons -->
  <script src="views/assets/js/plugin/webfont/webfont.min.js"></script>
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
        urls: ["views/assets/css/fonts.min.css"],
      },
      active: function() {
        sessionStorage.fonts = true;
      },
    });
  </script>


  <!-- CSS Files -->
  <link rel="stylesheet" href="views/assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="views/assets/css/plugins.min.css" />
  <link rel="stylesheet" href="views/assets/css/kaiadmin.min.css" />


</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar" data-background-color="dark">
      <div class="sidebar-logo">
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
      <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
          <ul class="nav nav-secondary">
            <li class="nav-item active">
              <a
                href=""
                aria-expanded="false">
                <i class="fas fa-home"></i>
                <p>Dashboard</p>
              </a>
            </li>
            <li class="nav-section">
              <span class="sidebar-mini-icon">
                <i class="fa fa-ellipsis-h"></i>
              </span>
              <h4 class="text-section">Components</h4>
            </li>
            <?php if ($_SESSION['user_role'] == "Administrator") { ?>
              <li class="nav-item">
                <a href="views/employee/employees.php">
                  <i class="fas fa-user"></i>
                  <p>Empleados</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="views/role/roles.php">
                  <i class="fas fa-briefcase"></i>
                  <p>Roles</p>
                </a>
              </li>
            <?php } ?> 
            
            <?php if ($_SESSION['user_role'] == "Administrator" || $_SESSION['user_role'] == "Manager" ){ ?>
              <li class="nav-item">
                <a href="views/customer/customers.php">
                  <i class="fas fa-users"></i>
                  <p>Clientes</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="views/suppliers/suppliers.php">
                  <i class="fas fa-truck"></i>
                  <p>Proveedores</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="views/product/products.php">
                  <i class="fas fa-warehouse"></i>
                  <p>Inventario</p>
                </a>
              </li>
            <?php } ?>
              <li class="nav-item">
                <a href="views/sale/sales.php">
                  <i class="fas fa-box-open"></i>
                  <p>Ventas</p>
                </a>
              </li>
          </ul>
        </div>
      </div>
    </div>
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
        <nav
          class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
          <div class="container-fluid">
            <nav
              class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
            </nav>

            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
              <li
                class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                <a
                  class="nav-link dropdown-toggle"
                  data-bs-toggle="dropdown"
                  href="#"
                  role="button"
                  aria-expanded="false"
                  aria-haspopup="true">
                  <i class="fa fa-search"></i>
                </a>
                <ul class="dropdown-menu dropdown-search animated fadeIn">
                  <form class="navbar-left navbar-form nav-search">
                    <div class="input-group">
                      <input
                        type="text"
                        placeholder="Search ..."
                        class="form-control" />
                    </div>
                  </form>
                </ul>
              </li>

              <!-- datos del usuario -->
              <li class="nav-item topbar-user dropdown hidden-caret">
                <a
                  class="dropdown-toggle profile-pic"
                  data-bs-toggle="dropdown"
                  href="#"
                  aria-expanded="false">
                  <div class="avatar-sm">
                    <img
                      src="views/assets/img/profile.jpg"
                      alt="..."
                      class="avatar-img rounded-circle" />
                  </div>
                  <span class="profile-username">
                    <span class="op-7">Hi,</span>
                    <span class="fw-bold"><?= $_SESSION['user_name'] ?></span>
                  </span>
                </a>
                <ul class="dropdown-menu dropdown-user animated fadeIn">
                  <div class="dropdown-user-scroll scrollbar-outer">
                    <li>
                      <div class="user-box">
                        <div class="u-text">
                          <h4><?= $_SESSION['user'] ?></h4>
                          <p class="text-muted"><?= $_SESSION['user_email'] ?></p>
                        </div>
                      </div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="logout.php">Logout</a>
                    </li>
                  </div>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
        <!-- End Navbar -->
      </div>

      <div class="container">
        <div class="page-inner">
          <div
            class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
              <h3 class="fw-bold mb-3">Bienvenido <?= $_SESSION['user'] ?></h3>
            </div>
          </div>

          <div class="row">
            <?php if ($_SESSION['user_role'] == "Administrator") { ?>
              <div class="col-sm-6 col-md-3">
                <a href="views/employee/employees.php">
                  <div class="card card-stats card-round">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col-icon">
                          <div class="icon-big text-center icon-primary bubble-shadow-small">
                            <i class="fas fa-user"></i>
                          </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                          <div class="numbers">
                            <p class="card-category">Empleados</p>
                            <h4 class="card-title"></h4>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
              <div class="col-sm-6 col-md-3">
                <a href="views/role/roles.php">
                  <div class="card card-stats card-round">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col-icon">
                          <div class="icon-big text-center icon-danger bubble-shadow-small">
                            <i class="fas fa-briefcase"></i>
                          </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                          <div class="numbers">
                            <p class="card-category">Roles</p>
                            <h4 class="card-title"></h4>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            <?php } ?> 
            
            <?php if ($_SESSION['user_role'] == "Administrator" || $_SESSION['user_role'] == "Manager" ){ ?>
              <div class="col-sm-6 col-md-3">
                <a href="views/customer/customers.php">
                  <div class="card card-stats card-round">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col-icon">
                          <div class="icon-big text-center icon-warning bubble-shadow-small">
                            <i class="fas fa-users"></i>
                          </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                          <div class="numbers">
                            <p class="card-category">Clientes</p>
                            <h4 class="card-title"></h4>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
              <div class="col-sm-6 col-md-3">
                <a href="views/supplier/suppliers.php">
                  <div class="card card-stats card-round">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col-icon">
                          <div class="icon-big text-center icon-info bubble-shadow-small">
                            <i class="fas fa-truck"></i>
                          </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                          <div class="numbers">
                            <p class="card-category">Proveedores</p>
                            <h4 class="card-title"></h4>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </a>
              </div>

              <div class="col-sm-6 col-md-3">
                <a href="views/product/products.php">
                  <div class="card card-stats card-round">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col-icon">
                          <div class="icon-big text-center icon-secondary bubble-shadow-small">
                            <i class="fas fa-warehouse"></i>
                          </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                          <div class="numbers">
                            <p class="card-category">Productos</p>
                            <h4 class="card-title"></h4>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            <?php } ?>
              <div class="col-sm-6 col-md-3">
                <a href="views/sale/sales.php">
                  <div class="card card-stats card-round">
                    <div class="card-body">
                      <div class="row align-items-center">
                        <div class="col-icon">
                          <div class="icon-big text-center icon-success bubble-shadow-small">
                            <i class="fas fa-box-open"></i>
                          </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                          <div class="numbers">
                            <p class="card-category">Ventas</p>
                            <h4 class="card-title"></h4>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
          </div>
        </div>
      </div>

      <footer class="footer">
        <div class="container-fluid d-flex justify-content-between">
          <nav class="pull-left">
            <ul class="nav">
              <li class="nav-item">
                <a class="nav-link" href="#">
                  Book Master
                </a>
              </li>
            </ul>
          </nav>
          <div class="copyright">
            2024, made by
            <a href="#">Book Master</a>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="views/assets/js/core/jquery-3.7.1.min.js"></script>
  <script src="views/assets/js/core/popper.min.js"></script>
  <script src="views/assets/js/core/bootstrap.min.js"></script>

  <!-- jQuery Scrollbar -->
  <script src="views/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

  <!-- Datatables -->
  <script src="views/assets/js/plugin/datatables/datatables.min.js"></script>

  <!-- Bootstrap Notify -->
  <script src="views/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

  <!-- Sweet Alert -->
  <script src="views/assets/js/plugin/sweetalert/sweetalert.min.js"></script>

  <!-- Kaiadmin JS -->
  <script src="views/assets/js/kaiadmin.min.js"></script>

</body>

</html>