<?php
session_start();

if (empty($_SESSION['is_admin_login'])) {
    echo "<script>location.href='index.php';</script>";
}

require_once '../include/connection.php';
require_once './assets/pages/admin-link.php';
require_once './assets/pages/admin-header.php';

if (isset($_POST['add'])) {

    $name = $_POST['name'];
    $type = $_POST['type'];

    if (mysqli_query($conn, "INSERT INTO category_master(category_type, category_name,category_status,category_date_create) 
        VALUES ('$type', '$name','Active', NOW())")) {

        echo "<script>iqwerty.toast.toast('Category added successfully.');</script>";
    } else {

        echo "<script>iqwerty.toast.toast('Unable to add category.');</script>";
    }
}

if (isset($_POST['update'])) {

    if (mysqli_query($conn, "UPDATE category_master SET category_name = '$_POST[name]', category_status = '$_POST[status]' WHERE category_id = '$_POST[id]'")) {

        echo "<script>iqwerty.toast.toast('Category updated successfully.');</script>";
    } else {

        echo "<script>iqwerty.toast.toast('Unable to process your request.');</script>";
    }
}



if (isset($_POST['delete'])) {

    if (mysqli_query($conn, "DELETE FROM category_master WHERE category_id = '$_POST[did]'")) {

        echo "<script>iqwerty.toast.toast('Category deleted successfully.');</script>";
    } else {

        echo "<script>iqwerty.toast.toast('Unable to delete category.');</script>";
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
                        <h3 class="mb-3">Manage Category</h1>
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
                                    <h5 class="modal-title" id="exampleModalLongTitle">Add Category</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body g-3 row">
                                    <div class="col-sm-12 col-lg-12 col-md-12 mt-3">
                                        <label class="form-label">Category Name</label>
                                        <input type="text" class="form-control" required name="name" pattern="^([A-Za-z]+[ ]?|[A-Za-z])+$" title="Only alphabets and space are allowed.">
                                    </div>
                                    <div class="col-sm-12 col-lg-12 col-md-12 mt-3">
                                        <label class="form-label">Type</label>
                                        <select class="form-control" id="validationCustom04" name="type" title="Please choose type">
                                            <option value="Shopping">Shopping</option>
                                            <option value="Customize">Customize</option>
                                        </select>
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
                            <th>Category Name</th>
                            <th>Status</th>
                            <th>Date Create</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $resData = mysqli_query($conn, "SELECT * FROM category_master");
                        if (mysqli_num_rows($resData) > 0) {

                            $count = 1;
                            while ($rowData = mysqli_fetch_assoc($resData)) {

                                echo "<tr>";
                                echo "<th>" . $count . "</th>";
                                echo "<td>" . $rowData['category_name'] . "</td>";
                                echo "<td>" . $rowData['category_status'] . "</td>";
                                echo "<td>" . date_format(date_create($rowData['category_date_create']), 'd M, Y') . "</td>";
                                echo "<td>";
                        ?>
                                <form method="POST">
                                    <!-- <a href="#" data-bs-toggle="modal" data-bs-target="#modal<?php echo $rowData['category_id']; ?>"><i class='fa fa-edit'></i></a> -->
                                    <!-- | -->
                                    <input type="hidden" name="did" value="<?php echo $rowData['category_id']; ?>" />
                                    <button style="background-color: transparent;border: none;" name="delete" onClick="return confirm('Are you sure you want to delete?')" type="submit"><i style="color: #0d6efd;" class="fa fa-trash"></i></button>
                                </form>
                                <?php
                                echo "</td>";
                                echo "</tr>";

                                $count++;

                                ?>


                                <div class="modal fade" id="modal<?php echo $rowData['category_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <form method="POST" enctype="multipart/form-data">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Category</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body g-3 row">
                                                    <div class="col-sm-12 col-lg-12 col-md-12 mt-3">
                                                        <label class="form-label">Product Name</label>
                                                        <input type="text" class="form-control" required name="name" value="<?php echo $rowData['category_name']; ?>" pattern="^([A-Za-z]+[ ]?|[A-Za-z])+$" title="Only alphabets and space are allowed.">
                                                    </div>
                                                    <div class="col-sm-12 col-lg-12 col-md-12 mt-3">
                                                        <label class="form-label">Status</label>
                                                        <select class="form-control" id="validationCustom04" name="status" title="Please choose status">
                                                            <option value="Active" <?php if ($rowData['category_status'] == 'Active') {
                                                                                        echo 'selected';
                                                                                    } ?>>Active</option>
                                                            <option value="In-Active" <?php if ($rowData['category_status'] == 'In-Active') {
                                                                                            echo 'selected';
                                                                                        } ?>>In-Active</option>
                                                        </select>
                                                    </div>


                                                    <input type="hidden" name="id" value="<?php echo $rowData['category_id']; ?>">


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