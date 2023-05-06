<?php
    ob_start();
    
    // Start the Session
    session_start();

    // Create Constants to store non repeating values
    define('SITEURL', 'http://localhost/food-order/');
    define('LOCALHOST', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'food-order');

    // define('SITEURL', 'http://wowfoods.epizy.com/');
    // define('LOCALHOST', 'sql210.epizy.com');
    // define('DB_USERNAME', 'epiz_28340614');
    // define('DB_PASSWORD', 'qhCj0RtKBI2');
    // define('DB_NAME', 'epiz_28340614_food_order');

    $conn=mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());  // Database Connection
    $db_select=mysqli_select_db($conn, DB_NAME) or die(mysqli_error());  // Selecting Database
?>