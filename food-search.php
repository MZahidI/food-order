<?php include('partials-front/menu.php'); ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            <?php
                // get the search keyword
                $search = $_POST['search'];

                if($search == ""){
                    // Redirect to food page
                    header('location:'.SITEURL.'foods.php');
                }

            ?>
            
            <h2>Foods on Your Search <a href="#" class="text-white">"<?php echo $search; ?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
                // sql query to get food based on search keyword
                $sql = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";

                // Execute the query
                $res = mysqli_query($conn, $sql);

                // Count rows
                $count = mysqli_num_rows($res);

                // Check food is available or not
                if($count > 0){
                    // Available
                    While($row = mysqli_fetch_assoc($res)){
                        // Get the datails
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $description = $row['description'];
                        $image_name = $row['image_name'];
                        
                        ?>

                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php
                                    // Check image is available or not
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
                
                                <a href="order.html" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>

                        <?php
                    }
                }
                else{
                    // Not Available
                    echo "<div class='error'>Food Not Found.</div>";
                }
            ?>
    
            <div class="clearfix"></div>
    
        </div>
    
    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
