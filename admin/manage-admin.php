<?php include('partials/menu.php'); ?>

        <!-- Main Content Section Starts -->
        <div class="main-content">
            <div class="wrapper">
                <h1>Manage Admin</h1>
                <br>

                <?php
                    if(isset($_SESSION['add'])){
                        echo $_SESSION['add']; // Displaying the message
                        unset($_SESSION['add']); // Removing the message
                    }

                    if(isset($_SESSION['delete'])){
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                    }

                    if(isset($_SESSION['update'])){
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }

                    if(isset($_SESSION['wrong-pwd'])){
                        echo $_SESSION['wrong-pwd'];
                        unset($_SESSION['wrong-pwd']);
                    }

                    if(isset($_SESSION['pwd-not-match'])){
                        echo $_SESSION['pwd-not-match'];
                        unset($_SESSION['pwd-not-match']);
                    }

                    if(isset($_SESSION['change-pwd'])){
                        echo $_SESSION['change-pwd'];
                        unset($_SESSION['change-pwd']);
                    }

                    if(isset($_SESSION['fail-change-pwd'])){
                        echo $_SESSION['fail-change-pwd'];
                        unset($_SESSION['fail-change-pwd']);
                    }
                ?>

                <br> <br> <br>

                <!-- Button to add admin -->
                <a href="add-admin.php" class="btn-primary">Add Admin</a>
                <br> <br> <br>

                <table class="tbl-full">
                    <tr>
                        <th>S.N.</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Actions</th>
                    </tr>

                    <?php
                        // Query to get all Admin
                        $sql="SELECT * FROM tbl_admin";

                        // Execute the Query
                        $res=mysqli_query($conn, $sql);

                        // Check the query is executed or not
                        if($res==TRUE){
                            // Count rows to check we have data in Database or not
                            $count=mysqli_num_rows($res); // Function to get all the rows in Database 

                            $sn=1; // Create a variable and assign the value

                            // Check the number of rows
                            if($count>0){
                                // We have data in Database
                                while($rows=mysqli_fetch_assoc($res)){
                                    $id=$rows['id'];
                                    $full_name=$rows['full_name'];
                                    $username=$rows['username'];

                                    ?>

                                    <!-- Display the value in our table -->

                                    <tr>
                                        <td><?php echo $sn++ ?></td>
                                        <td><?php echo $full_name ?></td>
                                        <td><?php echo $username ?></td>
                                        <td>
                                            <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Password</a>
                                            <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                                            <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a>
                                        </td>
                                    </tr>

                                    <?php
                                }
                            }
                            else{
                                // We have not data in Database
                            }
                        }
                    ?>

                    
                </table>
            </div>
        </div>
        <!-- Main Content Section Ends -->

<?php include('partials/footer.php'); ?>