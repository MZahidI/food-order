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

    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
                // Display food that are active 
                // Create sql query
                $sql = "SELECT * FROM tbl_food WHERE active='Yes'";

                // Execute the query
                $res = mysqli_query($conn, $sql);

                // count the rows
                $count = mysqli_num_rows($res);

                // Check foods are available or not
                if($count > 0){
                    // Available
                    while($row = mysqli_fetch_assoc($res)){
                        // Get the values
                        $id = $row['id'];
                        $title = $row['title'];
                        $description = $row['description'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];
                        
                        ?>

                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php

                                    // Check image available or not
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
                    // Not available
                    echo "<div class='error'>Food Not Found.</div>";
                }
            ?>

            <div class="clearfix"></div>

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
