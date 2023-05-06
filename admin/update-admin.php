<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>

        <br> <br>

        <?php
            // 1. get the id of selected admin 
            $id=$_GET['id'];
            // echo $id;

            // 2. Create SQL Query to get details 
            $sql="SELECT * FROM tbl_admin WHERE id=$id";
            
            // Execute the Query
            $res=mysqli_query($conn, $sql);

            // Check the query executed or not
            if($res==TRUE){
                // Check the data is available or not 
                $count=mysqli_num_rows($res);

                // Check we have the data or not
                if($count==1){
                    // Get the details
                    // echo "Admin Available";
                    
                    $row=mysqli_fetch_assoc($res);
                    $full_name=$row['full_name'];
                    $username=$row['username'];
                }
                else{
                    // Redirect to manage admin page
                    header("location:".SITEURL.'admin/manage-admin.php');
                }
            }
            else{

            }
        ?>

        <form action="" method="POST">

            <table class="tbl-full">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username; ?>">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>
    </div>
</div>


<?php
    // Check the submit button is clicked or not 
    if(isset($_POST['submit'])){
        // echo "Button Clicked";
        // Get all the values from Form to update 
        $id=$_POST['id'];
        $full_name=$_POST['full_name'];
        $username=$_POST['username'];

        // Create SQL Query to update Admin 
        $sql="UPDATE tbl_admin SET
            full_name='$full_name',
            username='$username' 
            WHERE id='$id'
        ";

        // Execute the Query 
        $res=mysqli_query($conn, $sql);

        // Check the query executed successfully of not 
        if($res==TRUE){
            // Query executed and Admin Updated successfully 
            $_SESSION['update']="<div class='success'>Admin Updated Successfully.</div>";

            // Redirect to manage admin page 
            header("location:".SITEURL.'admin/manage-admin.php');
        }
        else{
            // Failed to Update Admin 
            $_SESSION['update']="<div class='error'>Failed to Update Admin.</div>";

            // Redirect to manage admin page 
            header("location:".SITEURL.'admin/manage-admin.php');
        }
    }
?>


<?php include('partials/footer.php'); ?>