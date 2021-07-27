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
require_once('../config/codeGen.php');

if (isset($_POST['Sign_Up'])) {
    $client_full_name = $_POST['client_full_name'];
    $client_login_id = $sys_gen_id;
    $client_phone_no = $_POST['client_phone_no'];
    $client_gender = $_POST['client_gender'];
    $client_email = $_POST['client_email'];
    $client_location = $_POST['client_location'];
    /* Client Auth Details */
    $login_rank = 'Client';
    $login_password = sha1(md5($_POST['login_password']));

    /* Persist Client Details In Database  */
    $sql = "SELECT * FROM  Clients  WHERE  client_email = '$client_email'  ";
    $res = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        if ($client_email == $row['client_email']) {
            $err =  "A Client Account With This Email  Already Exists";
        }
    } else {
        $query = "INSERT INTO Clients (client_full_name, client_login_id, client_phone_no, client_gender, client_email, client_location) VALUES(?,?,?,?,?,?)";
        $auth = "INSERT INTO Login (login_id, login_user_name, login_email, login_password, login_rank) VALUES(?,?,?,?,?)";

        $stmt = $mysqli->prepare($query);
        $auth_stmt = $mysqli->prepare($auth);

        $rc = $stmt->bind_param('ssssss', $client_full_name, $client_login_id, $client_phone_no, $client_gender, $client_email, $client_location);
        $rc = $auth_stmt->bind_param('sssss', $client_login_id, $client_full_name, $client_email, $login_password, $login_rank);

        $stmt->execute();
        $auth_stmt->execute();

        if ($stmt && $auth_stmt) {
            $success = "$client_full_name Account Created, Proceed To Login";
        } else {
            $info = "Please Try Again Or Try Later";
        }
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
    <!-- Login Wrapper Area-->
    <div class="login-wrapper d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-9 col-md-7 col-lg-6 col-xl-5">
                    <div class="text-center px-4"><img class="login-intro-img" src="../public/img/bg-img/38.png" alt=""></div>
                    <!-- Register Form-->
                    <div class="register-form mt-4 px-4">
                        <h6 class="mb-3 text-center">Sign Up To iScheduling.</h6>
                        <form method="POST">
                            <div class="form-group">
                                <label class="form-label">Full Name</label>
                                <input class="form-control" required name="client_full_name" type="text">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Phone Number</label>
                                <input class="form-control" required name="client_phone_no" type="text">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Gender</label>
                                <select class="form-control" required name="client_gender" type="text">
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Location</label>
                                <input class="form-control" required name="client_location" type="text">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email Address</label>
                                <input class="form-control" required name="client_email" type="email">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Login Password</label>
                                <input class="form-control" type="password" name="login_password">
                            </div>
                            <button class="btn btn-primary w-100" name="Sign_Up" type="submit">Sign Up</button>
                        </form>
                    </div>
                    <!-- Login Meta-->
                    <div class="login-meta-data text-center"><a class="stretched-link forgot-password d-block mt-3 mb-1" href="forget_password">Forgot Password?</a>
                        <p class="mb-0">Have an account ? <br> <a class="stretched-link" href="login.php">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- All JavaScript Files-->
    <?php require_once('../partials/scripts.php'); ?>
</body>


</html>