<?php
    // Includeing Constant.php file here 
    include('../config/constants.php');

    // 1. get the id of Admin to be deleted
    $id=$_GET['id'];

    // 2. Create SQL Query to Delete Admin 
    $sql="DELETE FROM tbl_admin WHERE id=$id";

    // Execute the Query 
    $res=mysqli_query($conn, $sql);

    // Check the Query executed successfully or not 
    if($res==TRUE){
        // Query Executed successfully and Admin Deleted 
        // echo "Admin Deleted";
        // Create session variable to display message
        $_SESSION['delete']="<div class='success'>Admin Deleted Successfully</div>";

        // Redirect to manage admin page
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    else{
        // Failed to Delete Admin 
        // echo "Failed to Delete Admin";
        // Create session variable to display message
        $_SESSION['delete']="<div class='error'>Failed to Delete Admin. Try again later.</div>";

        // Redirect to manage admin page
        header('location:'.SITEURL.'admin/manage-admin.php');
    }

    // 3. Redirect to Manage Admin page with a message (success or error)
?>  