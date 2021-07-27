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
if (isset($_POST['Reset_Password'])) {

    $login_username = $_POST['login_username'];
    $query = mysqli_query($mysqli, "SELECT * from `login` WHERE login_username = '" . $login_username . "' ");
    $num_rows = mysqli_num_rows($query);

    if ($num_rows > 0) {
        $n = date('y'); //Load Mumble Jumble
        $new_password = bin2hex(random_bytes($n));
        $query = "UPDATE login SET  login_password=? WHERE  login_username =? ";
        $stmt = $mysqli->prepare($query);
        $rc = $stmt->bind_param('ss', $new_password, $login_username);
        $stmt->execute();
        if ($stmt) {
            $_SESSION['login_username'] = $login_username;
            $success = "Password Reset" && header("refresh:1; url=confirm_password");
        } else {
            $err = "Password reset failed";
        }
    } else {
        $err = "User Account Does Not Exist";
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
                <p class="login-box-msg text-bold">Reset Password</p>
                <form method="post">
                    <div class="input-group mb-3">
                        <input type="text" name="login_username" required class="form-control" placeholder="Login Username">
                        <div class="input-group-append">
                            <div class="input-group-text text-primary">
                                <span class="fas fa-user-tag"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" name="Reset_Password" class="btn btn-warning btn-block">Reset Password</button>
                        </div>
                    </div>
                </form>
                <p class="mb-1">
                    <a href="login">Remember Password</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
    <?php require_once('../partials/scripts.php'); ?>

</body>


</html>