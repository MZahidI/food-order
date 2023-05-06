<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br> <br>

        <?php
            if(isset($_SESSION['add'])){
                echo $_SESSION['add']; // Displaying the message
                unset($_SESSION['add']); // Removing the message
            }
        ?>

        <form action="" method="POST">

            <table class="tbl-full">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter Your Name">
                    </td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" placeholder="Enter Your Username">
                    </td>
                </tr>

                <tr>
                    <td>Password: </td>
                    <td>
                        <input type="password" name="password" placeholder="Enter Your Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>


    </div>
</div>

<?php include('partials/footer.php'); ?>

<?php
    // Process the value from Form and save it in Database

    // check the submit is clicked or not 
    if(isset($_POST['submit'])){
        // Button Clicked
        // echo "Button Clicked";

        // 1. Get the data from Form 
        $full_name=$_POST['full_name'];
        $username=$_POST['username'];
        $password=md5($_POST['password']); // Password Encryption using md5

        // 2. SQL Query to save data into Database
        $sql="INSERT INTO tbl_admin SET
            full_name='$full_name',
            username='$username',
            password='$password'
        ";

        // 3. Execute Query and save data in Database
        $res=mysqli_query($conn, $sql) or die(mysqli_error());

        // 4. Check the data (Query is executed) is inserted or not and display the messages
        if($res==TRUE){
            // Data Inserted
            // Create a session variable to display message
            $_SESSION['add']="<div class='success'>Admin Added Succesfully</div>";

            // Redirect page
            header("location:".SITEURL.'admin/manage-admin.php');
        }
        else{
            // Failed to Data Inserted
            // Create a session variable to display message
            $_SESSION['add']="<div class='error'>Failed to Add Admin</div>";

            // Redirect page
            header("location:".SITEURL.'admin/add-admin.php');
        }
    }
?>