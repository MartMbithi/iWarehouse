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

/* Add Stock */
if (isset($_POST['add_stock'])) {
    $stock_product_id = $_POST['stock_product_id'];
    $stock_quantity  = $_POST['stock_quantity'];
    $stock_store_id = $_POST['stock_store_id'];

    $query = "INSERT INTO stock (stock_product_id, stock_quantity, stock_store_id ) VALUES(?,?,?)";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('sss', $stock_product_id, $stock_quantity, $stock_store_id);
    $stmt->execute();

    if ($stmt) {
        $success = "Stock Added";
    } else {
        $info = "Please Try Again Or Try Later";
    }
}

/* Update Stock */
if (isset($_POST['update_stock'])) {
    $stock_id = $_POST['stock_id'];
    $stock_quantity  = $_POST['stock_quantity'];

    $query = "UPDATE  stock  SET stock_quantity =?  WHERE stock_id = ?";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('ss', $stock_quantity, $stock_id);
    $stmt->execute();

    if ($stmt) {
        $success = "Stock Updated";
    } else {
        $info = "Please Try Again Or Try Later";
    }
}

/* Delete Stock */
if (isset($_GET['delete'])) {
    $delete = $_GET['delete'];
    $adn = "DELETE FROM stock WHERE stock_id =?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('s', $delete);
    $stmt->execute();
    $stmt->close();
    if ($stmt) {
        $success = "Deleted" && header("refresh:1; url=stocks");
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
                            <h1 class="m-0 text-dark">Stocks</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="home">Home</a></li>
                                <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
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
                            <div class="text-right">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#add_modal"> <i class="fas fa-plus"></i> Add Stock</button>
                            </div>
                            <!-- Add Modal -->
                            <div class="modal fade" id="add_modal">
                                <div class="modal-dialog  modal-lg">
                                    <div class="modal-content" style="border: green 4px solid;">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Add Stock</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" enctype="multipart/form-data" role="form">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label for="">Store Name</label>
                                                            <select type="text" required name="stock_store_id" class="form-control">
                                                                <?php
                                                                $ret = "SELECT * FROM store ";
                                                                $stmt = $mysqli->prepare($ret);
                                                                $stmt->execute(); //ok
                                                                $res = $stmt->get_result();
                                                                while ($store = $res->fetch_object()) {
                                                                ?>
                                                                    <option value="<?php echo $store->store_id; ?>"><?php echo $store->store_name; ?></option>
                                                                <?php
                                                                } ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="">Product Name</label>
                                                            <select type="text" required name="stock_product_id" class="form-control">
                                                                <?php
                                                                $ret = "SELECT * FROM product";
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
                                                        <div class="form-group col-md-12">
                                                            <label for="">Stock Quantity</label>
                                                            <input type="number" required name="stock_quantity" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <button type="submit" name="add_stock" class="btn btn-primary">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                                        <i class="fas fa-edit"></i>
                                                        Update
                                                    </a>
                                                    <!-- Update Modal -->
                                                    <div class="modal fade" id="edit-<?php echo $stocks->stock_id; ?>">
                                                        <div class="modal-dialog  modal-lg">
                                                            <div class="modal-content" style="border: yellow 5px solid;">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Update <?php echo  $stocks->product_name; ?> Stocks</h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="post" enctype="multipart/form-data" role="form">
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <div class="form-group col-md-12">
                                                                                    <label for="">Stock Quantity</label>
                                                                                    <input type="number" required name="stock_quantity" value="<?php echo $stocks->stock_quantity; ?>" class="form-control">
                                                                                    <input type="hidden" value="<?php echo $stocks->stock_id; ?>" required name="stock_id" class="form-control">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="text-right">
                                                                            <button type="submit" name="update_stock" class="btn btn-primary">Submit</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Modal -->
                                                    <a data-toggle="modal" href="#delete-<?php echo $stocks->stock_id; ?>" class="badge bg-danger">
                                                        <i class="fas fa-trash"></i>
                                                        Delete
                                                    </a>
                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="delete-<?php echo $stocks->stock_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content " style="border: red 4px solid;">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body text-center text-danger">
                                                                    <h4>Delete <?php echo $stocks->product_name; ?> Stocks ?</h4>
                                                                    <br>
                                                                    <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                                                                    <a href="stocks?delete=<?php echo $stocks->stock_id; ?>" class="text-center btn btn-danger"> Delete </a>
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