<!doctype html>
<html lang="en">


<?php require('requires/head.php');  ?>



<!-- your content here... -->
<header id="overlay" style="position: relative;">
    <img src="assets/images/banner-image.jpg" style="width:100%;" alt="book store cover image">
</header>

<div class="container" style="width:85%; margin-left: auto; margin-right: auto;">
    <div class="row">
        <div class="col-3">

            <?php

                
            ?>

            <form method='POST' style='margin-top:60px;'>
                <!--<div class="list-group">-->
                <input type="submit" class="list-group-item list-group-item-action active" name='all_manufacturers'
                    value='All Manufacturers' />
                <input type="submit" class="list-group-item list-group-item-action" name='bmw' value='BMW' />
                <input type="submit" class="list-group-item list-group-item-action" name='nissan' value='Nissan' />
                <input type="submit" class="list-group-item list-group-item-action" name='toyota' value='Toyota' />

                <!--</div>-->
            </form>
        </div>
        <div class="col-9">
            <section id="cars" class="py-2">
                <div class="container-fluid px-4 px-lg-5 mt-5">
                    <div class="row gx-4 gx-lg-5 row-cols-1 row-cols-md-2 row-cols-xl-2 justify-content-center">
                        <?php

                    require('requires/mysqli_connect.php');
                
    
                    if(array_key_exists('all_manufacturers', $_POST)) {
                        $brandname = '';
                        car_display($brandname,$dbc);
                    }
                    else if(array_key_exists('bmw', $_POST)) {
                        $brandname = 'bmw';
                        car_display($brandname,$dbc);

                    }
                    else if(array_key_exists('nissan', $_POST)) {
                        $brandname = 'nissan';
                        car_display($brandname,$dbc);
                    }
                    else if(array_key_exists('toyota', $_POST)) {
                        $brandname = 'toyota';
                        car_display($brandname,$dbc);
                    }
                    else {
                        $brandname = '';
                        car_display($brandname,$dbc);
                    }
                    

                    function car_display($brandname, $dbc) {

                        if($brandname == ''){
                            $q = "SELECT tblvehicles.VehiclesTitle,tblbrands.BrandName,tblvehicles.PricePerDay,tblvehicles.FuelType,tblvehicles.ModelYear,
                        tblvehicles.id,tblvehicles.SeatingCapacity,tblvehicles.VehiclesOverview,tblvehicles.Vimage1
                        from tblvehicles join tblbrands on tblbrands.id=tblvehicles.VehiclesBrand";
                        $res=mysqli_query($dbc,$q) OR mysqli_error($dbc);
                        }  

                        else{

                        $q = "SELECT tblvehicles.VehiclesTitle,tblbrands.BrandName,tblvehicles.PricePerDay,tblvehicles.FuelType,tblvehicles.ModelYear,
                        tblvehicles.id,tblvehicles.SeatingCapacity,tblvehicles.VehiclesOverview,tblvehicles.Vimage1
                        from tblvehicles join tblbrands on tblbrands.id=tblvehicles.VehiclesBrand
                        WHERE tblbrands.BrandName = '" . $brandname . "';";
                        $res=mysqli_query($dbc,$q) OR mysqli_error($dbc);  
                        } 
                        while($r=mysqli_fetch_array($res)){
        
                    echo "<div class='col mb-5'>
                        <div class='card h-100'>
                        <div style='position:relative;'>
                        <a href='#'><img class='card-img-top img-responsive' style='object-fit:cover;' src='assets/images/".$r['Vimage1']."' alt='...' /></a>
                        <ul style='position:absolute;list-style-type:none;' class='text-white list-inline transparent-details'>
                                <li class='list-inline-item'><i class='fa fa-car' aria-hidden='true'></i> ".$r['FuelType']."</li>
                                <li class='list-inline-item'><i class='fa fa-calendar' aria-hidden='true'></i> ".$r['ModelYear']. " Model</li>
                                <li class='list-inline-item'><i class='fa fa-user' aria-hidden='true'></i> ".$r['SeatingCapacity']." seats</li>
                                </ul>
                            </div>
                        <div class='card-body p-4'>
                                <div class='text-center'>
                                    <h5 class='fw-bolder'>".$r['BrandName']." : ".$r['VehiclesTitle']."</h5>
                                    $".$r['PricePerDay']." per day
                                </div>
                            </div>
                            <div class='text-center card-footer p-4 pt-0 border-top-0 bg-transparent'>
                                <Span class='text-center'><a class='btn btncolor mt-auto' href='checkout.php?Book_ID=".$r['PricePerDay']."'>View Details</a></span> &nbsp;
                            
                            </div>
                        </div>
                    </div>";
                        }

                    
                }

                
                    ?>


                    </div>
                </div>
            </section>

        </div>
    </div>
</div>




<?php require('requires/footer.php'); ?>


</body>

</html>