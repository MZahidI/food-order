<?php include('partials-front/menu.php'); ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <marquee style="color:#ff4757;">Welcome to wowFood - The Food Heaven.</marquee>

    <?php
        if(isset($_SESSION['order'])){
            echo $_SESSION['order'];
            unset($_SESSION['order']);
        }
    ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php
                if(isset($_SESSION['not-found'])){
                    echo $_SESSION['not-found'];
                    unset($_SESSION['not-found']);
                }
            ?>

            <?php
                // Create sql query to display categories from database
                $sql = "SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes' LIMIT 3";

                // Execute the query
                $res = mysqli_query($conn, $sql);

                // Count the rows
                $count = mysqli_num_rows($res);

                if($count > 0){
                    // Available
                    while($row = mysqli_fetch_assoc($res)){
                        // Get the data from data
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];

                        ?>

                        <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                            <div class="box-3 float-container">
                                <?php
                                    // Check image is available or not
                                    if($image_name == ""){
                                        // Display message
                                        echo "<div class='error'>Image Not Available</div>";
                                    }
                                    else{
                                        // Image available
                                        ?>

                                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">

                                        <?php
                                    }

                                ?>
                                

                                <h3 class="float-text text-white"><?php echo $title; ?></h3>
                            </div>
                        </a>

                        <?php
                    }
                }
                else{
                    // Not Available
                    echo "<div class='error'>Category Not Added.</div>";
                }
            ?> 

            <div class="clearfix"></div>
        </div>

        <p class="text-center"><a href="<?php echo SITEURL; ?>categories.php">See All Categories</a></p>
    </section>
    <!-- Categories Section Ends Here -->

    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
                // Getting foods from database that are active and featured
                $sql2 = "SELECT * FROM tbl_food WHERE active='Yes' AND featured='Yes' LIMIT 6";

                // Execute the query
                $res2 = mysqli_query($conn, $sql2);

                // count the rows
                $count2 = mysqli_num_rows($res2);

                // Check food available or not  
                if($count2 > 0){
                    // food available
                    while($row = mysqli_fetch_assoc($res2)){
                        // Get all the values
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $description = $row['description'];
                        $image_name = $row['image_name'];

                        ?>

                        <div class="food-menu-box">
                            <div class="food-menu-img">

                                <?php
                                    // Check image available or not
                                    if($image_name == ""){
                                        // not available
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
                                <p class="food-price">Tk.<?php echo $price; ?></p>
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
                    // food not available
                    echo "<div class='error'>Food Not Available.</div>";
                }
            ?>
    
            <div class="clearfix"></div>
    
        </div>

        <p class="text-center"><a href="<?php echo SITEURL; ?>foods.php">See All Foods</a></p>
    
    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
