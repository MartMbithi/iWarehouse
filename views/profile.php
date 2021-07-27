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
require_once('../config/checklogin.php');
require_once('../config/codeGen.php');
checklogin();

/* Update User Profile */
if (isset($_POST['update_user_profile'])) {
    $user_id = $_POST['user_id'];
    $user_full_name = $_POST['user_full_name'];
    $user_mobile  = $_POST['user_mobile'];
    $user_email = $_POST['user_email'];

    $query = "UPDATE users SET user_full_name =?, user_mobile =?, user_email =? WHERE user_id = ?";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('ssss', $user_full_name, $user_mobile, $user_email, $user_id);
    $stmt->execute();

    if ($stmt) {
        $success = "$user_full_name Account Updated";
    } else {
        $info = "Please Try Again Or Try Later";
    }
}

/* Update User Auth*/
if (isset($_POST['update_user'])) {
    $login_id = $_POST['login_id'];
    $login_username = $_POST['login_username'];
    $new_password  = sha1(md5($_POST['new_password']));
    $confirm_password = sha1(md5($_POST['confirm_password']));

    if ($new_password != $confirm_password) {
        $err = "Passwords Do Not Match";
    } else {
        $query = "UPDATE login SET login_username =?, login_password =? WHERE login_id = ?";
        $stmt = $mysqli->prepare($query);
        $rc = $stmt->bind_param('sss', $login_username, $confirm_password, $login_id);
        $stmt->execute();

        if ($stmt) {
            $success = "Login Details Updated";
        } else {
            $info = "Please Try Again Or Try Later";
        }
    }
}

require_once('../partials/head.php');
?>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        <!-- Navbar -->
        <?php require_once('../partials/navbar.php');
        $login = $_SESSION['login_id'];
        $ret = "SELECT * FROM users  WHERE user_login_id = '$login'";
        $stmt = $mysqli->prepare($ret);
        $stmt->execute(); //ok
        $res = $stmt->get_result();
        while ($user = $res->fetch_object()) {
        ?>
            <!-- /.navbar -->

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-dark"><?php echo $user->user_full_name; ?> Profile</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="home">Home</a></li>
                                    <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="users">Profile</a></li>
                                    <li class="breadcrumb-item active"><?php echo $user->user_full_name; ?></li>
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <div class="content">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card card-warning card-outline">
                                    <div class="card-body box-profile">
                                        <div class="text-center">
                                            <img class="profile-user-img img-fluid img-circle" src="../public/img/no-profile.png" alt="User profile picture">
                                        </div>

                                        <h3 class="profile-username text-center"><?php echo $user->user_full_name; ?></h3>

                                        <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item">
                                                <b>Mobile : </b> <a class="float-right"><?php echo $user->user_mobile; ?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Email : </b> <a class="float-right"><?php echo $user->user_email; ?></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-8">
                                <div class="card card-warning card-outline">
                                    <div class="card-header p-2">
                                        <ul class="nav nav-pills">
                                            <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Update Profile</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Update Login Credentials</a></li>
                                        </ul>
                                    </div><!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="activity">
                                                <form method="post" enctype="multipart/form-data" role="form">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="form-group col-md-12">
                                                                <label for="">Full Name</label>
                                                                <input type="text" required name="user_full_name" value="<?php echo $user->user_full_name; ?>" class="form-control">
                                                                <input type="hidden" required name="user_id" value="<?php echo $user->user_id; ?>" class="form-control">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="">Mobile Phone Number</label>
                                                                <input type="text" required name="user_mobile" value="<?php echo $user->user_mobile; ?>" class="form-control">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="">Email Address</label>
                                                                <input type="text" required name="user_email" value="<?php echo $user->user_email; ?>" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-right">
                                                        <button type="submit" name="update_user_profile" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane" id="timeline">
                                                <form method="post" enctype="multipart/form-data" role="form">
                                                    <div class="row">
                                                        <?php
                                                        $user_login = $user->user_login_id;
                                                        $ret = "SELECT * FROM login  WHERE login_id = '$user_login'";
                                                        $stmt = $mysqli->prepare($ret);
                                                        $stmt->execute(); //ok
                                                        $res = $stmt->get_result();
                                                        while ($login = $res->fetch_object()) {
                                                        ?>
                                                            <div class="form-group col-md-12">
                                                                <label for="">Login Username</label>
                                                                <input type="hidden" required name="login_id" value="<?php echo $login->login_id; ?>" class="form-control">
                                                                <input type="text" required name="login_username" value="<?php echo $login->login_username; ?>" class="form-control">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="">New Password</label>
                                                                <input type="password" required name="new_password" class="form-control">
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="">Confirm New Password </label>
                                                                <input type="password" required name="confirm_password" class="form-control">
                                                            </div>
                                                            <div class="text-right">
                                                                <button type="submit" name="update_user" class="btn btn-primary">Submit</button>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Main Footer -->
        <?php require_once('../partials/footer.php'); ?>
    </div>
    <!-- ./wrapper -->
    <?php require_once('../partials/scripts.php'); ?>
</body>


</html>