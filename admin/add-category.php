<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>

        <br> <br>

        <?php
            if(isset($_SESSION['add'])){
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if(isset($_SESSION['upload'])){
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <!-- Add Category Form starts  -->
        <form action="" method="POST" enctype="multipart/form-data">
            
            <table class="tbl-full">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title" required>
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>

            </table>


        </form>

        <!-- Add Category Form ends  -->

        <?php
            // Check the submit button is clicked or not 
            if(isset($_POST['submit'])){
                // echo "clicked";

                // 1. Get the value from category form
                $title=$_POST['title'];
                
                // For radio input type we need to check the button is selected or not 
                if(isset($_POST['featured'])){
                    // Get the value from form 
                    $featured=$_POST['featured'];
                }
                else{
                    // Set the default value 
                    $featured="No";
                }

                if(isset($_POST['active'])){
                    // Get the value from form 
                    $active=$_POST['active'];
                }
                else{
                    // Set the default value 
                    $active="No";
                }

                // Check the image is selected or not and set the value for image name accordingly 
                // print_r($_FILES['image']);
                // die(); // Break the code here

                if(isset($_FILES['image']['name'])){
                    // Upload the image 
                    // To upload image we need image name, source path and destination path 
                    $image_name=$_FILES['image']['name'];

                    // If image is selected then upload it
                    if($image_name != ""){

                        // Auto Rename our image 
                        // Get the extention of our image(jpg, png, gif etc) e.g. "food1.jpg"
                        $ext=end(explode('.', $image_name));

                        // Rename the image 
                        $image_name="Food_Category_".rand(000,999).'.'.$ext;

                        $source_path=$_FILES['image']['tmp_name'];

                        $destination_path="../images/category/".$image_name;

                        // Finally upload the image 
                        $upload=move_uploaded_file($source_path, $destination_path);

                        // Check the image is uploaded or not 
                        if($upload==FALSE){
                            // Set message 
                            $_SESSION['upload']="<div class='error'>Fail to Upload image</div>";
                            // Redirect to add-category page
                            header("location:".SITEURL.'admin/add-category.php');
                            // Stop the process
                            die();
                        }
                    }
                }
                else{
                    // Don't upload image and set the image name value as blank
                    $image_name="";
                }


                // 2. Create SQL Query to insert category into Database 
                $sql="INSERT INTO tbl_category SET
                    title='$title',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active'
                ";

                // 3. Execute the query and save in Database 
                $res=mysqli_query($conn, $sql);

                // 4. Check the query executed successfully or not 
                if($res==TRUE){
                    // Query Executed and category added
                    $_SESSION['add']="<div class='success'>Category Added Successfully</div>";
                    // Redirect to manage-category page
                    header("location:".SITEURL.'admin/manage-category.php');
                }
                else{
                    // Fail to add category
                    $_SESSION['add']="<div class='error'>Fail to Add Category</div>";
                    // Redirect to manage-category page
                    header("location:".SITEURL.'admin/add-category.php');
                }
            }
        ?>


    </div>
</div>


<?php include('partials/footer.php'); ?>