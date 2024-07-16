<?php
    session_start();

    if(empty($_SESSION['is_admin_login'])){
        echo "<script>location.href='index.php';</script>";
    }

    require_once '../include/connection.php';
    require_once './assets/pages/admin-link.php';
    require_once './assets/pages/admin-header.php';

    if (isset($_POST['delete'])) {
        
        if (mysqli_query($conn, "DELETE FROM product_master WHERE event_id = '$_POST[did]'")){

            echo "<script>iqwerty.toast.toast('Event deleted successfully.');</script>";     
        } else {

            echo "<script>iqwerty.toast.toast('Unable to delete event.');</script>";
        }
    }

    if (isset($_POST['update'])) { 

        $title = addslashes($_POST['title']);
        $description = addslashes($_POST['description']);
        $status = $_POST['status'];

        if (!empty($_FILES['image']['name'])) {
            
            $imagePath = time() . "." . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

            if (move_uploaded_file($_FILES['image']['tmp_name'], "assets/images/events/" . $imagePath)) {

                if (mysqli_query($conn, "UPDATE events_master SET event_title = '$title', 
                    event_status = '$status', event_description = '$description',
                    event_date_update = NOW(), event_image = '$imagePath' WHERE event_id = '$_POST[id]'")) {

                    echo "<script>iqwerty.toast.toast('Event updated successfully.');</script>";     
                } else {

                    echo "<script>iqwerty.toast.toast('Unable to update event.');</script>";
                }
            
            } else { 

                echo "<script>iqwerty.toast.toast('Unable to upload image on server.');</script>";
            }
        } else {

            if (mysqli_query($conn, "UPDATE events_master SET event_title = '$title', 
                event_status = '$status', event_description = '$description',
                event_date_update = NOW() WHERE event_id = '$_POST[id]'")) {

                echo "<script>iqwerty.toast.toast('Event updated successfully.');</script>";     
            } else {

                echo "<script>iqwerty.toast.toast('Unable to update event.');</script>";
            }
        }
    }

    if(isset($_POST['add'])){

        $title = addslashes($_POST['title']);
        $description = addslashes($_POST['description']);

        $path_banner = time() . "." . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

        if (move_uploaded_file($_FILES['image']['tmp_name'], "assets/images/events/" . $path_banner)) {
            
            if(mysqli_query($conn, "INSERT INTO events_master(event_title, event_image, 
                event_status, event_date_create, event_description) 
                VALUES ('$title', '$path_banner', 1, NOW(), '$description')")){

                echo "<script>iqwerty.toast.toast('Event added successfully.');</script>";     
            }
            else{

                echo "<script>iqwerty.toast.toast('Unable to add event.');</script>";
            }
        } else {

            echo "<script>iqwerty.toast.toast('Unable to upload image on server.');</script>";
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
                                <h3 class="mb-3">Manage Events</h1>
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
                                            <h5 class="modal-title" id="exampleModalLongTitle">Add Event</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body g-3 row">
                                            <div class="col-sm-12 col-lg-12 col-md-12 mt-3">
                                                <label class="form-label">Event Title</label>
                                                <input type="text" class="form-control" required name="title" title="Please enter title">
                                            </div>
                                            <div class="col-sm-12 col-lg-12 col-md-12 mt-3">
                                                <label class="form-label">Image [1200x800]</label>
                                                <input type="file" class="form-control" required name="image" title="Please select image" accept="image/*">
                                            </div>
                                            <div class="col-sm-12 col-lg-12 col-md-12 mt-3">
                                                <label class="form-label">Event Description</label>
                                                <textarea class="form-control" required name="description" title="Please enter description"></textarea>
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
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Date Create</th>
                                            <th>Date Update</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $resData = mysqli_query($conn, "SELECT * FROM product_master");
                                        if (mysqli_num_rows($resData) > 0) {

                                            $count = 1;
                                            while($rowData = mysqli_fetch_assoc($resData)) {
                                                
                                                echo "<tr>"; 
                                                echo "<th>".$count."</th>"; 
                                                echo "<td><img src='assets/images/events/".$rowData['event_image']."' class='mr-2' width='70' height='50'></td>"; 
                                                echo "<td>".$rowData['event_title']."</td>"; 
                                                echo "<td>".$rowData['event_description']."</td>"; 
                                                echo "<td>"; 
                                                if ($rowData['event_status']) {
                                                    echo "Active";
                                                } else {
                                                    echo "In-Active";
                                                }
                                                echo "</td>"; 
                                                echo "<td>".date_format(date_create($rowData['event_date_create']), 'd M, Y') . "</td>"; 
                                                echo "<td>";
                                                if(!empty($rowData['event_date_update'])){
                                                    echo date_format(date_create($rowData['event_date_update']), 'd M, Y');
                                                }
                                                echo "</td>"; 
                                                echo "<td>";
                                                ?>
                                                <form method="POST">
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#modal<?php echo $rowData['event_id'];?>"><i class='fa fa-pen'></i></a> | 
                                                    <input type="hidden" name="did" value="<?php echo $rowData['event_id'];?>"/>
                                                    <button style="background-color: transparent;border: none;" name="delete" onClick="return confirm('Are you sure you want to delete?')" type="submit"><i style="color: #0d6efd;" class="fa fa-trash"></i></button>
                                                </form>
                                                <?php
                                                echo "</td>";
                                                echo "</tr>"; 

                                                $count++;

                                                ?>
                                                    <div class="modal fade" id="modal<?php echo $rowData['event_id'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <form method="POST" enctype="multipart/form-data">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLongTitle">Edit Event</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body g-3 row">
                                                                        <div class="col-sm-12 col-lg-12 col-md-12 mt-3">
                                                                            <label class="form-label">Event Title</label>
                                                                            <input type="text" class="form-control" required name="title" title="Please enter title" value="<?php echo $rowData['event_title'];?>">
                                                                        </div>
                                                                        <div class="col-sm-12 col-lg-12 col-md-12 mt-3">
                                                                            <label class="form-label">Event Description</label>
                                                                            <textarea class="form-control" required name="description" title="Please enter description"><?php echo $rowData['event_description'];?></textarea>
                                                                        </div>
                                                                        <div class="col-sm-12 col-lg-6 col-md-6 mt-3">
                                                                            <label class="form-label">Image [1200x800]</label>
                                                                            <input type="file" class="form-control" name="image" title="Please select image" accept="image/*">
                                                                        </div>

                                                                        <input type="hidden" name="id" value="<?php echo $rowData['event_id'];?>">

                                                                        <div class="col-sm-12 col-lg-6 col-md-6 mt-3">
                                                                            <label class="form-label">Status</label>
                                                                            <select class="form-control" id="validationCustom04" name="status" title="Please choose status">
                                                                                <option value="1" <?php if($rowData['event_status']){echo 'selected';}?>>Active</option>
                                                                                <option value="0" <?php if(!$rowData['event_status']){echo 'selected';}?>>In-Active</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary" name="update">Update</button>
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
                    </div>
                </main>
            </div>
        </div>
    
<?php

    require_once './assets/pages/admin-footer.php';
?>

