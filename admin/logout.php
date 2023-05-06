<?php
    // including constants.php 
    include('../config/constants.php');

    // 1. Destroy the session  
    session_destroy();  //Unsets $_SESSION['user']

    session_start();
    $_SESSION['logout']="<div class='success'>Logout Successfully.</div>";

    // 2. redirect to login page
    header("location:".SITEURL.'admin/login.php');
?>