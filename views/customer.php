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
        $view = $_GET['view'];
        $ret = "SELECT * FROM customer WHERE customer_id = '$view' ";
        $stmt = $mysqli->prepare($ret);
        $stmt->execute(); //ok
        $res = $stmt->get_result();
        while ($customer = $res->fetch_object()) {
        ?>
            <!-- /.navbar -->

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-dark"><?php echo $customer->customer_name; ?> Profile</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="home">Home</a></li>
                                    <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="customers">Customers</a></li>
                                    <li class="breadcrumb-item active"><?php echo $customer->customer_name; ?></li>
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

                                        <h3 class="profile-username text-center"><?php echo $customer->customer_name; ?></h3>

                                        <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item">
                                                <b>Address : </b> <a class="float-right"><?php echo $customer->customer_address; ?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Email : </b> <a class="float-right"><?php echo $customer->customer_email; ?></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-8">
                                <div class="card card-warning card-outline">
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <!-- /.tab-pane -->
                                            <div class="tab-pane active" id="add_job">
                                                <form method="post" enctype="multipart/form-data" role="form">
                                                    <div class="row">
                                                        <?php
                                                        $user_login = $customer->customer_login_id;
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