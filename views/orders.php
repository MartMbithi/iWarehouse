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

/* Update Order */
if (isset($_POST['update_order'])) {
    $order_date   = $_POST['order_date'];
    $order_quantity = $_POST['order_quantity'];
    $order_id = $_POST['order_id'];

    $query = "UPDATE  order_table  SET order_date =?, order_quantity =? WHERE order_id = ?";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('sss', $order_date, $order_quantity, $order_id);
    $stmt->execute();

    if ($stmt) {
        $success = "Order Updated";
    } else {
        $info = "Please Try Again Or Try Later";
    }
}

/* Delete Order */
if (isset($_GET['delete'])) {
    $delete = $_GET['delete'];
    $adn = "DELETE FROM order_table WHERE order_id =?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('s', $delete);
    $stmt->execute();
    $stmt->close();
    if ($stmt) {
        $success = "Deleted" && header("refresh:1; url=orders");
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
                            <h1 class="m-0 text-dark">Orders</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="home">Home</a></li>
                                <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
                                <li class="breadcrumb-item active">Orders</li>
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
                            <!-- <div class="text-right">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#add_modal"> <i class="fas fa-plus"></i> Add Customer Order</button>
                            </div>
                            <div class="modal fade" id="add_modal">
                                <div class="modal-dialog  modal-lg">
                                    <div class="modal-content" style="border: green 4px solid;">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Add Customer Order</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" enctype="multipart/form-data" role="form">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label for="">Customer Name</label>
                                                            <select type="text" required name="order_customer_id" class="form-control">
                                                                <?php
                                                                $ret = "SELECT * FROM customer ";
                                                                $stmt = $mysqli->prepare($ret);
                                                                $stmt->execute(); //ok
                                                                $res = $stmt->get_result();
                                                                while ($customers = $res->fetch_object()) {
                                                                ?>
                                                                    <option value="<?php echo $customers->customer_id; ?>"><?php echo $customers->customer_name; ?></option>
                                                                <?php
                                                                } ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="">Product Name</label>
                                                            <select type="text" required name="order_product_id" class="form-control">
                                                                <?php
                                                                $ret = "SELECT * FROM stock st
                                                                INNER JOIN product p ON st.stock_product_id = p.product_id ";
                                                                $stmt = $mysqli->prepare($ret);
                                                                $stmt->execute(); //ok
                                                                $res = $stmt->get_result();
                                                                while ($product = $res->fetch_object()) {
                                                                ?>
                                                                    <option value="<?php echo $product->product_id; ?>"><?php echo $product->product_name; ?></option>
                                                                <?php
                                                                } ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="">Order Quantity</label>
                                                            <input type="number" required name="order_quantity" class="form-control">

                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="">Order Date</label>
                                                            <input type="date" required name="order_date" class="form-control">
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
                            </div> -->
                            <div class="table-responsive">
                                <hr>
                                <table class="table m-0">
                                    <thead>
                                        <tr>
                                            <th>Customer </th>
                                            <th>Ordered Product</th>
                                            <th>Order Date</th>
                                            <th>Order Quantity</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $ret = "SELECT * FROM order_table ot
                                         INNER JOIN customer c ON ot.order_customer_id = c.customer_id 
                                         INNER JOIN product p ON  ot.order_product_id = p.product_id 
                                         INNER JOIN categories ct ON p.product_category_id = ct.categories_id";
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
                                                <td>
                                                    <a data-toggle="modal" href="#edit-<?php echo $orders->order_id; ?>" class="badge bg-warning">
                                                        <i class="fas fa-edit"></i>
                                                        Update
                                                    </a>
                                                    <!-- Update Modal -->
                                                    <div class="modal fade" id="edit-<?php echo $orders->order_id; ?>">
                                                        <div class="modal-dialog  modal-lg">
                                                            <div class="modal-content" style="border: yellow 5px solid;">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Update <?php echo  $orders->product_name; ?> Order</h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="post" enctype="multipart/form-data" role="form">
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <div class="form-group col-md-6">
                                                                                    <label for="">Order Quantity</label>
                                                                                    <input type="number" required name="order_quantity" value="<?php echo $orders->order_quantity; ?>" class="form-control">
                                                                                    <input type="hidden" value="<?php echo $orders->order_id; ?>" required name="order_id" class="form-control">
                                                                                </div>
                                                                                <div class="form-group col-md-6">
                                                                                    <label for="">Order Date</label>
                                                                                    <input type="date" required name="order_date" value="<?php echo $orders->order_date; ?>" class="form-control">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="text-right">
                                                                            <button type="submit" name="update_order" class="btn btn-primary">Submit</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Modal -->
                                                    <a data-toggle="modal" href="#delete-<?php echo $orders->order_id; ?>" class="badge bg-danger">
                                                        <i class="fas fa-trash"></i>
                                                        Delete
                                                    </a>
                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="delete-<?php echo $orders->order_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content " style="border: red 4px solid;">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body text-center text-danger">
                                                                    <h4>Delete <?php echo $orders->product_name; ?> Order ?</h4>
                                                                    <br>
                                                                    <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                                                                    <a href="orders?delete=<?php echo $orders->order_id; ?>" class="text-center btn btn-danger"> Delete </a>
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
        <!-- Main Footer -->
        <?php require_once('../partials/footer.php'); ?>
    </div>
    <!-- ./wrapper -->
    <?php require_once('../partials/scripts.php'); ?>
</body>


</html>