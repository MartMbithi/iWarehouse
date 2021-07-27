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

/* Add Product */
if (isset($_POST['add_prod'])) {
    $product_name = $_POST['product_name'];
    $product_description   = $_POST['product_description'];
    $product_category_id = $_POST['product_category_id'];
    $product_image = time() . $_FILES['product_image']['name'];
    move_uploaded_file($_FILES["product_image"]["tmp_name"], "../public/uploads/sys_data/" . $product_image);
    /* Prevent Double Entries */
    $sql = "SELECT * FROM  product WHERE product_name = '$product_name'   ";
    $res = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        if ($product_name == $row['product_name']) {
            $err =  "Product Name Already Exists";
        }
    } else {
        $query = "INSERT INTO product (product_name, product_description, product_category_id, product_image) VALUES(?,?,?,?)";
        $stmt = $mysqli->prepare($query);
        $rc = $stmt->bind_param('ssss', $product_name, $product_description, $product_category_id, $product_image);
        $stmt->execute();

        if ($stmt) {
            $success = "$product_name Added";
        } else {
            $info = "Please Try Again Or Try Later";
        }
    }
}

/* Update Product */
if (isset($_POST['update_prod'])) {
    $product_name = $_POST['product_name'];
    $product_description   = $_POST['product_description '];
    $product_id = $_POST['product_id'];
    $product_image = time() . $_FILES['product_image']['name'];
    move_uploaded_file($_FILES["product_image"]["tmp_name"], "../public/uploads/sys_data/" . $product_image);

    $query = "UPDATE  product SET product_name =?, product_description =?, product_image =? WHERE product_id =?";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('ssss', $product_name, $product_description, $product_image, $product_id);
    $stmt->execute();

    if ($stmt) {
        $success = "$product_name Updated";
    } else {
        $info = "Please Try Again Or Try Later";
    }
}

/* Delete Category */
if (isset($_GET['delete'])) {
    $delete = $_GET['delete'];
    $adn = "DELETE FROM product WHERE product_id =?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('s', $delete);
    $stmt->execute();
    $stmt->close();
    if ($stmt) {
        $success = "Deleted" && header("refresh:1; url=products");
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
                            <h1 class="m-0 text-dark">Products</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="home">Home</a></li>
                                <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
                                <li class="breadcrumb-item active">Products</li>
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
                                <button class="btn btn-primary" data-toggle="modal" data-target="#add_modal"> <i class="fas fa-plus"></i> Add Product</button>
                            </div>
                            <div class="table-responsive">
                                <hr>
                                <table class="table m-0">
                                    <thead>
                                        <tr>
                                            <th>Product Image</th>
                                            <th>Product Name</th>
                                            <th>Product Category</th>
                                            <th>Product Details</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $ret = "SELECT * FROM product p
                                        INNER JOIN categories c ON p.product_category_id = c.categories_id";
                                        $stmt = $mysqli->prepare($ret);
                                        $stmt->execute(); //ok
                                        $res = $stmt->get_result();
                                        while ($products = $res->fetch_object()) {
                                        ?>
                                            <tr>
                                                <td>
                                                    <img src="../public/uploads/sys_data/<?php echo $products->product_image; ?>" height="150" width="150" class="img-fluid">
                                                </td>
                                                <td><?php echo $products->product_name; ?></td>
                                                <td><?php echo $products->categories_name; ?></td>
                                                <td><?php echo $products->product_description; ?></td>
                                                <td>
                                                    <a data-toggle="modal" href="#edit-<?php echo $products->product_id; ?>" class="badge bg-warning">
                                                        <i class="fas fa-edit"></i>
                                                        Update
                                                    </a>
                                                    <!-- Update Modal -->
                                                    <div class="modal fade" id="edit-<?php echo $products->product_id; ?>">
                                                        <div class="modal-dialog  modal-lg">
                                                            <div class="modal-content" style="border: yellow 5px solid;">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Update <?php echo $products->product_name; ?></h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="post" enctype="multipart/form-data" role="form">
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <div class="form-group col-md-12">
                                                                                    <label for="">Name</label>
                                                                                    <input type="text" required name="product_name" value="<?php echo $products->product_name; ?>" class="form-control">
                                                                                    <input type="hidden" required name="product_id" value="<?php echo $products->product_id; ?>" class="form-control">
                                                                                </div>
                                                                                <div class="form-group col-md-12">
                                                                                    <label for="">Product Image</label>
                                                                                    <div class="input-group">
                                                                                        <div class="custom-file">
                                                                                            <input type="file" required accept=".jpeg, .jpg, .png" name="product_image" class="custom-file-input" id="exampleInputFile">
                                                                                            <label class="custom-file-label " for="exampleInputFile">Choose file</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group col-md-12">
                                                                                    <label for="">Product Details</label>
                                                                                    <textarea rows="5" type="text" required name="product_description" class="form-control"><?php echo $products->product_description; ?></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="text-right">
                                                                            <button type="submit" name="update_prod" class="btn btn-primary">Submit</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Modal -->
                                                    <a data-toggle="modal" href="#delete-<?php echo $products->product_id; ?>" class="badge bg-danger">
                                                        <i class="fas fa-trash"></i>
                                                        Delete
                                                    </a>
                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="delete-<?php echo $products->product_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content " style="border: red 4px solid;">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body text-center text-danger">
                                                                    <h4>Delete <?php echo $products->product_name; ?> ?</h4>
                                                                    <br>
                                                                    <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                                                                    <a href="products?delete=<?php echo $products->product_id; ?>" class="text-center btn btn-danger"> Delete </a>
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
                        <h4 class="modal-title">Add Product</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" enctype="multipart/form-data" role="form">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="">Name</label>
                                        <input type="text" required name="product_name" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="">Product Category</label>
                                        <select class="form-control" name="product_category_id">
                                            <?php
                                            $ret = "SELECT * FROM categories ";
                                            $stmt = $mysqli->prepare($ret);
                                            $stmt->execute(); //ok
                                            $res = $stmt->get_result();
                                            while ($category = $res->fetch_object()) {
                                            ?>
                                                <option value="<?php echo $category->categories_id; ?>"><?php echo $category->categories_name; ?></option>
                                            <?php
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="">Product Image</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" required accept=".jpeg, .jpg, .png" name="product_image" class="custom-file-input" id="exampleInputFile">
                                                <label class="custom-file-label " for="exampleInputFile">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="">Product Details</label>
                                        <textarea rows="5" type="text" required name="product_description" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <button type="submit" name="add_prod" class="btn btn-primary">Submit</button>
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