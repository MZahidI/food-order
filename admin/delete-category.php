<?php
    // Includeing Constant.php file here 
    include('../config/constants.php');

    // echo "Delete page";
    // Check the id and image_name value is set or not 
    if(isset($_GET['id']) AND isset($_GET['image_name'])){
        // Get the value and delete 
        // echo "Get value and delete";
        $id=$_GET['id'];
        $image_name=$_GET['image_name'];

        // Remove the physical image file is available 
        if($image_name != ""){
            // Image available and remove it 
            $path="../images/category/".$image_name;

            // Remove the image 
            $remove=unlink($path);

            //If failed to remove image then add an error message and stop the process
            if($remove==FALSE){
                // Set the session message 
                $_SESSION['remove']="<div class='error'>Failed to Remove Category Image.</div>";

                // Redirect to manage-category page
                header("location:".SITEURL.'admin/manage-category.php');

                // Stop the process
                die();
            }
        }

        // Delete data from database
        // SQL Query to delete the data from database
        $sql="DELETE FROM tbl_category WHERE id=$id";

        // Execute the query
        $res=mysqli_query($conn, $sql);

        // Check the data is deleted from database or not 
        if($res==TRUE){
            // Set success message and redirect
            $_SESSION['delete']="<div class='success'>Category Deleted Successfully.</div>";

            // Redirect to manage-category page
            header("location:".SITEURL.'admin/manage-category.php');
        }
        else{
            // Set fail message and redirect
            $_SESSION['delete']="<div class='error'>Failed to Delete Category.</div>";

            // Redirect to manage-category page
            header("location:".SITEURL.'admin/manage-category.php'); 
        }

        // Redirect to manage-category page with message
    }
    else{
        // Redirect to manage-category page with error message 
        header("location:".SITEURL.'admin/manage-category.php');
    }
?>