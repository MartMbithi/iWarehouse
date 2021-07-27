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

/* Add Customer */
if (isset($_POST['add_user'])) {
    $customer_name = $_POST['customer_name'];
    $customer_address  = $_POST['customer_address'];
    $customer_email  = $_POST['customer_email'];
    $customer_login_id = $sys_gen_id;

    /* Auth  */
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
            $success = "$customer_name Account Created";
        } else {
            $info = "Please Try Again Or Try Later";
        }
    }
}

/* Update User */
if (isset($_POST['update_user'])) {
    $customer_name = $_POST['customer_name'];
    $customer_address  = $_POST['customer_address'];
    $customer_email  = $_POST['customer_email'];
    $customer_id = $_POST['customer_id'];


    $query = "UPDATE customer SET customer_name =?, customer_address =?, customer_email =? WHERE customer_id =?";

    $stmt = $mysqli->prepare($query);

    $rc = $stmt->bind_param('ssss', $customer_name, $customer_address, $customer_email, $customer_id);

    $stmt->execute();

    if ($stmt) {
        $success = "$customer_name Account Updated";
    } else {
        $info = "Please Try Again Or Try Later";
    }
}


/* Delete User */
if (isset($_GET['delete'])) {
    $delete = $_GET['delete'];
    $auth = $_GET['auth'];

    $adn = "DELETE FROM customer WHERE customer_id=?";
    $auth_del = "DELETE FROM login WHERE login_id = ?";

    $stmt = $mysqli->prepare($adn);
    $auth_stmt = $mysqli->prepare($auth_del);

    $stmt->bind_param('s', $delete);
    $auth_stmt->bind_param('s', $auth);

    $stmt->execute();
    $auth_stmt->execute();

    $stmt->close();
    $auth_stmt->close();

    if ($stmt && $auth_stmt) {
        $success = "Deleted" && header("refresh:1; url=customers");
    } else {
        $info = "Please Try Again Or Try Later";
    }
}



require_once('../partials/head.php');
?>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        <!-- Navbar -->
        <?php require_once('../partials/navbar.php'); ?>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Customers</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="home">Home</a></li>
                                <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
                                <li class="breadcrumb-item active">Customers</li>
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
                        <div class="col-12">
                            <div class="text-right">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#add_modal"> <i class="fas fa-user-plus"></i> Add Customer</button>
                            </div>
                            <div class="table-responsive">
                                <hr>
                                <table class="table m-0">
                                    <thead>
                                        <tr>
                                            <th>Full Name </th>
                                            <th>Address</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $ret = "SELECT * FROM customer ";
                                        $stmt = $mysqli->prepare($ret);
                                        $stmt->execute(); //ok
                                        $res = $stmt->get_result();
                                        while ($customers = $res->fetch_object()) {
                                        ?>
                                            <tr>
                                                <td><?php echo $customers->customer_name; ?></td>
                                                <td><?php echo $customers->customer_address; ?></td>
                                                <td><?php echo $customers->customer_email; ?></td>
                                                <td>
                                                    <a href="customer?view=<?php echo $customers->customer_id; ?>" class="badge bg-success">
                                                        <i class="fas fa-user-cog"></i>
                                                        View
                                                    </a>
                                                    <a data-toggle="modal" href="#edit-<?php echo $customers->customer_id; ?>" class="badge bg-warning">
                                                        <i class="fas fa-user-edit"></i>
                                                        Update
                                                    </a>
                                                    <!-- Update Modal -->
                                                    <div class="modal fade" id="edit-<?php echo $customers->customer_id; ?>">
                                                        <div class="modal-dialog  modal-lg">
                                                            <div class="modal-content" style="border: yellow 5px solid;">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Update <?php echo $customers->customer_name; ?></h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="post" enctype="multipart/form-data" role="form">
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <div class="form-group col-md-12">
                                                                                    <label for="">Full Name</label>
                                                                                    <input type="text" required name="customer_name" value="<?php echo $customers->customer_name; ?>" class="form-control">
                                                                                    <input type="hidden" required name="customer_id" value="<?php echo $customers->customer_id; ?>" class="form-control">
                                                                                </div>
                                                                                <div class="form-group col-md-6">
                                                                                    <label for="">Address</label>
                                                                                    <input type="text" required name="customer_address" value="<?php echo $customers->customer_address; ?>" class="form-control">
                                                                                </div>
                                                                                <div class="form-group col-md-6">
                                                                                    <label for="">Email Address</label>
                                                                                    <input type="text" required name="customer_email" value="<?php echo $customers->customer_email; ?>" class="form-control">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="text-right">
                                                                            <button type="submit" name="update_user" class="btn btn-primary">Submit</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Modal -->
                                                    <a data-toggle="modal" href="#delete-<?php echo $customers->customer_id; ?>" class="badge bg-danger">
                                                        <i class="fas fa-trash"></i>
                                                        Delete
                                                    </a>
                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="delete-<?php echo $customers->customer_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content " style="border: red 4px solid;">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body text-center text-danger">
                                                                    <h4>Delete <?php echo $customers->customer_name; ?> ?</h4>
                                                                    <br>
                                                                    <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                                                                    <a href="customers?delete=<?php echo $customers->customer_id; ?>&auth=<?php echo $customers->customer_login_id; ?>" class="text-center btn btn-danger"> Delete </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Modal -->
                                                </td>
                                            </tr>
                                        <?php
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add Modal -->
        <div class="modal fade" id="add_modal">
            <div class="modal-dialog  modal-lg">
                <div class="modal-content" style="border: green 4px solid;">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Customer</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" enctype="multipart/form-data" role="form">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="">Full Name</label>
                                        <input type="text" required name="customer_name" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="">Address</label>
                                        <input type="text" required name="customer_address" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="">Email Address</label>
                                        <input type="text" required name="customer_email" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="">Login Username</label>
                                        <input type="text" required name="login_username" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="">Login Password</label>
                                        <input type="password" required name="login_password" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <button type="submit" name="add_user" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal -->

        <!-- Main Footer -->
        <?php require_once('../partials/footer.php'); ?>
    </div>
    <!-- ./wrapper -->
    <?php require_once('../partials/scripts.php'); ?>
</body>


</html>