<?php include('partials-front/menu.php'); ?>

<?php
    // Check id is passed or not
    if(isset($_GET['category_id'])){
        // Category id is set and get the id
        $category_id = $_GET['category_id'];

        // Get the category title based on category id
        $sql = "SELECT title FROM tbl_category WHERE id=$category_id";

        // Execute the query
        $res = mysqli_query($conn, $sql);

        // count the rows
        $count = mysqli_num_rows($res);

        if($count == 1){
            // Category available
            $row = mysqli_fetch_assoc($res);

            // Get the title
            $category_title = $row['title'];
        }
        else{
            // Not available
            // Redirect with message
            $_SESSION['not-found'] = "<div class='error'>Category Not Found.</div>";
            header("location:".SITEURL);
        }
    }
    else{
        // category id is not passed
        // Redirect
        header('location:'.SITEURL);
    }

?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <h2>Foods on <a href="#" class="text-white">"<?php echo $category_title; ?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
                // create sql query to get foods on selected category
                $sql2 = "SELECT * FROM tbl_food WHERE category_id=$category_id";

                // Execute the query
                $res2 = mysqli_query($conn, $sql2);

                // count the rows
                $count2 = mysqli_num_rows($res2);

                // Check food is available or not
                if($count2 > 0){
                    // available
                    while($row2 = mysqli_fetch_assoc($res2)){
                        $id = $row2['id'];
                        $title = $row2['title'];
                        $price = $row2['price'];
                        $description = $row2['description'];
                        $image_name = $row2['image_name'];

                        ?>

                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php
                                    // image is available or not
                                    if($image_name == ""){
                                        // Not available
                                        echo "<div class='error'>Image Not Available.</div>";
                                    }
                                    else{
                                        // available
                                        ?>

                                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">

                                        <?php
                                    }
                                ?>
                                
                            </div>
                
                            <div class="food-menu-desc">
                                <h4><?php echo $title; ?></h4>
                                <p class="food-price">Tk. <?php echo $price; ?></p>
                                <p class="food-detail">
                                    <?php echo $description; ?>
                                </p>
                                <br>
                
                                <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>

                        <?php
                    }
                }
                else{
                    // not available
                    echo "<div class='error'>Food Not Available.</div>";
                }
            ?>
    
            <div class="clearfix"></div>
    
        </div>
    
    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
