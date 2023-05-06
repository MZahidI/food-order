<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>

        <br> <br>

        <?php
            if(isset($_GET['id'])){
                $id=$_GET['id'];
            }
        ?>

        <form action="" method="POST">

            <table class="tbl-full">
                <tr>
                    <td>Current Password: </td>
                    <td>
                        <input type="password" name="current_password" placeholder="Current Password" required>
                    </td>
                </tr>

                <tr>
                    <td>New Password: </td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password" required>
                    </td>
                </tr>

                <tr>
                    <td>Confirm Password: </td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>

    </div>
</div>

<?php
    // Check the submitton is clicked or not 
    if(isset($_POST['submit'])){
        // echo "Clicked";

        // 1. Get the data from Form 
        $id=$_POST['id'];
        $current_password=md5($_POST['current_password']);
        $new_password=md5($_POST['new_password']);
        $confirm_password=md5($_POST['confirm_password']);

        // 2. Check the user with current id and password exist or not 
        $sql="SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

        // Execute the Query 
        $res=mysqli_query($conn, $sql);

        if($res==TRUE){
            // Check data is available or not 
            $count=mysqli_num_rows($res);

            if($count==1){
                // User exists and password can be changed
                // echo "User Found";
                // Check the new password and confirm password match or not 
                if($new_password==$confirm_password){
                    // Update the password 
                    $sql2="UPDATE tbl_admin SET 
                        password='$new_password' 
                        WHERE id=$id
                    ";

                    // Execute the Query
                    $res2=mysqli_query($conn, $sql2);

                    // Check the query executed or not 
                    if($res2==TRUE){
                        // Display Success message
                        // Redirect to manage admin page with success message 
                        $_SESSION['change-pwd']="<div class='success'>Password Changed Successfully</div>";
                        header("location:".SITEURL.'admin/manage-admin.php');
                    }
                    else{
                        // Display error message
                        // Redirect to manage admin page with error message 
                        $_SESSION['fail-change-pwd']="<div class='error'>Failed to Change Password. Try Again Later.</div>";
                        header("location:".SITEURL.'admin/manage-admin.php');
                    }
                }
                else{
                    // Redirect to manage admin page with error message 
                    $_SESSION['pwd-not-match']="<div class='error'>Password Did not Match</div>";
                    header("location:".SITEURL.'admin/manage-admin.php');
                }
            }
            else{
                // User does not exist and set message and redirect 
                $_SESSION['wrong-pwd']="<div class='error'>Wrong Password.</div>";
                header("location:".SITEURL.'admin/manage-admin.php');
            }
        }

        // 3. Check the new password and confirm password match or not 

        // 4. Change password if all are true 
    }
?>


<?php include('partials/footer.php'); ?>