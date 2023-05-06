<?php include('partials-front/menu.php'); ?>

<?php 
    // check food id is set or not
    if(isset($_GET['food_id'])){
        // Get the food id and details of the selected foods
        $food_id = $_GET['food_id'];

        // Get the deatails of the selected food
        $sql = "SELECT * FROM tbl_food WHERE id=$food_id";

        // Execute the query
        $res = mysqli_query($conn, $sql);

        // count the rows
        $count = mysqli_num_rows($res);

        // Check the data is available or not
        if($count == 1){
            // available
            // Get the data from database
            $row = mysqli_fetch_assoc($res);

            $title = $row['title'];
            $price = $row['price'];
            $image_name = $row['image_name'];
        }
        else{
            // not available
            // Redirect to home page with message
            header('locaton:'.SITEURL);
        }
    }
    else{
        // Redirect to home page
        header('location:'.SITEURL);
    }
?>

    <!-- Order form Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" method="POST" class="order">
                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">
                        <?php 
                            // image available or not
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
                        <h3><?php echo $title; ?></h3>
                        <input type="hidden" name="food" value="<?php echo $title; ?>">

                        <p class="food-price">Tk. <?php echo $price; ?></p>
                        <input type="hidden" name="price" value="<?php echo $price; ?>">

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="Enter your name" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="Enter your mobile number" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="Enter your email" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="Enter your address" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                    
                    <br> <br>

                    <!-- <p>You have any <b>query</b> or <b>update/cancel</b> your order please <a href="<?php //echo SITEURL; ?>contact.php">Contact Us</a></p> -->
                </fieldset>

            </form>

            <?php 
                // Check button is clicked or not
                if(isset($_POST['submit'])){
                    // Get all the data from form
                    $food = $_POST['food'];
                    $price = $_POST['price'];
                    $qty = $_POST['qty'];

                    $total = $qty * $price; // total price
                    
                    $order_date = date("Y-m-d h:i:sa"); // Order date and time

                    $status = "Ordered"; // Ordered, On Delivery, Delivered, Cancelled

                    $customer_name = $_POST['full-name'];
                    $customer_contact = $_POST['contact'];
                    $customer_email = $_POST['email'];
                    $customer_address = $_POST['address'];

                    // Save the order in database
                    // Create sql query
                    $sql2 = "INSERT INTO tbl_order SET
                        food = '$food',
                        price = $price,
                        qty = '$qty',
                        total = '$total',
                        order_date = '$order_date',
                        status = '$status',
                        customer_name = '$customer_name',
                        customer_contact = '$customer_contact',
                        customer_email = '$customer_email',
                        customer_address = '$customer_address'
                    ";

                    // Execute the query
                    $res2 = mysqli_query($conn, $sql2);

                    // check query executed or not
                    if($res2 == TRUE){
                        include('smtp/PHPMailerAutoload.php');

                        $col = "";

                        if($status=="Ordered") $col = "<b style='color:#3742fa;'>Ordered</b>";
                        else if($status=="On Delivery") $col = "<b style='color:orange;'>On Delivery</b>";
                        else if($status=="Delivered") $col = "<b style='color:#2ed573;'>Delivered</b>";
                        else $col = "<b style='color:red;'>Cancelled</b>";

                        $msg = "<pre>
                        Your Order Details:

                        Food Name: $food
                        Price: $price
                        Quantity: $qty
                        Total: $total
                        Buyer: $customer_name
                        Mobile: $customer_contact
                        Address: $customer_address
                        Status: $col

                        Regards
                            wowFood - The Food Heaven</pre>
                        ";

                        $to = $customer_email;
                        $subject = 'Order Details';
                        //echo smtp_mailer($to,'subject',$html);
                        //function smtp_mailer($to,$subject, $msg){
                            $mail = new PHPMailer(); 
                            //$mail->SMTPDebug  = 3;
                            $mail->IsSMTP(); 
                            $mail->SMTPAuth = true; 
                            $mail->SMTPSecure = 'tls'; 
                            $mail->Host = "smtp.gmail.com";
                            $mail->Port = 587; 
                            $mail->IsHTML(true);
                            $mail->CharSet = 'UTF-8';
                            $mail->Username = "zahidulislam1703033@gmail.com";
                            $mail->Password = "Zahid_033@";
                            $mail->SetFrom("zahidulislam1703033@gmail.com");
                            $mail->Subject = $subject;
                            $mail->Body =$msg;
                            $mail->AddAddress($to);
                            $mail->SMTPOptions=array('ssl'=>array(
                                'verify_peer'=>false,
                                'verify_peer_name'=>false,
                                'allow_self_signed'=>false
                            ));
                            if(!$mail->Send()){
                                // failed to save order
                                $_SESSION['order'] = "<div class='error text-center'>Your Order Placed Successfully!</div>";

                                // Redirect to homepage
                                header('location:'.SITEURL);
                            }
                            else{
                                // Query executed and order saved
                                $_SESSION['order'] = "<div class='success text-center'>Your Order Placed Successfully! Please check your email.</div>";

                                // Redirect to homepage
                                header('location:'.SITEURL);
                            }
                        //}
                        
                        // Query executed and order saved
                        //$_SESSION['order'] = "<div class='success text-center'>Food Ordered Successfully.</div>";

                        // Redirect to homepage
                        //header('location:'.SITEURL);
                    }
                    else{
                        // failed to save order
                        $_SESSION['order'] = "<div class='error text-center'>Failed to Order Food.</div>";

                        // Redirect to homepage
                        header('location:'.SITEURL);
                    }
                }
            ?>

        </div>
    </section>
    <!-- order form Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
