<?php
    session_start();

    if(empty($_SESSION['is_admin_login'])){
        echo "<script>location.href='index.php';</script>";
    }

    require_once '../includes/connection.php';
    require_once './assets/pages/admin-link.php';
    require_once './assets/pages/admin-header.php';

    if (isset($_GET['did'])) {
        
        if (mysqli_query($conn, "DELETE FROM user_master WHERE user_id = '$_GET[did]'")){

            echo "<script>alert('User deleted successfully..');location.href='users.php';</script>";     
        } else {

            echo "<script>alert('Oops, Unable to delete user.');</script>";
        }
    }

    if (isset($_GET['iid'])) {
        
        if (mysqli_query($conn, "UPDATE user_master SET user_status = 'In-Active' WHERE user_id = '" . $_GET['iid'] . "'")){

            echo "<script>alert('User In-Actived successfully..');location.href='users.php';</script>";     
        } else {

            echo "<script>alert('Unable to inactive user.');</script>";
        }
    }

    if (isset($_GET['aid'])) {
        
        if (mysqli_query($conn, "UPDATE user_master SET user_status = 'Active' WHERE user_id = '" . $_GET['aid'] . "'")){

            echo "<script>alert('User Actived successfully..');location.href='users.php';</script>";     
        } else {

            echo "<script>alert('Unable to active user.');</script>";
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
                        <h3 class="mb-3">Manage User</h1>
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User Name</th>
                                    <th>Email Id</th>
                                    <th>Phone No</th>
                                    <th>Address</th>
                                    <th>Product id</th>
                                    <th>product Name</th>
                                    <th>Image</th>
                                    <th>Date Create</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                                    <tbody>
                                    <?php
                                        $resd6 = mysqli_query($conn, "SELECT * FROM user_master ORDER BY user_id DESC");
                                        if (mysqli_num_rows($resd6) > 0) {

                                            $count = 1;
                                            while($rowd6 = mysqli_fetch_assoc($resd6)) {
                                                
                                                echo "<tr>"; 
                                                echo "<th>".$count."</th>"; 
                                                echo "<td>".$rowd6['user_id']."</td>"; 
                                                echo "<td>".$rowd6['user_name']."</td>"; 
                                                echo "<td>".$rowd6['user_email']."</td>"; 
                                                echo "<td>".$rowd6['user_phone']."</td>"; 
                                                echo "<td>".$rowd6['user_address']."</td>"; 
                                                echo "<td>".$rowd6['product_id']."</td>"; 
                                                echo "<td>".$rowd6['product_name']."</td>";
                                                echo "<td>".$rowd6['product_image']."</td>";
                                                echo "<td>".$rowd6['user_date_create']."</td>"; 
                                                echo "<td>"; 
                                                // if ($rowd6['news_letter_one']) {
                                                //     echo "Yes";
                                                // } else {
                                                //     echo "No";
                                                // }
                                                // echo "</td>"; 
                                                // echo "<td>"; 
                                                // if ($rowd6['news_letter_two']) {
                                                //     echo "Yes";
                                                // } else {
                                                //     echo "No";
                                                // }
                                                echo "</td>"; 
                                                echo "<td>".date_format(date_create($rowd6['user_date_create']), 'd M, Y') . "</td>"; 
                                                echo "<td>".$rowd6['user_status']."</td>"; 
                                                echo "<td>";
                                                ?>
                                                <a href="users.php?did=<?php echo $rowd6['user_id'];?>" onClick="return confirm('Are you sure you want to delete?')"><i class="fa fa-trash"></i></a>
                                                <?php
                                                if ($rowd6['user_status']=='Active') {

                                                    echo " | <a href='users.php?iid=$rowd6[user_id]'><i class='fa fa-user'></i></a></td>";
                                                } else {

                                                    echo " | <a href='users.php?aid=$rowd6[user_id]'><i class='fa fa-user-slash'></i></a></td>";
                                                }
                                                echo "</tr>"; 

                                                $count++;
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
