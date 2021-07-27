<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
        <a href="admin_dashboard" class="navbar-brand">
            <span class="brand-text font-weight-bold">OCRS</span>
        </a>

        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="admin_dashboard" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="admin_operators" class="nav-link">Operators</a>
                </li>
                <li class="nav-item">
                    <a href="admin_reported_crimes" class="nav-link">Reported Crimes</a>
                </li>
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Reports</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <li><a href="admin_operators_reports" class="dropdown-item">Operators </a></li>
                        <li><a href="admin_reported_crimes_reports" class="dropdown-item">Reported Crimes</a></li>
                    </ul>
                </li>
            </ul>

        </div>

        <!-- Right navbar links -->
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <!-- Messages Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" href="admin_profile">
                    <i class="fas fa-user-cog"></i>
                </a>

            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin_logout"><i class="fas fa-power-off"></i></a>
            </li>
        </ul>
    </div>
</nav>