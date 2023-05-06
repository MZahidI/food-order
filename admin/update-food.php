<?php include('partials/menu.php'); ?>

<?php
    // Check id is set or not 
    if(isset($_GET['id'])){
        // Get all the details 
        $id = $_GET['id'];
        
        // Create sql query to get the selected food
        $sql2 = "SELECT * FROM tbl_food WHERE id = $id";

        // Execute the query
        $res2 = mysqli_query($conn, $sql2);

        // Get the value based on query executed
        $row2 = mysqli_fetch_assoc($res2);

        // Get the individual values of selected food
        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];
    }
    else{
        // Redirect to Manage food
        header("loaction:".SITEURL.'admin/manage-food.php');
    }
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>

        <br> <br>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-full">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                            // Check image is available or not
                            if($current_image == ""){
                                // Image is not available
                                echo "<div class='error'>Image Not Available.</div>";
                            }
                            else{
                                // Image available
                                ?>

                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" alt="<?php echo $title; ?>" width="150px" height="50px">

                                <?php
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Select New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                
                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">

                            <?php
                                // Query to get data
                                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                                // Execute the query
                                $res = mysqli_query($conn, $sql);

                                // Count rows
                                $count = mysqli_num_rows($res);

                                // Check category available or not
                                if($count > 0){
                                    // Available
                                    while($row = mysqli_fetch_assoc($res)){
                                        $category_title = $row['title'];
                                        $category_id = $row['id'];

                                        // echo "<option value='$category_id'>$category_title</option>";

                                        ?>

                                            <option <?php if($current_category == $category_id){echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>

                                        <?php
                                    }

                                }
                                else{
                                    // Not Available
                                    echo "<option value='0'>Category Not Available</option>";
                                }

                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured == "Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes">Yes
                        <input <?php if($featured == "No"){echo "checked";} ?> type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active == "Yes"){echo "checked";} ?> type="radio" name="active" value="Yes">Yes
                        <input <?php if($active == "No"){echo "checked";} ?> type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>

        <?php
            if(isset($_POST['submit'])){
                // echo "Button Clicked";

                // 1. Get all the details from the form
                $id = $_POST['id'];
		        $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                // 2. Upload the image if selected
                // Check upload button is clicked or not
                if(isset($_FILES['image']['name'])){
                    // Upload button clicked
                    // echo "click";

                    $image_name = $_FILES['image']['name']; // New image name

                    // Check file is available or not
                    if($image_name != ""){
                        // Available
                        // A. Upload image

                        // Rename the image 
                        $ext = end(explode('.', $image_name)); // Gets the extension of the image

                        $image_name = "Food-Name-".rand(0000,9999).'.'.$ext; // This is new name

                        // Get the source path and destination path
                        $src_path = $_FILES['image']['tmp_name'];
                        $dst_path = "../images/food/".$image_name;

                        // Upload the image
                        $upload = move_uploaded_file($src_path, $dst_path);

                        // Check image uploaded or not
                        if($upload == FALSE){
                            // Failed to upload
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload New Image.</div>";

                            // Redirect to manage-food
                            header("location:".SITEURL.'admin/manage-food.php');

                            // Stop the process
                            die();
                        }
                        
                        // 3. Remove the image if new image is uploaded and current image exist
                        // B. Remove current image if available 
                        if($current_image != ""){
                            // Available

                            // Remove the image
                            $remove_path = "../images/food/".$current_image;
                            $remove = unlink($remove_path);

                            // Check Image is removed or not
                            if($remove == FALSE){
                                // Failed to remove current image
                                $_SESSION['upload'] = "<div class='error'>Failed to Remove Current Image.</div>";

                                // Redirect to manage-food
                                header("location:".SITEURL.'admin/manage-food.php');

                                // Stop the process
                                die();
                            }
                        }
                    }
                    else{
                        $image_name = $current_image;
                    }
                }
                else{
                    // echo "Not Click";
                    $image_name = $current_image;
                }

                
                
                // 4. Update the food in database
                $sql3 = "UPDATE tbl_food SET
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = '$category',
                    featured = '$featured',
                    active = '$active' 
                    WHERE id=$id
                ";

                // Execute the sql query 
                $res3 = mysqli_query($conn, $sql3);

                // Query executed or not
                if($res3 == TRUE){
                    // Query executed and food updated
                    $_SESSION['update'] = "<div class='success'>Food Updated Successfully.</div>";

                    // Redirect to manage-food
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else{
                    // Failed to update food
                    $_SESSION['update'] = "<div class='error'>Failed to Update Food.</div>";

                    // Redirect to manage-food
                    header("location:".SITEURL.'admin/manage-food.php');
                }
            }
        ?>

    </div>
</div>


<?php include('partials/footer.php'); ?>