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
/* Login */
if (isset($_POST['Login'])) {
    $login_username = $_POST['login_username'];
    $login_password = sha1(md5($_POST['login_password']));
    $login_rank = $_POST['login_rank'];

    $stmt = $mysqli->prepare("SELECT login_username, login_password, login_rank, login_id  FROM login  WHERE login_username =? AND login_password =?  AND login_rank = ?");
    $stmt->bind_param('sss', $login_username, $login_password, $login_rank);
    $stmt->execute(); //execute bind

    $stmt->bind_result($login_username, $login_password, $login_rank, $login_id);
    $rs = $stmt->fetch();
    $_SESSION['login_id'] = $login_id;
    $_SESSION['login_rank'] = $login_rank;

    /* Decide Login User Dashboard Based On User Rank */
    if ($rs && $login_rank == 'Administrator') {
        header("location:home");
    } else if ($rs && $login_rank == 'Customer') {
        header("location:my_home");
    } else {
        $err = "Login Failed, Please Check Your Credentials And Login Permission ";
    }
}
require_once('../partials/head.php');
?>

<body class="hold-transition login-page login_image" style=" background-image: url(../public/img/background.jpg); 
     background-repeat: no-repeat;
     background-position: center; 
     background-size: cover; ">

    <div class="login-box">
        <div class="card">
            <div class="login-logo">
                <br>
                <img src="../public/img/warehouse.svg" class="img-fluid" height="100" width="100">
                <br>
                <b class="text-primary">Warehouse MIS</b>
            </div>
            <div class="card-body login-card-body">
                <p class="login-box-msg text-bold">Sign In To Start Your Session</p>
                <form method="post">
                    <div class="input-group mb-3">
                        <input type="text" name="login_username" required class="form-control" placeholder="Login Username">
                        <div class="input-group-append">
                            <div class="input-group-text text-primary">
                                <span class="fas fa-user-tag"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="login_password" required class="form-control" placeholder="Login Password">
                        <div class="input-group-append">
                            <div class="input-group-text text-primary">
                                <span class="fas fa-user-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label for="remember">Sign In As</label>
                            <select name="login_rank" required class="form-control">
                                <option>Administrator</option>
                                <option>Customer</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <br>
                            <button type="submit" name="Login" class="btn btn-warning btn-block">Sign In</button>
                        </div>
                    </div>
                </form>
                <p class="mb-1">
                    <a href="reset_password">Forgot Password</a>
                </p>
                <p class="mb-0">
                    <a href="register" class="text-center">Create Customer Account</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
    <?php require_once('../partials/scripts.php'); ?>

</body>


</html>