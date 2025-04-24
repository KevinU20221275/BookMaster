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
                        href="../../index.php"
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
                        <a href="../employee/employees.php">
                            <i class="fas fa-users"></i>
                            <p>Empleados</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../role/roles.php">
                            <i class="fas fa-briefcase"></i>
                            <p>Roles</p>
                        </a>
                    </li>
                <?php }?> 
                
                <?php if ($_SESSION['user_role'] == "Administrator" || $_SESSION['user_role'] == "Manager" ){ ?>
                    <li class="nav-item">
                        <a href="../customer/customers.php">
                            <i class="fas fa-users"></i>
                            <p>Clientes</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../supplier/suppliers.php">
                            <i class="fas fa-truck"></i>
                            <p>Proveedores</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="../product/products.php">
                            <i class="fas fa-warehouse"></i>
                            <p>Productos</p>
                        </a>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <a href="../sale/sales.php">
                        <i class="fas fa-box-open"></i>
                        <p>Ventas</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>