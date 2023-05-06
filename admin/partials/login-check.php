<?php
    // Authorization - Access control
    // Check the user logged in or not 

    if(!isset($_SESSION['user'])){    // if user session is not set
        // User is not logged in 
        // Redirect to login page with message 
        $_SESSION['no-login-message']="<div class='error text-center'>Please login to access Admin Panel</div>";
        header("location:".SITEURL.'admin/login.php');
    }
?>