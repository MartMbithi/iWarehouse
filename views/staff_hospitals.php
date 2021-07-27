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
require_once('../config/codeGen.php');
check_login();

/* Add Hospital */
if (isset($_POST['AddHospital'])) {
    $hospital_name = $_POST['hospital_name'];
    $hospital_desc = $_POST['hospital_desc'];
    $hospital_email = $_POST['hospital_email'];
    $hospital_contact  = $_POST['hospital_contact'];
    $hospital_mobile = $_POST['hospital_mobile'];

    /* Prevent Double Entries */
    $sql = "SELECT * FROM  Hospital WHERE  hospital_name = '$hospital_name'";
    $res = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        if ($hospital_name == $row['hospital_name']) {
            $err = 'Name Already Exists';
        }
    } else {
        $query = 'INSERT INTO Hospital  (hospital_name, hospital_desc, hospital_email, hospital_contact, hospital_mobile) VALUES(?,?,?,?,?)';
        $stmt = $mysqli->prepare($query);
        $rc = $stmt->bind_param('sssss', $hospital_name, $hospital_desc, $hospital_email, $hospital_contact, $hospital_mobile);
        $stmt->execute();
        if ($stmt) {
            $success = "$hospital_name Added";
        } else {
            $info = 'Please Try Again Or Try Later';
        }
    }
}


require_once('../partials/head.php');
?>

<body class="pe-0">
    <!-- Preloader-->
    <div class="preloader d-flex align-items-center justify-content-center" id="preloader">
        <div class="spinner-grow text-primary" role="status">
            <div class="sr-only">Loading...</div>
        </div>
    </div>
    <!-- Internet Connection Status-->
    <div class="internet-connection-status" id="internetStatus"></div>
    <!-- Header Area-->
    <div class="header-area" id="headerArea">
        <div class="container">
            <!-- Header Content-->
            <div class="header-content header-style-five position-relative d-flex align-items-center justify-content-between">
                <!-- Back Button-->
                <div class="back-button">
                    <a href="staff_home">
                        <svg width="32" height="32" viewBox="0 0 16 16" class="bi bi-arrow-left-short" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z" />
                        </svg>
                    </a>
                </div>
                <!-- Page Title-->
                <div class="page-heading">
                    <h6 class="mb-0">Hospitals</h6>
                </div>
                <!-- Navbar Toggler-->
                <div class="navbar--toggler" id="affanNavbarToggler"><span class="d-block"></span><span class="d-block"></span><span class="d-block"></span></div>
            </div>
        </div>
    </div>
    <!-- Dark mode switching-->
    <div class="dark-mode-switching">
        <div class="d-flex w-100 h-100 align-items-center justify-content-center">
            <div class="dark-mode-text text-center"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-moon" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M14.53 10.53a7 7 0 0 1-9.058-9.058A7.003 7.003 0 0 0 8 15a7.002 7.002 0 0 0 6.53-4.47z" />
                </svg>
                <p class="mb-0">Switching to dark mode</p>
            </div>
            <div class="light-mode-text text-center"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-brightness-high" viewBox="0 0 16 16">
                    <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
                </svg>
                <p class="mb-0">Switching to light mode</p>
            </div>
        </div>
    </div>
    <!-- Sidenav Black Overlay-->
    <div class="sidenav-black-overlay"></div>
    <!-- Side Nav Wrapper-->
    <?php require_once('../partials/staff_side_nav.php'); ?>

    <!-- Add new Staff modal-->
    <div class="add-new-contact-modal modal fade px-0" id="addnewcontact" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addnewcontactlabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="modal-title" id="addnewcontactlabel">New Hospital</h6>
                        <button class="btn btn-close p-1 ms-auto me-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST">
                        <div class="form-group mb-3">
                            <label class="form-label" for="fullname">Hospita Name</label>
                            <input class="form-control" required name="hospital_name" type="text">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="email">Hospital Email</label>
                            <input class="form-control" required name="hospital_email" type="email">
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label" for="job">Hospital Contact</label>
                            <input class="form-control" required name="hospital_contact" type="text">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="job">Hospital Mobile</label>
                            <input class="form-control" required name="hospital_mobile" type="text">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="email">Hospital Description</label>
                            <textarea class="form-control" required name="hospital_desc"></textarea>
                        </div>
                        <button class="btn btn-success w-100" name="AddHospital" type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content-wrapper py-3">
        <!-- Add New Staff-->
        <div class="add-new-contact-wrap"><a class="shadow" href="#" data-bs-toggle="modal" data-bs-target="#addnewcontact"><i class="bi bi-plus"></i></a></div>
        <div class="container">
            <div class="card mb-2">
                <div class="card-body p-2">
                    <div class="chat-search-box">
                        <form action="staff_hospital_search_result" method="GET">
                            <div class="input-group"><span class="input-group-text" id="searchbox"><i class="bi bi-search"></i></span>
                                <input class="form-control" name="search_query" type="text" placeholder="Search Hospitals" aria-describedby="searchbox">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Element Heading-->
            <div class="element-heading">
            </div>
            <!-- Chat User List-->
            <ul class="ps-0 chat-user-list">
                <?php
                $ret = "SELECT * FROM `Hospital`";
                $stmt = $mysqli->prepare($ret);
                $stmt->execute(); //ok
                $res = $stmt->get_result();
                while ($hospital = $res->fetch_object()) {
                ?>
                    <li class="p-3 chat-unread"><a class="d-flex" href="staff_hospital?view=<?php echo $hospital->hospital_id; ?>">
                            <!-- Thumbnail-->
                            <div class="chat-user-thumbnail me-3 shadow"><img class="img-circle" src="../public/img/bg-img/hospital.svg" alt=""><span class="active-status"></span></div>
                            <!-- Info-->
                            <div class="chat-user-info">
                                <h6 class="text-truncate mb-0"><?php echo $hospital->hospital_name; ?></h6>
                                <h6 class="text-truncate mb-0">Email: <?php echo $hospital->hospital_email; ?></h6>
                                <h6 class="text-truncate mb-0">Mobile: <?php echo $hospital->hospital_mobile; ?></h6>
                                <h6 class="text-truncate mb-0">Contacts: <?php echo $hospital->hospital_contact; ?></h6>
                                <div class="last-chat">
                                    <p class="text-truncate mb-0"><?php echo $hospital->hospital_desc; ?></p>
                                </div>

                            </div>
                        </a>
                    </li>
                <?php
                } ?>

            </ul>
        </div>
    </div>
    <!-- Footer Nav-->
    <?php require_once('../partials/staff_footer_nav.php'); ?>
    <!-- All JavaScript Files-->
    <?php require_once('../partials/scripts.php'); ?>
</body>

</html>