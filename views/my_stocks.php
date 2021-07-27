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

/* Make Order */
if (isset($_POST['add_order'])) {
    $order_customer_id = $_POST['order_customer_id'];
    $order_date   = $_POST['order_date'];
    $order_product_id = $_POST['order_product_id'];
    $order_quantity = $_POST['order_quantity'];

    /* Stock Math */
    $initial_stock = $_POST['initial_stock'];
    $new_stock = $initial_stock - $order_quantity;
    $stock_id = $_POST['stock_id'];

    if ($order_quantity > $initial_stock) {
        $err = "Order Failed, No Enough Stock";
    } else {
        $stock_qry = "UPDATE stock SET stock_quantity =? WHERE stock_id = ?";
        $query = "INSERT INTO order_table (order_customer_id, order_date, order_product_id, order_quantity) VALUES(?,?,?,?)";

        $stmt = $mysqli->prepare($query);
        $stock_stmt = $mysqli->prepare($stock_qry);

        $rc = $stmt->bind_param('ssss', $order_customer_id, $order_date, $order_product_id, $order_quantity);
        $rc = $stock_stmt->bind_param('ss', $new_stock, $stock_id);

        $stmt->execute();
        $stock_stmt->execute();

        if ($stmt && $stock_stmt) {
            $success = "Order Submitted";
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
        $ret = "SELECT * FROM customer WHERE customer_login_id = '$login' ";
        $stmt = $mysqli->prepare($ret);
        $stmt->execute(); //ok
        $res = $stmt->get_result();
        while ($my = $res->fetch_object()) {
        ?>
            <!-- /.navbar -->
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-dark">Stocks</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="my_home">Home</a></li>
                                    <li class="breadcrumb-item"><a href="my_home">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Stocks</li>
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
                                <!-- End Modal -->
                                <div class="table-responsive">
                                    <hr>
                                    <table class="table m-0">
                                        <thead>
                                            <tr>
                                                <th>Store</th>
                                                <th>Product</th>
                                                <th>Stock Quantity</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $ret = "SELECT * FROM stock st
                                        INNER JOIN  store s ON st.stock_store_id = s.store_id
                                        INNER JOIN product p ON st.stock_product_id = p.product_id
                                        INNER JOIN categories c ON p.product_category_id = c.categories_id";
                                            $stmt = $mysqli->prepare($ret);
                                            $stmt->execute(); //ok
                                            $res = $stmt->get_result();
                                            while ($stocks = $res->fetch_object()) {
                                            ?>
                                                <tr>
                                                    <td>
                                                        Name: <?php echo $stocks->store_name; ?><br>
                                                        Location: <?php echo $stocks->store_location; ?>
                                                    </td>
                                                    <td>
                                                        Name: <?php echo $stocks->product_name; ?><br>
                                                        Category: <?php echo $stocks->categories_name; ?>
                                                    </td>
                                                    <td><?php echo $stocks->stock_quantity; ?></td>
                                                    <td>
                                                        <a data-toggle="modal" href="#edit-<?php echo $stocks->stock_id; ?>" class="badge bg-warning">
                                                            <i class="fas fa-clipboard-check"></i>
                                                            Make Order
                                                        </a>
                                                        <!-- Update Modal -->
                                                        <div class="modal fade" id="edit-<?php echo $stocks->stock_id; ?>">
                                                            <div class="modal-dialog  modal-lg">
                                                                <div class="modal-content" style="border: yellow 5px solid;">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Order <?php echo  $stocks->product_name; ?></h4>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form method="post" enctype="multipart/form-data" role="form">
                                                                            <div class="card-body">
                                                                                <div class="row">
                                                                                    <div class="form-group col-md-12">
                                                                                        <label for="">Order Quantity</label>
                                                                                        <input type="hidden" value="<?php echo $my->customer_id; ?>" required name="order_customer_id" class="form-control">
                                                                                        <input type="hidden" value="<?php echo date('d-M-Y'); ?>" required name="order_date" class="form-control">
                                                                                        <input type="hidden" value="<?php echo $stocks->product_id; ?>" required name="order_product_id" class="form-control">
                                                                                        <input type="hidden" value="<?php echo $stocks->stock_quantity; ?>" required name="initial_stock" class="form-control">
                                                                                        <input type="hidden" value="<?php echo $stocks->stock_id; ?>" required name="stock_id" class="form-control">
                                                                                        <input type="number" required name="order_quantity" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="text-right">
                                                                                <button type="submit" name="add_order" class="btn btn-primary">Submit</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
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
        <?php } ?>
        <!-- Main Footer -->
        <?php require_once('../partials/footer.php'); ?>
    </div>
    <!-- ./wrapper -->
    <?php require_once('../partials/scripts.php'); ?>
</body>


</html>