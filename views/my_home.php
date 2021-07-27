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
require_once('../partials/client_analytics.php');
checklogin();
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
                                <h1 class="m-0 text-dark">Dashboard</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="my_home">Home</a></li>
                                    <li class="breadcrumb-item active">Dashboard</li>
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
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-boxes"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Products</span>
                                        <span class="info-box-number"><?php echo $products; ?></span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-warehouse"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Stores</span>
                                        <span class="info-box-number"><?php echo $stores; ?></span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="info-box mb-3">
                                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clipboard-check"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">My Orders</span>
                                        <span class="info-box-number"><?php echo $orders; ?></span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                                <!-- /.info-box -->
                            </div>
                            <div class="card col-12">
                                <div class="table-responsive"><br>
                                    <h5 class="text-center text-bold text-primary">My Recent Customer Orders</h5>
                                    <table class="table m-0">
                                        <thead>
                                            <tr>
                                                <th>Customer </th>
                                                <th>Ordered Product</th>
                                                <th>Order Date</th>
                                                <th>Order Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $ret = "SELECT * FROM order_table ot
                                         INNER JOIN customer c ON ot.order_customer_id = c.customer_id 
                                         INNER JOIN product p ON  ot.order_product_id = p.product_id 
                                         INNER JOIN categories ct ON p.product_category_id = ct.categories_id
                                         WHERE ot.order_customer_id = '$my->customer_id'";
                                            $stmt = $mysqli->prepare($ret);
                                            $stmt->execute(); //ok
                                            $res = $stmt->get_result();
                                            while ($orders = $res->fetch_object()) {
                                            ?>
                                                <tr>
                                                    <td>
                                                        Name: <?php echo $orders->customer_name; ?><br>
                                                        Location: <?php echo $orders->customer_address; ?><br>
                                                        Email : <?php echo $orders->customer_email; ?><br>
                                                    </td>
                                                    <td>
                                                        Name: <?php echo $orders->product_name; ?><br>
                                                        Category: <?php echo $orders->categories_name; ?><br>
                                                    </td>
                                                    <td><?php echo date('d M Y', strtotime($orders->order_date)); ?></td>
                                                    <td><?php echo $orders->order_quantity; ?></td>
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
            <!-- Main Footer -->
            <?php require_once('../partials/footer.php'); ?>
    </div>
<?php
        } ?>
<!-- ./wrapper -->
<?php require_once('../partials/scripts.php'); ?>
</body>


</html>