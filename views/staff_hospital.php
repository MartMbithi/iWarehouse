<?php
/*
 * Created on Sun Jul 04 2021
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
/* Update Hospital */
if (isset($_POST['UpdateHospital'])) {
    $hospital_name = $_POST['hospital_name'];
    $hospital_desc = $_POST['hospital_desc'];
    $hospital_email = $_POST['hospital_email'];
    $hospital_contact  = $_POST['hospital_contact'];
    $hospital_mobile = $_POST['hospital_mobile'];
    $hospital_id = $_POST['hospital_id'];

    $query = 'UPDATE Hospital SET hospital_name =?, hospital_desc =?, hospital_email =?, hospital_contact =?, hospital_mobile=? WHERE hospital_id = ?';
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('ssssss', $hospital_name, $hospital_desc, $hospital_email, $hospital_contact, $hospital_mobile, $hospital_id);
    $stmt->execute();
    if ($stmt) {
        $success = "$hospital_name Updated";
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
    <?php require_once('../partials/staff_side_nav.php');
    $view = $_GET['view'];
    $ret = "SELECT *  FROM Hospital WHERE hospital_id = '$view' ";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute(); //ok
    $res = $stmt->get_result();
    while ($hospital = $res->fetch_object()) {
    ?>

        <div class="page-content-wrapper py-3">
            <div class="container">
                <!-- User Information-->
                <div class="card user-info-card mb-3">
                    <div class="card-body d-flex align-items-center">
                        <div class="user-profile me-3"><img src="../public/img/bg-img/hospital.svg" alt="">
                        </div>
                        <div class="user-info">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-1"><?php echo $hospital->hospital_name; ?> Profile</h5></span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- User Meta Data-->
                <div class="card user-data-card">
                    <h5 class="text-center">Hospital Details</h5>
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group mb-3">
                                <label class="form-label" for="fullname">Hospita Name</label>
                                <input class="form-control" required name="hospital_name" value="<?php echo $hospital->hospital_name; ?>" type="text">
                                <input class="form-control" required name="hospital_id" value="<?php echo $hospital->hospital_id; ?>" type="hidden">
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="email">Hospital Email</label>
                                <input class="form-control" required name="hospital_email" value="<?php echo $hospital->hospital_email; ?>" type="email">
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="job">Hospital Contact</label>
                                <input class="form-control" required name="hospital_contact" value="<?php echo $hospital->hospital_contact; ?>" type="text">
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="job">Hospital Mobile</label>
                                <input class="form-control" required name="hospital_mobile" value="<?php echo $hospital->hospital_mobile; ?>" type="text">
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="email">Hospital Description</label>
                                <textarea class="form-control" required name="hospital_desc"><?php echo $hospital->hospital_desc; ?></textarea>
                            </div>
                            <button class="btn btn-success w-100" name="UpdateHospital" type="submit">Submit</button>
                        </form>
                    </div>
                </div>
                <br>
            </div>
        </div>
        <!-- Footer Nav-->
    <?php
    }
    require_once('../partials/staff_footer_nav.php'); ?>
    <!-- All JavaScript Files-->
    <?php require_once('../partials/scripts.php'); ?>
    <!-- All JavaScript Files-->
</body>


</html>