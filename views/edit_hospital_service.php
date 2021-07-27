<?php
/*
 * Created on Mon Jul 26 2021
 *
 * The MIT License (MIT)
 * Copyright (c) 2021 MartDevelopers Inc
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software
 * and associated documentation files (the "Software"), to deal in the Software without restriction,
 * including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial
 * portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED
 * TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

session_start();
require_once('../config/config.php');
require_once('../config/checklogin.php');
check_login();
/* Update Service */
if (isset($_POST['UpdateHospitalService'])) {
    $hos_serv_cost = $_POST['hos_serv_cost'];
    $view  = $_GET['view'];
    $query = 'UPDATE Hospital_Service SET hos_serv_cost =? WHERE hos_serv_id = ?';
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('ss', $hos_serv_cost, $view);
    $stmt->execute();

    if ($stmt) {
        $success = "Hospital Service Cost Updated" && header("refresh:1, hospital_service?view=$view");
    } else {
        $info = 'Please Try Again Or Try Later';
    }
}

require_once('../partials/head.php');
?>

<body>
    <!-- Preloader-->
    <div class="preloader d-flex align-items-center justify-content-center" id="preloader">
        <div class="spinner-grow text-primary" role="status">
            <div class="sr-only">Loading...</div>
        </div>
    </div>
    <!-- Internet Connection Status-->
    <div class="internet-connection-status" id="internetStatus"></div>
    <!-- Header Area-->
    <!-- Header Area-->
    <?php require_once('../partials/header.php'); ?>
    <!-- Sidenav Black Overlay-->
    <div class="sidenav-black-overlay"></div>
    <!-- Side Nav Wrapper-->
    <?php require_once('../partials/side_nav.php');
    $view = $_GET['view'];
    $ret = "SELECT * FROM Hospital_Service hs
    INNER JOIN Hospital h ON hs.hos_serv_hospital_id = h.hospital_id
    INNER JOIN Services s ON hs.hos_serv_service_id = s.service_id WHERE hs.hos_serv_id = '$view'   ";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute(); //ok
    $res = $stmt->get_result();
    while ($service = $res->fetch_object()) {
    ?>

        <div class="page-content-wrapper py-3">
            <div class="container">
                <!-- User Information-->
                <div class="card user-info-card mb-3">
                    <div class="card-body d-flex align-items-center">
                        <div class="user-profile me-3"><img src="../public/img/bg-img/healthcare.svg" alt="">
                        </div>
                        <div class="user-info">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-1">Update <?php echo $service->hospital_name . " " . $service->service_name; ?> Cost </h5></span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- User Meta Data-->
                <div class="card user-data-card">
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group mb-3">
                                <label class="form-label" for="fullname">Service Cost</label>
                                <input class="form-control" required name="hos_serv_cost" type="text" value="<?php echo $service->hos_serv_cost; ?>">
                            </div>
                            <button class="btn btn-success w-100" name="UpdateHospitalService" type="submit">Submit</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    require_once('../partials/footer_nav.php'); ?>
    <!-- All JavaScript Files-->
    <?php require_once('../partials/scripts.php'); ?>
    <!-- All JavaScript Files-->
</body>


</html>