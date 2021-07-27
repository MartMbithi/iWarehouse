<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
        <a href="" class="navbar-brand">
            <img src="../public/img/warehouse.svg" alt="Logo" class="img-fluid" height="30" width="30" style="opacity: .8">
            <span class="brand-text font-weight-bold"> WareHouse Management System</span> </a>

        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <?php
        if ($_SESSION['login_rank'] == 'Administrator') {
        ?>
            <div class="collapse navbar-collapse order-3" id="navbarCollapse">

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="home" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Users</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="users" class="dropdown-item">Users </a></li>
                            <li><a href="customers" class="dropdown-item">Customers</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="categories" class="nav-link">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a href="products" class="nav-link">Products</a>
                    </li>
                    <li class="nav-item">
                        <a href="stores" class="nav-link">Stores</a>
                    </li>
                    <li class="nav-item">
                        <a href="stores" class="nav-link">Stocks</a>
                    </li>
                    <li class="nav-item">
                        <a href="orders" class="nav-link">Orders</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Reports</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="reports_users" class="dropdown-item">Users </a></li>
                            <li><a href="reports_customers" class="dropdown-item">Customers</a></li>
                            <li><a href="reports_products" class="dropdown-item">Products</a></li>
                            <li><a href="reports_stores" class="dropdown-item">Stores</a></li>
                            <li><a href="reports_stocks" class="dropdown-item">Stocks</a></li>
                            <li><a href="reports_orders" class="dropdown-item">Orders</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

            <!-- Right navbar links -->
            <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link text-primary" href="profile">
                        <i class="fas fa-user-cog"></i>
                    </a>

                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="logout"><i class="fas fa-power-off"></i></a>
                </li>
            </ul>
        <?php
        } else {
        ?>
            <div class="collapse navbar-collapse order-3" id="navbarCollapse">

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="my_home" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="my_products" class="nav-link">Products</a>
                    </li>
                    <li class="nav-item">
                        <a href="my_stores" class="nav-link">Stores</a>
                    </li>
                    <li class="nav-item">
                        <a href="my_orders" class="nav-link">Orders</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Reports</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="my_reports_orders" class="dropdown-item">Orders </a></li>
                        </ul>
                    </li>
                </ul>
            </div>

            <!-- Right navbar links -->
            <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link text-primary" href="my_profile">
                        <i class="fas fa-user-cog"></i>
                    </a>

                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="logout"><i class="fas fa-power-off"></i></a>
                </li>
            </ul>
        <?php
        } ?>
    </div>
</nav>