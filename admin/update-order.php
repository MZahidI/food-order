<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Order</h1>

        <br> <br>

        <?php
            // Check id is set or not
            if(isset($_GET['id'])){
                // Get the order details
                $id = $_GET['id'];

                // get all other details based on id
                // sql query to get order details
                $sql = "SELECT * FROM tbl_order WHERE id=$id";

                // Execute the query
                $res = mysqli_query($conn, $sql);

                // count the rows
                $count = mysqli_num_rows($res);

                // Check data is available or not
                if($count == 1){
                    // available
                    $row = mysqli_fetch_assoc($res);

                    // Get all the details
                    $food = $row['food'];
                    $price = $row['price'];
                    $qty = $row['qty'];
                    $status = $row['status'];
                    $customer_name = $row['customer_name'];
                    $customer_contact = $row['customer_contact'];
                    $customer_email = $row['customer_email'];
                    $customer_address = $row['customer_address'];
                }
                else{
                    // Not available
                    // Redirect to manage-order page
                    header('location'.SITEURL.'admin/manage-order.php');
                }
            }
            else{
                // Redirect to manage-order page 
                header('location'.SITEURL.'admin/manage-order.php');
            }
        ?>

        <form action="" method="POST">
            <table class="tbl-full">
                <tr>
                    <td>Food Name: </td>
                    <td><b><?php echo $food; ?></b></td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <b><?php echo $price; ?></b>
                    </td>
                </tr>

                <tr>
                    <td>Qty: </td>
                    <td>
                        <input type="number" name="qty" value="<?php echo $qty; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Status: </td>
                    <td>
                        <select name="status">
                            <option <?php if($status == "Ordered"){echo "selected";} ?> value="Ordered">Ordered</option>

                            <option <?php if($status == "On Delivery"){echo "selected";} ?> value="On Delivery">On Delivery</option>

                            <option <?php if($status == "Delivered"){echo "selected";} ?> value="Delivered">Delivered</option>

                            <option <?php if($status == "Cancelled"){echo "selected";} ?> value="Cancelled">Cancelled</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Customer Name: </td>
                    <td>
                        <input type="text" name="customer_name" value="<?php echo $customer_name; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Customer Contact: </td>
                    <td>
                        <input type="text" name="customer_contact" value="<?php echo $customer_contact; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Customer Email: </td>
                    <td>
                        <input type="text" name="customer_email" value="<?php echo $customer_email; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Customer Address: </td>
                    <td>
                        <textarea name="customer_address" cols="30" rows="5"><?php echo $customer_address; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="price" value="<?php echo $price; ?>">

                        <input type="submit" name="submit" value="Update Order" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

        <?php
            // Check button is clicked or not
            if(isset($_POST['submit'])){
                // echo "clicked";
                // Get all the values from form
                $id = $_POST['id'];
                $price = $_POST['price'];
                $qty = $_POST['qty'];

                $total = $price * $qty;

                $status = $_POST['status'];

                $customer_name = $_POST['customer_name'];
                $customer_contact = $_POST['customer_contact'];
                $customer_email = $_POST['customer_email'];
                $customer_address = $_POST['customer_address'];

                // Update the values
                // create sql query
                $sql2 = "UPDATE tbl_order SET
                    qty = $qty,
                    total = $total,
                    status = '$status',
                    customer_name = '$customer_name',
                    customer_contact = '$customer_contact',
                    customer_email = '$customer_email',
                    customer_address = '$customer_address' 
                    WHERE id=$id
                ";

                // Execute the query
                $res2 = mysqli_query($conn, $sql2);

                // check query executed or not
                if($res2 == TRUE){
                include('../smtp/PHPMailerAutoload.php');
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
                        $_SESSION['update'] = "<div class='error'>Failed to Update Order. Try Again!</div>";

                        // Redirect to homepage
                        header('location:'.SITEURL.'admin/manage-order.php');
                    }
                    else{
                        // Query executed and order saved
                        $_SESSION['update'] = "<div class='success'>Order Updated Successfully. Email Sent Successfully.</div>";

                        // Redirect to homepage
                        header('location:'.SITEURL.'admin/manage-order.php');
                    }
                        //}
                        
                        // Query executed and order saved
                        //$_SESSION['order'] = "<div class='success text-center'>Food Ordered Successfully.</div>";

                        // Redirect to homepage
                        //header('location:'.SITEURL.'admin/manage-order.php');
                }
                else{
                    // failed to save order
                    $_SESSION['update'] = "<div class='error'>Failed to Update Order. Try Again!</div>";

                    // Redirect to homepage
                    header('location:'.SITEURL.'admin/manage-order.php');
                }
            }
        ?>


    </div>
</div>





<?php include('partials/footer.php'); ?>
