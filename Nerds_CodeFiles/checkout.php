<?php
 require('requires/head.php'); 
require_once('requires/mysqli_connect.php');
$status = session_status();

  
    if(isset($_SESSION['username'])){
        $_SESSION['username']; 
      $user_id = $_SESSION['user_id'];
    
      if($_GET['CAR_ID']){
        $CAR_ID=$_GET['CAR_ID'];
       }
       if($_GET['car_price']){
        $car_price=$_GET['car_price'];
       }

$qry ="SELECT `id`, `username`, `email`, `password` FROM `users` WHERE `id` = '$user_id'";
$result = mysqli_query($dbc,$qry) or die(mysqli_error($dbc));
  $res=mysqli_fetch_array($result);
  $uname = $res['username'];
    $uemail = $res['email'];
    require('stripe-php-master/config.php');
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

    \Stripe\Stripe::setVerifySslCerts(false);

$token=$_POST['stripeToken'];

$data = \stripe\Charge::create(array(
    "amount" => $car_price*100,
    "currency" => "cad",
    "description" => "Car-Rentals",
    "source"=>$token,
 ) );

    $status = $data['status'];
     $amount = $data['amount'];

$current_date = date("Y-m-d");

    $currency= $data['currency'];
    
    $sql = "INSERT INTO `car_bookings`(`id`, `user_id`, `car_id`, `price`, `status`, `date`) 
    VALUES ('null','$user_id','$CAR_ID','$amount','$status','$current_date')";
                    $result1 = mysqli_query($dbc,$sql) or die(mysqli_error($dbc));
                    if($result1){
        
                                                echo   "<span class='alert alert-success' style='width: 100%;float: left;text-align: center'>Your payment is done successfully! </span>";
                                            
                                            }else{
                                                echo   "<span class='alert alert-danger' style='width: 100%;float: left;text-align: center'>Your payment is not done. Try Again!! </span>";
                                        
                                            }

    }
?>

<!doctype html>
<html lang="en">

<head>
    <title>Cars Of The World:checkout</title>
    <style>
    /* Style inputs */
    .contactus [type=text],
    input[type=email] {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        margin-top: 6px;
        margin-bottom: 16px;
        resize: vertical;
    }

    /* Style the container/contact section */
 

    .address-wrap {
        /* background: #fff; */
        background-color: #f2f2f2;
        box-shadow: 0px 3px 10px 0px rgba(38, 59, 94, 0.1);
        -webkit-box-flex: 1;
        margin-left: 3%;
        flex: 1 1 40%;
        margin-top: 25px;
    }
    </style>

    <?php
    
    
    
 if(isset($_SESSION['username'])){
     $username = $_SESSION['username'];
 }
 
 
 
                     
 $q = "SELECT v.VehiclesTitle, b.BrandName,v.Vprofile, v.VehiclesOverview, v.PricePerDay, v.FuelType, v.ModelYear, v.SeatingCapacity,
         v.Vimage1, v.Vimage2, v.Vimage3, v.Engine, v.DriveTrain, v.color, v.InteriorFeatures, v.ExteriorFeatures, v.Functionality
         FROM tblvehicles v JOIN tblbrands b on b.id=v.VehiclesBrand WHERE v.id =" . $CAR_ID .";";
 
         $res=mysqli_query($dbc,$q) OR mysqli_error($dbc);  
             
         $r=mysqli_fetch_array($res);
    
    ?>

    <!-- Checkout page -->

    <div class="container-fluid">

        <div class="container">
            <div data-aos='zoom-out-down' data-aos-delay="50" data-aos-duration="1000" style="text-align:center">
                <div style="padding-top: 60px;">
                    <span style="color:red" id="errorMsgcheckout"></span>

                    <h2 class="fw-bolder">Checkout</h2>
                </div>
            </div>
            <div style="padding-top: 60px; padding-bottom: 70px" class="row">

                <div data-aos='fade-right' data-aos-delay="0" data-aos-duration="1000"
                    class="col-lg-8 p-5 contactus">
                   <br>
                        <h3>User's Details </h3><br>
                        <label for="fname"><i class="fa fa-user"></i> Full Name</label>
                        <input disabled id="fname" type="text" name="fname" value="<?php echo $uname; ?>"><br><br>
                        <label for="email"><i class="fa fa-envelope"></i> Email</label>
                        <input disabled id="email" type="text" name="email" value="<?php echo $uemail; ?>">
                       <br><br>
                            <h3>Payment</h3><br>

                            <form
                                action="checkout.php?CAR_ID=<?php echo $CAR_ID; ?>&car_price=<?php echo $car_price; ?>"
                                method="post">
                                <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                    data-key="<?php echo $Publishable_key; ?>"
                                    data-amount="<?php echo $car_price*100; ?>" data-name="Car-Rentals"
                                    data-description="Car-Rentals" 
                                    data-currency="cad">


                                </script>

                            </form>
                        
                    
                  
                </div>

                <div data-aos='fade-left' data-aos-delay="0" data-aos-duration="1000" class="col-lg-4"
                    style="padding-top: 40px; padding-bottom: 50px">
                    <div class="row">


                        <div class="col-12 address-wrap  p-5 ">
                             <h2> Current selected Car </h2>

                            <div class=" p-5 address-btm list-group">
                                <h5>
                                    <img class='card-img-top mb-5  img-responsive' style='object-fit:cover;'
                                        src='assets/profile/<?php echo $r['Vprofile'];?>' alt='...' />

                                    <?php  echo "<div>".htmlentities($r['BrandName']);?>
                                    <?php  echo htmlentities($r['VehiclesTitle'])."</div>";?><br>
                                    <span class="price">$<?php echo htmlentities($r['PricePerDay']);?> total</span>

                                </h5>
                            </div>




                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php }else{ ?>

    <div data-aos='fade-right' data-aos-delay="0" data-aos-duration="1000" class="column col-12  contactus">
        <div style="height: 75vh;" class=" text-center d-flex flex-column justify-content-center align-items-center">
            <h2 class="p-3">You Have been logged out..</h2>

            <button type="button" class="'btn btncolor px-5 btn-info " data-bs-toggle='modal'
                data-bs-target='#myModal'>Login</button>

        </div>

    </div>




    <?php } ?>
    <?php require('requires/footer.php'); ?>
    <?php require('requires/loginModal.php'); ?>
    </body>
    <script>
    // checkoutsubmit
    $("#checkoutsubmit").click(function(event) {
      
        var ccnum = document.getElementById("ccnum").value;
        var expmonth = document.getElementById("expmonth").value;
        var expyear = document.getElementById("expyear").value;
        var cvv = document.getElementById("cvv").value;



        if (ccnum == '') {
            alert("asa");

            $("#errorMsgcheckout").html(
                "<span class='alert alert-danger' style='width: 100%;float: left;text-align: center'>Please enter card number</span>"
            ).show().delay(3000).fadeOut('slow');
            $("#ccnum").focus();
            return;
        } else {
            $("#errorMsgcheckout").html("");

        }
        if (expmonth == '') {
            $("#errorMsgcheckout").html(
                "<span class='alert alert-danger' style='width: 100%;float: left;text-align: center'>Please enter expiry month</span>"
            ).show().delay(3000).fadeOut('slow');
            $("#expmonth").focus();
            return;
        } else {
            $("#errorMsgcheckout").html("");

        }
        if (expyear == '') {
            $("#errorMsgcheckout").html(
                "<span class='alert alert-danger' style='width: 100%;float: left;text-align: center'>Please enter expiry year</span>"
            ).show().delay(3000).fadeOut('slow');
            $("#expyear").focus();
            return;
        } else {
            $("#errorMsgcheckout").html("");

        }

        if (cvv == '') {
            $("#errorMsgcheckout").html(
                "<span class='alert alert-danger' style='width: 100%;float: left;text-align: center'>Please enter cvv</span>"
            ).show().delay(3000).fadeOut('slow');
            $("#cvv").focus();
            return;
        } else {
            $("#errorMsgcheckout").html("");
            event.preventDefault();
            $.ajax({
                type: 'POST',
                url: './requires/checkout.php',
                data: $('form').serialize(),
                success: function(data) {
                    alert(data);
                    $("#errorMsgcheckout").html(data).show().delay(3000).fadeOut('slow');
                }
            });
        }
    });
    </script>

</html>