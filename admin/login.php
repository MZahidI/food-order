<?php
    include('../config/constants.php');
?>


<html>
    <head>
        <title>Login - wowFood system</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>

    <body class="login-body">
        
        <div class="login">
            <h1 class="text-center">Login</h1>

            <br> <br>

            <?php
                if(isset($_SESSION['login'])){
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }

                if(isset($_SESSION['no-login-message'])){
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }

                if(isset($_SESSION['logout'])){
                    echo $_SESSION['logout'];
                    unset($_SESSION['logout']);
                }
            ?>

            <br> <br>

            <!-- Login Form start here  -->
            <form action="" method="POST" class="text-center">
                Username: <br>
                <input class="login-text" type="text" name="username" placeholder="Enter Username" required>

                <br> <br>

                Password: <br>
                <input class="login-text" type="password" name="password" placeholder="Enter Password" required>

                <br> <br>

                <input type="submit" name="submit" value="Login" class="login-btn">

                <br> <br>
            </form>


            <!-- Login Form ends here  -->

            <p class="text-center">Created By - <a href="https://www.facebook.com/profile.php?id=100005326839432" class="author-decoration" target="_blank">Zahidul Islam</a></p>
        </div>

    </body>
</html>


<?php
    // Check the Login button is clicked or not 
    if(isset($_POST['submit'])){
        // Process for lOgin 
        // 1. get the data from Login Form 
        $username=$_POST['username'];
        $password=md5($_POST['password']);

        // 2. SQL to check the data are valid or not 
        $sql="SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

        // 3. Execute the query
        $res=mysqli_query($conn, $sql);

        // 4. count rows to check the user exist or not 
        $count=mysqli_num_rows($res);

        if($count==1){
            // User available and login success message
            $_SESSION['login']="<div class='success'>Login Successful.</div>";
            $_SESSION['user']=$username; // Check to the user is logged in or not and logout will unset it

            // Redirect to dashboard/homepage 
            header('location:'.SITEURL.'admin/index.php');
        }
        else{
            // User not available and login fail message
            $_SESSION['login']="<div class='error'>Login Failed. Username or Password did not match</div>";
            // Redirect to dashboard/homepage 
            header('location:'.SITEURL.'admin/login.php');
        }
    }
?>