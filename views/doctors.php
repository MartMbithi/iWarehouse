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

/* Add Doc */
if (isset($_POST['AddDoctor'])) {
    $doctor_full_name = $_POST['doctor_full_name'];
    $doctor_specialization = $_POST['doctor_specialization'];
    $doctor_login_id = $_POST['login_id'];
    $doctor_phone_no = $_POST['doctor_phone_no'];
    $doctor_email = $_POST['doctor_email'];
    $login_password = sha1(md5($_POST['login_password']));
    $login_rank = $_POST['login_rank'];
    /* Prevent Double Entries */
    $sql = "SELECT * FROM  Doctors WHERE  doctor_phone_no = '$doctor_phone_no' || doctor_email = '$doctor_email'";
    $res = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        if ($doctor_phone_no == $row['doctor_phone_no'] || $doctor_email = $row['doctor_email']) {
            $err = 'Phone Number Or Email Already Exists';
        }
    } else {
        $auth_querry = 'INSERT INTO Login (login_id, login_user_name, login_email, login_password, login_rank) VALUES(?,?,?,?,?)';
        $query = 'INSERT INTO Doctors  (doctor_full_name, doctor_specialization,  doctor_login_id, doctor_phone_no, doctor_email) VALUES(?,?,?,?,?)';

        $auth_qry_stmt = $mysqli->prepare($auth_querry);
        $stmt = $mysqli->prepare($query);

        $rc = $auth_qry_stmt->bind_param('sssss', $doctor_login_id, $doctor_full_name, $doctor_email, $login_password, $login_rank);
        $rc = $stmt->bind_param('sssss', $doctor_full_name, $doctor_specialization, $doctor_login_id, $doctor_phone_no, $doctor_email);

        $auth_qry_stmt->execute();
        $stmt->execute();

        if ($auth_qry_stmt &&  $stmt) {
            $success = "$doctor_full_name Account Created";
        } else {
            $info = 'Please Try Again Or Try Later';
        }
    }
}


/* Delete Staff */
if (isset($_GET['delete'])) {
    $delete = $_GET['delete'];
    $login = $_GET['login'];
    $adn = "DELETE FROM Doctors WHERE doctor_id=?";
    $delete_auth = "DELETE FROM Login WHERE login_id = ?";
    $stmt = $mysqli->prepare($adn);
    $auth_stmt = $mysqli->prepare($delete_auth);
    $stmt->bind_param('s', $delete);
    $auth_stmt->bind_param('s', $login);
    $stmt->execute();
    $auth_stmt->execute();
    $stmt->close();
    $auth_stmt->close();
    if ($stmt && $auth_stmt) {
        $success = "Deleted" && header("refresh:1; url=doctors");
    } else {
        $info = "Please Try Again Or Try Later";
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
                    <a href="home">
                        <svg width="32" height="32" viewBox="0 0 16 16" class="bi bi-arrow-left-short" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z" />
                        </svg>
                    </a>
                </div>
                <!-- Page Title-->
                <div class="page-heading">
                    <h6 class="mb-0">Doctors</h6>
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
    <?php require_once('../partials/side_nav.php'); ?>

    <!-- Add new Staff modal-->
    <div class="add-new-contact-modal modal fade px-0" id="addnewcontact" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addnewcontactlabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="modal-title" id="addnewcontactlabel">New Doctor</h6>
                        <button class="btn btn-close p-1 ms-auto me-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST">
                        <div class="form-group mb-3">
                            <label class="form-label" for="fullname">Full Name</label>
                            <input class="form-control" required name="doctor_full_name" type="text">
                            <input class="form-control" value="<?php echo $sys_gen_id; ?>" required name="login_id" type="hidden">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="email">Email Address</label>
                            <input class="form-control" required name="doctor_email" type="email">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="job">Phone Number</label>
                            <input class="form-control" required name="doctor_phone_no" type="text">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="fullname">Login Password</label>
                            <input class="form-control" required name="login_password" type="password">
                        </div>
                        <div class="form-group mb-3" style="display:none">
                            <label class="form-label" for="fullname">Login Rank</label>
                            <select class="form-control" required name="login_rank">
                                <option>Doctor</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="job">Doctor Specialization</label>
                            <textarea rows="4" class="form-control" required type="text" name="doctor_specialization"></textarea>
                        </div>
                        <button class="btn btn-success w-100" name="AddDoctor" type="submit">Submit</button>
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
                        <form action="doctor_search_result" method="GET">
                            <div class="input-group"><span class="input-group-text" id="searchbox"><i class="bi bi-search"></i></span>
                                <input class="form-control" name="search_query" type="text" placeholder="Search Doctors " aria-describedby="searchbox">
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
                $ret = "SELECT * FROM `Doctors`";
                $stmt = $mysqli->prepare($ret);
                $stmt->execute(); //ok
                $res = $stmt->get_result();
                while ($doc = $res->fetch_object()) {
                ?>
                    <li class="p-3 chat-unread"><a class="d-flex" href="doctor?view=<?php echo $doc->doctor_id; ?>">
                            <!-- Thumbnail-->
                            <div class="chat-user-thumbnail me-3 shadow"><img class="img-circle" src="../public/img/bg-img/doctor.svg" alt=""><span class="active-status"></span></div>
                            <!-- Info-->
                            <div class="chat-user-info">
                                <h6 class="text-truncate mb-0"><?php echo $doc->doctor_full_name; ?></h6>
                                <h6 class="text-truncate mb-0">Email: <?php echo $doc->doctor_email; ?></h6>
                                <h6 class="text-truncate mb-0">Phone: <?php echo $doc->doctor_phone_no; ?></h6>
                                <div class="last-chat">
                                    <p class="text-truncate mb-0"><?php echo $doc->doctor_specialization; ?></p>
                                </div>
                            </div>

                        </a>
                        <!-- Options-->
                        <div class="dropstart chat-options-btn">
                            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots-vertical"></i></button>
                            <ul class="dropdown-menu">
                                <li><a href="doctors?delete=<?php echo $doc->doctor_id; ?>&login=<?php echo $doc->doctor_login_id; ?>"><i class="bi bi-trash"></i>Delete</a></li>
                            </ul>
                        </div>
                    </li>
                <?php
                } ?>

            </ul>
        </div>
    </div>
    <!-- Footer Nav-->
    <?php require_once('../partials/footer_nav.php'); ?>
    <!-- All JavaScript Files-->
    <?php require_once('../partials/scripts.php'); ?>
</body>

</html>