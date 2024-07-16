<?php
    session_start();

    if(empty($_SESSION['is_admin_login'])){
        echo "<script>location.href='index.php';</script>";
    }

    require_once '../include/connection.php';
    require_once './assets/pages/admin-link.php';
    require_once './assets/pages/admin-header.php';

    $user_id = 0;

    if(!empty($_GET['id'])){
        $user_id = $_GET['id'];
    }


    if(isset($_POST['delete'])){
       
        if (mysqli_query($conn, "DELETE FROM user_gallery WHERE gallery_id = '$_POST[did]'")){  
   
           echo "<script>iqwerty.toast.toast('Image deleted successfully.');</script>";     
       } else {
   
           echo "<script>iqwerty.toast.toast('Unable to delete image.');</script>";
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
                            <div class="col-9" >
                                <h3 class="mb-3">Manage Gallery</h1>
                            </div>

                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Image</th>
                                            <th>Date Create</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $resData = mysqli_query($conn, "SELECT * FROM user_gallery WHERE user_id = '$user_id'");
                                        if (mysqli_num_rows($resData) > 0) {

                                            $count = 1;
                                            while($rowData = mysqli_fetch_assoc($resData)) {
                                                
                                                echo "<tr>"; 
                                                echo "<th>".$count."</th>"; 
                                                echo "<td><img width='100' src='assets/images/user-image/".$rowData['image']."'></td>";
                                                echo "<td>".date_format(date_create($rowData['date_create']), 'd M, Y h.i a') . "</td>"; 
                                                echo "<td>";
                                                
                                                ?>
                                                
                                                
                                                <form method="POST">
                                                <a href="assets/images/user-image/<?php echo $rowData['image'];?>" download=""><i class="fa fa-download"></i></a> | 
                                                    <input type="hidden" name="did" value="<?php echo $rowData['gallery_id'];?>"/>
                                                    <button style="background-color: transparent;border: none;" name="delete" href= "user.php" onClick="return confirm('Are you sure you want to delete?')" type="submit"><i style="color: #0d6efd;" class="fa fa-trash"></i></button>
                                                </form>
                                                <?php
                                                echo "</td>";
                                                echo "</tr>"; 

                                                $count++;

                                                ?>
                                                

                                                    <div class="modal fade" id="modal<?php echo $rowData['user_id'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <form method="POST" enctype="multipart/form-data">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLongTitle">Edit User</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body g-3 row">
                                                                        <div class="col-sm-12 col-lg-6 col-md-12 mt-3">
                                                                            <label class="form-label">User Name</label>
                                                                            <input type="text" class="form-control" required name="name" title="Please enter name" value="<?php echo $rowData['user_name'];?>"  pattern="^([A-Za-z]+[ ]?|[A-Za-z])+$" title="Only alphabets and space are allowed.">
                                                                        </div>
                                                                        <div class="col-sm-12 col-lg-6 col-md-12 mt-3">
                                                                            <label class="form-label">Email id</label>
                                                                            <input type="text" class="form-control" required name="email" title="Please enter title" value="<?php echo $rowData['user_email_id'];?>">
                                                                        </div>
                                                                        <div class="col-sm-12 col-lg-6 col-md-12 mt-3">
                                                                            <label class="form-label">Phone Number</label>
                                                                            <input type="text" class="form-control" required name="phone" title="Please enter phone number" value="<?php echo $rowData['user_phone_number'];?>" pattern="[0-9]{10}" title="Accept 10 digit numbers only.">
                                                                        </div>
                                                                        <div class="col-sm-12 col-lg-6 col-md-12 mt-3">
                                                                            <label class="form-label">Pin code</label>
                                                                            <input type="text" class="form-control" required name="pin" title="Please enter phone number" value="<?php echo $rowData['pin_code'];?>" pattern="[0-9]{6}" title="Accept 10 digit numbers only.">
                                                                        </div>
                                                                        <div class="col-sm-12 col-lg-6 col-md-6 mt-3">
                                                                            <label class="form-label">Address line 1</label>
                                                                            <textarea class="form-control" required name="address_1" title="Please enter address"><?php echo $rowData['address_line_1'];?></textarea>
                                                                        </div>
                                                                        <div class="col-sm-12 col-lg-6 col-md-6 mt-3">
                                                                            <label class="form-label">Address line 2</label>
                                                                            <textarea class="form-control" required name="address_2" title="Please enter address"><?php echo $rowData['address_line_2'];?></textarea>
                                                                        </div>
                                                                        
                                                                        <div class="col-sm-12 col-lg-6 col-md-12 mt-3">
                                                                            <label class="form-label">City</label>
                                                                            <input type="text" class="form-control" required name="city" title="Please enter phone number" value="<?php echo $rowData['city'];?>">
                                                                        </div>

                                                                        <input type="hidden" name="id" value="<?php echo $rowData['user_id'];?>">

                                                                        <div class="col-sm-12 col-lg-6 col-md-6 mt-3">
                                                                            <label class="form-label">Status</label>
                                                                            <select class="form-control" id="validationCustom04" name="status" title="Please choose status">
                                                                                <option value="1" <?php if($rowData['user_status']){echo 'selected';}?>>Active</option>
                                                                                <option value="0" <?php if(!$rowData['user_status']){echo 'selected';}?>>In-Active</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit" href="user.php" class="btn btn-primary" name="update">Update</button>
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
                        </div>
                    </div>
                

                </main>
            </div>
        </div>
    
<?php


    require_once './assets/pages/admin-footer.php';
?>
