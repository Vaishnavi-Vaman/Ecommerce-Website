<?php
session_start();

if (empty($_SESSION['is_admin_login'])) {
    echo "<script>location.href='index.php';</script>";
}

require_once '../include/connection.php';
require_once './assets/pages/admin-link.php';
require_once './assets/pages/admin-header.php';

if (isset($_POST['add'])) {

    $path_banner = time() . "." . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

    $name = $_POST['name'];
    $price = $_POST['price'];

    if (move_uploaded_file($_FILES['image']['tmp_name'], "assets/images/materials/" . $path_banner)) {

        if (mysqli_query($conn, "INSERT INTO material_master(material_name,material_image,material_price,
                material_status,material_date_create) 
                VALUES ('$name','$path_banner','$price', 'Active', NOW())")) {

            echo "<script>iqwerty.toast.toast('Material added successfully.');</script>";
        } else {

            echo "<script>iqwerty.toast.toast('Unable to add material.');</script>";
        }
    } else {

        echo "<script>iqwerty.toast.toast('Unable to upload image on server.');</script>";
    }
}

if (isset($_POST['update'])) {

    if (mysqli_query($conn, "UPDATE product_master SET product_status = '$_POST[status]' WHERE product_id = '$_POST[id]'")) {

        echo "<script>iqwerty.toast.toast('Status updated successfully.');</script>";
    } else {

        echo "<script>iqwerty.toast.toast('Unable to process your request.');</script>";
    }
}



if (isset($_POST['delete'])) {

    if (mysqli_query($conn, "DELETE FROM material_master WHERE material_id = '$_POST[did]'")) {

        echo "<script>iqwerty.toast.toast('Material deleted successfully.');</script>";
    } else {

        echo "<script>iqwerty.toast.toast('Unable to delete material.');</script>";
    }
}

?>


<div id="layoutSidenav">
    <?php

    require_once './assets/pages/admin-sidebar.php';
    ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid p-4">
                <div class="row">
                    <div class="col-9">
                        <h3 class="mb-3">Manage Material</h1>
                    </div>
                    <div class="col-3 text-end">
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#add">Add New</button>
                    </div>
                </div>
                <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form method="POST" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Add Material</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body g-3 row">
                                    <div class="col-sm-12 col-lg-12 col-md-12 mt-3">
                                        <label class="form-label">Image</label>
                                        <input type="file" class="form-control" required name="image" title="Please select image" accept="image/*">
                                    </div>
                                    <div class="col-sm-12 col-lg-12 col-md-12 mt-3">
                                        <label class="form-label">Material Name</label>
                                        <input type="text" class="form-control" required name="name" pattern="^([A-Za-z]+[ ]?|[A-Za-z])+$" title="Only alphabets and space are allowed.">
                                    </div>
                                    <div class="col-sm-12 col-lg-12 col-md-12 mt-3">
                                        <label class="form-label">Price</label>
                                        <input type="text" class="form-control" required name="price" pattern="[0-9]*" title="Accept numbers only.">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="add">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Image</th>
                            <th>Material Name</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Date Create</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $resData = mysqli_query($conn, "SELECT * FROM material_master");
                        if (mysqli_num_rows($resData) > 0) {

                            $count = 1;
                            while ($rowData = mysqli_fetch_assoc($resData)) {

                                echo "<tr>";
                                echo "<th>" . $count . "</th>";
                                echo "<td><img src='assets/images/materials/" . $rowData['material_image'] . "' class='mr-2' width='70' height='50'></td>";
                                echo "<td>" . $rowData['material_name'] . "</td>";
                                echo "<td>" . number_format($rowData['material_price'], 2) . "</td>";
                                echo "<td>" . $rowData['material_status'] . "</td>";
                                echo "<td>" . date_format(date_create($rowData['material_date_create']), 'd M, Y') . "</td>";
                                echo "<td>";
                        ?>
                                <form method="POST">
                                    <input type="hidden" name="did" value="<?php echo $rowData['material_id']; ?>" />
                                    <button style="background-color: transparent;border: none;" name="delete" onClick="return confirm('Are you sure you want to delete?')" type="submit"><i style="color: #0d6efd;" class="fa fa-trash"></i></button>
                                </form>
                                <?php
                                echo "</td>";
                                echo "</tr>";

                                $count++;

                                ?>


                                <div class="modal fade" id="modal<?php echo $rowData['product_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <form method="POST" enctype="multipart/form-data">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Product</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body g-3 row">
                                                    <div class="col-sm-12 col-lg-12 col-md-12 mt-3">
                                                        <label class="form-label">Status</label>
                                                        <select class="form-control" id="validationCustom04" name="status" title="Please choose status">
                                                            <option value="1" <?php if ($rowData['product_status']) {
                                                                                    echo 'selected';
                                                                                } ?>>Active</option>
                                                            <option value="0" <?php if (!$rowData['product_status']) {
                                                                                    echo 'selected';
                                                                                } ?>>In-Active</option>
                                                        </select>
                                                    </div>


                                                    <input type="hidden" name="id" value="<?php echo $rowData['product_id']; ?>">


                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" href="view-product.php" class="btn btn-primary" name="update">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>


                <style>
                    table,
                    td,
                    th {
                        border: 1px solid #ddd;
                        text-align: left;
                    }

                    table {
                        border-collapse: collapse;
                        width: 100%;
                    }

                    th,
                    td {
                        padding: 15px;
                    }
                </style>


        </main>
    </div>
</div>

<?php


require_once './assets/pages/admin-footer.php';
?>