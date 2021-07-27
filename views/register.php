<?php
/*
 * Created on Tue Jul 27 2021
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

/* Sign Up As Customer */
if (isset($_POST['Register'])) {
    $customer_name = $_POST['customer_name'];
    $customer_address = $_POST['customer_address'];
    $customer_email = $_POST['customer_email'];
    $customer_login_id = $sys_gen_id;

    /* Customer Auth  */
    $login_username = $_POST['login_username'];
    $login_password = sha1(md5($_POST['login_password']));
    $login_rank = 'Customer';

    /* Prevent Double Entries */
    $sql = "SELECT * FROM  login WHERE login_username = '$login_username'   ";
    $res = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        if ($login_username == $row['login_username']) {
            $err =  "Login Username Already Exists";
        }
    } else {
        $query = "INSERT INTO customer (customer_name, customer_address, customer_email, customer_login_id) VALUES(?,?,?,?)";
        $auth = "INSERT INTO login (login_id, login_username,login_password, login_rank) VALUES(?,?,?,?)";

        $stmt = $mysqli->prepare($query);
        $authstmt = $mysqli->prepare($auth);

        $rc = $stmt->bind_param('ssss', $customer_name, $customer_address, $customer_email, $customer_login_id);
        $rc = $authstmt->bind_param('ssss', $customer_login_id, $login_username, $login_password, $login_rank);

        $stmt->execute();
        $authstmt->execute();

        if ($stmt && $authstmt) {
            $success = "$customer_name, Your Account Has Been Created, Proceed To Login In As Customer";
        } else {
            $info = "Please Try Again Or Try Later";
        }
    }
}
require_once('../partials/head.php');
?>

<body class="hold-transition register-page" style=" background-image: url(../public/img/background.jpg); 
     background-repeat: no-repeat;
     background-position: center; 
     background-size: cover; ">
    <div class="register-box">
        <div class="card">
            <div class="register-logo">
                <br>
                <img src="../public/img/warehouse.svg" class="img-fluid" height="100" width="100">
                <br>
                <b class="text-primary">Warehouse MIS</b>
            </div>
            <div class="card-body register-card-body">
                <p class="login-box-msg text-bold">Sign Up As Customer</p>

                <form method="post">
                    <div class="input-group mb-3">
                        <input type="text" name="customer_name" required class="form-control" placeholder="Full Name">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user text-primary"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="customer_address" required class="form-control" placeholder="Address">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-map-pin text-primary"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" name="customer_email" required class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope text-primary"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="login_username" required class="form-control" placeholder="Login Username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user-tag text-primary"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="login_password" required class="form-control" placeholder="Login Password">
                        <div class="input-group-append">
                            <div class="input-group-text text-primary">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" name="Register" class="btn btn-warning btn-block">Register</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <br>
                <a href="login" class="text-center">Already Have An Account</a>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->
    <?php require_once('../partials/scripts.php'); ?>
</body>


</html>