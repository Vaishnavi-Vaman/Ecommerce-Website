<?php
    session_start();

    if(empty($_SESSION['is_admin_login'])){
        echo "<script>location.href='index.php';</script>";
    }

    require_once '../include/connection.php';
    require_once './assets/pages/admin-link.php';
    require_once './assets/pages/admin-header.php';

    if(isset($_POST['add'])){ 
        
        $path_banner_1 = "1".time() . "." . pathinfo($_FILES['image_1']['name'], PATHINFO_EXTENSION);
        $path_banner_2 = "2".time() . "." . pathinfo($_FILES['image_2']['name'], PATHINFO_EXTENSION);
        $path_banner_3 = "3".time() . "." . pathinfo($_FILES['image_3']['name'], PATHINFO_EXTENSION);

        $name = $_POST['name'];
        $price = $_POST['price'];
        $description = addslashes($_POST['description']);
        $category = $_POST['category'];
        $type = $_POST['type'];
        $gender = $_POST['gender'];

        $i1 = move_uploaded_file($_FILES['image_1']['tmp_name'], "assets/images/products/" . $path_banner_1);
        $i2 = move_uploaded_file($_FILES['image_2']['tmp_name'], "assets/images/products/" . $path_banner_2);
        $i3 = move_uploaded_file($_FILES['image_3']['tmp_name'], "assets/images/products/" . $path_banner_3);

        if ($i1&&$i2&&$i3) {
            
            if(mysqli_query($conn, "INSERT INTO product_master(product_image,product_image_2,product_image_3,
                product_name,product_price,product_description,category_id, product_status, type, gender, product_date_create) 
                VALUES ('$path_banner_1','$path_banner_2','$path_banner_3','$name','$price','$description','$category', 'Active', '$type', '$gender', NOW())")){

                echo "<script>iqwerty.toast.toast('Product added successfully.');</script>";     
            }
            else{

                echo "<script>iqwerty.toast.toast('Unable to add product.');</script>";
            }
        } else {

            echo "<script>iqwerty.toast.toast('Unable to upload image on server.');</script>";
        }
    }

    if(isset($_POST['update'])){

        if(mysqli_query($conn, "UPDATE product_master SET product_status = '$_POST[status]' WHERE product_id = '$_POST[id]'")){

            echo "<script>iqwerty.toast.toast('Status updated successfully.');</script>";
        } else{

            echo "<script>iqwerty.toast.toast('Unable to process your request.');</script>";
        }
    }



    if(isset($_POST['delete'])){
       
        if (mysqli_query($conn, "DELETE FROM product_master WHERE product_id = '$_POST[did]'")){
   
           echo "<script>iqwerty.toast.toast('Product deleted successfully.');</script>";     
       } else {
   
           echo "<script>iqwerty.toast.toast('Unable to delete product.');</script>";
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
                                <h3 class="mb-3">Manage Products</h1>
                            </div>
                            <div class="col-3 text-end">
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#add">Add New</button>
                            </div>
                        </div>
                        <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Add Product</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body g-3 row">
                                            <div class="col-sm-12 col-lg-4 col-md-12 mt-3">
                                                <label class="form-label">Image 1</label>
                                                <input type="file" class="form-control" required name="image_1" title="Please select image" accept="image/*">
                                            </div>
                                            <div class="col-sm-12 col-lg-4 col-md-12 mt-3">
                                                <label class="form-label">Image 2</label>
                                                <input type="file" class="form-control" required name="image_2" title="Please select image" accept="image/*">
                                            </div>
                                            <div class="col-sm-12 col-lg-4 col-md-12 mt-3">
                                                <label class="form-label">Image 3</label>
                                                <input type="file" class="form-control" required name="image_3" title="Please select image" accept="image/*">
                                            </div>
                                            <div class="col-sm-12 col-lg-6 col-md-12 mt-3">
                                                <label class="form-label">Product Name</label>
                                                <input type="text" class="form-control" required name="name"  title="Only alphabets and space are allowed.">
                                            </div>
                                            <div class="col-sm-12 col-lg-3 col-md-12 mt-3">
                                                <label class="form-label">Product Price</label>
                                                <input type="text" class="form-control" required name="price" pattern="[0-9]*" title="Accept numbers only.">
                                            </div>
                                            
                                            <div class="col-sm-12 col-lg-3 col-md-6 mt-3">
                                                <label class="form-label">Category</label>
                                                <select class="form-control" required id="categorySelect" name="category" title="Please choose status">
                                                    <option value="">Choose</option>
                                                    <?php
                                                        $resCats = mysqli_query($conn, "SELECT * FROM category_master");
                                                        if(mysqli_num_rows($resCats)>0){
                                                            while($rowCats = mysqli_fetch_assoc($resCats)){
                                                                echo "<option value='".$rowCats['category_id']."'>".$rowCats['category_name']."</option>";
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-12 col-lg-12 col-md-12 mt-3">
                                                <label class="form-label">Product Description</label>
                                                <textarea class="form-control" required name="description" title="Please enter product name"></textarea>
                                            </div>
                                            <div class="col-sm-12 col-lg-6 col-md-12 mt-3" id="typeField" style="display: none;">
                                                <label class="form-label">Product Type</label>
                                                <select class="form-control" name="type" title="Please choose">
                                                    <option value="">Choose</option>
                                                    <option value="Shirt">Shirt</option>
                                                    <option value="Pant">Pant</option>
                                                    <option value="Saree">Saree</option>
                                                    <option value="Jacket">Jacket</option>
                                                    <option value="Tshirt">Tshirt</option>
                                                    <option value="Trouser">Trouser</option>
                                                    <option value="Kurti & Dress">Kurti & Dress</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-12 col-lg-6 col-md-12 mt-3" id="genderField" style="display: none;">
                                                <label class="form-label">Gender</label>
                                                <select class="form-control" name="gender" title="Please choose">
                                                    <option value="">Choose</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
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
                                            <th>Image 1</th>
                                            <th>Image 2</th>
                                            <th>Image 3</th>
                                            <th>Category</th>
                                            <th>Product Name</th>
                                            <th>Price</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Type</th>
                                            <th>Gender</th>
                                            <th>Date Create</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $resData = mysqli_query($conn, "SELECT p.*, c.category_id,c.category_name FROM product_master p, category_master c WHERE p.category_id = c.category_id");
                                        if (mysqli_num_rows($resData) > 0) {

                                            $count = 1;
                                            while($rowData = mysqli_fetch_assoc($resData)) {
                                                
                                                echo "<tr>"; 
                                                echo "<th>".$count."</th>"; 
                                                echo "<td><img src='assets/images/products/".$rowData['product_image']."' class='mr-2' width='70' height='50'></td>"; 
                                                echo "<td><img src='assets/images/products/".$rowData['product_image_2']."' class='mr-2' width='70' height='50'></td>"; 
                                                echo "<td><img src='assets/images/products/".$rowData['product_image_3']."' class='mr-2' width='70' height='50'></td>"; 
                                                echo "<td>".$rowData['category_name']."</td>";
                                                echo "<td>".$rowData['product_name']."</td>";
                                                echo "<td>".number_format($rowData['product_price'],2)."</td>"; 
                                                echo "<td>".$rowData['product_description']."</td>";
                                                echo "<td>".$rowData['product_status']."</td>"; 
                                                echo "<td>".$rowData['type']."</td>";
                                                echo "<td>".$rowData['gender']."</td>";
                                                echo "<td>".date_format(date_create($rowData['product_date_create']), 'd M, Y') . "</td>"; 
                                                echo "<td>";
                                                ?>
                                                <form method="POST">
                                                    <input type="hidden" name="did" value="<?php echo $rowData['product_id'];?>"/>
                                                    <button style="background-color: transparent;border: none;" name="delete" onClick="return confirm('Are you sure you want to delete?')" type="submit"><i style="color: #0d6efd;" class="fa fa-trash"></i></button>
                                                </form>
                                                <?php
                                                echo "</td>";
                                                echo "</tr>"; 

                                                $count++;

                                                ?>
                                                

                                                    <div class="modal fade" id="modal<?php echo $rowData['product_id'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                                <option value="1" <?php if($rowData['product_status']){echo 'selected';}?>>Active</option>
                                                                                <option value="0" <?php if(!$rowData['product_status']){echo 'selected';}?>>In-Active</option>
                                                                            </select>
                                                                        </div>
                                                                        

                                                                        <input type="hidden" name="id" value="<?php echo $rowData['product_id'];?>">

                                                                        
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
                            table, td, th {
                                border: 1px solid #ddd;
                                text-align: left;
                            }

                            table {
                                border-collapse: collapse;
                                width: 100%;
                            }

                                th, td {
                                padding: 15px;
                            }
                        </style>
                

                </main>
            </div>
        </div>
    
        <script>
    document.getElementById('categorySelect').addEventListener('change', function() {
        var selectedCategory = this.value;
        var typeField = document.getElementById('typeField');
        var genderField = document.getElementById('genderField');

        if (selectedCategory === '26') {
            typeField.style.display = 'block';
            genderField.style.display = 'block';
        } else {
            typeField.style.display = 'none';
            genderField.style.display = 'none';
        }
    });
</script>
<?php


    require_once './assets/pages/admin-footer.php';
?>
