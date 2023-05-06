<?php
    include('../config/constants.php');

    // echo "Delete";

    if(isset($_GET['id']) && isset($_GET['image_name'])){
        // Process to delete 
        // 1. Get id and image name
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        // 2. Remove the image if available
        // Check image is available or not if yes then delete
        if($image_name != ""){
            // It has image & need to remove from folder
            // Get the image path
            $path = "../images/food/".$image_name;

            // Remove image file from folder
            $remove = unlink($path);

            // Check image is remvoed or not
            if($remove == FALSE){
                // Failed to remove
                $_SESSION['upload'] = "<div class='error'>Failed to Remove Image File.</div>";

                // Redirect to manage-food page 
                header("location:".SITEURL.'admin/manage-food.php');

                // Stop the process
                die();
            }
            else{

            }
        }

        // 3. Delete food from database
        $sql = "DELETE FROM tbl_food WHERE id=$id";

        // Execute the query
        $res = mysqli_query($conn, $sql);

        // Check the query executed or not 
        if($res == TRUE){
            // Food Deleted

            $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully.</div>";

            // Redirect to manage-food page 
            header("location:".SITEURL.'admin/manage-food.php');
        }
        else{
            // Failed to delete food
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Food.</div>";

            // Redirect to manage-food page 
            header("location:".SITEURL.'admin/manage-food.php');
        }

        // 4. Redirect to manage-food with message

    }
    else{
        // Redirect to manage food page
        $_SESSION['unauthorized'] = "<div class='error'>Unauthorized Access.</div>";
        header("location:".SITEURL.'admin/manage-food.php');
    }
?>