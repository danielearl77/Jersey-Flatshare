<?php
if( !isset($_SESSION) ){
    session_start();
}

// Logged into Admin Section
include_once("functions.php");
if(isset($_POST['approve'])) {
    $propertyPhotoID = test_input_data($_POST['photoPropID']);    
    $updateQ = " UPDATE `".DBN."`.`shareLandlord` 
        SET
					`shareLandlord`.`sPhotoValid` = '1'
        WHERE
					`shareLandlord`.`sID` = '$propertyPhotoID'
        ";
    $eRes = mysqli_query($link, $updateQ); 
}

if(isset($_POST['reject'])) {
    $rejectImg = "noImg.png";
    $propertyPhotoID = test_input_data($_POST['photoPropID']);    
    $updateQ = " UPDATE `".DBN."`.`shareLandlord` 
        SET
					`shareLandlord`.`sPicOne` = '$rejectImg',
                    `shareLandlord`.`sPicTwo` = '$rejectImg',
                    `shareLandlord`.`sPhotoValid` = '1'
        WHERE
					`shareLandlord`.`sID` = '$propertyPhotoID'
        ";
    $eRes = mysqli_query($link, $updateQ); 
}

$showLandlordDetailsQ = "SELECT * FROM `".DBN."`.`shareLandlord` ORDER BY `shareLandlord`.`sID` DESC"; 
$showLandlordResult = mysqli_query($link, $showLandlordDetailsQ);
if( mysqli_num_rows($showLandlordResult) > 0 ){
    $listOfLandlord = array();
    while( $row = mysqli_fetch_assoc($showLandlordResult) ){
        array_push($listOfLandlord, $row);
    }	
}
$valid = 0;
$showPhotosQ = "SELECT * FROM `".DBN."`.`shareLandlord` WHERE `shareLandlord`.`sPhotoValid` = '$valid' ";
$showPhotosResult = mysqli_query($link, $showPhotosQ);
if( mysqli_num_rows($showPhotosResult) > 0 ){
    $listOfPhoto = array();
    while( $row = mysqli_fetch_assoc($showPhotosResult) ){
        array_push($listOfPhoto, $row);
    }
}
$numberOfTBV = count($listOfPhoto);

if($numberOfTBV == 0) {
    $doNotShow = TRUE;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <title>-</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="signin.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
     <?php if($_SESSION['isLoggedIn'] == 1) { ?>
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Jersey Flatshare Admin</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="#photoApprove">Approve Photos</a></li>
            <li><a href="#mapEdit">Edit Map Pins</a></li>
            <li><a href="#landlordDetails">View Landlord Details</a></li>
            </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="?sign=out">Sign Out</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

   
    <div class="container"> 
        <div id="photoApprove">
        <!-- List of DB entries with photos to approve here -->
            <h2>Approve Photos</h2>
            
            <?php if(!$doNotShow) { ?>
            <form action="#" method="post">
            
            <?php 
            
                
            $propIndexCounter = '0';
            $picOne = "../php/" . $listOfPhoto[$propIndexCounter]['sPicOne'];
            $picTwo = "../php/" . $listOfPhoto[$propIndexCounter]['sPicTwo'];
            
            ?>
            <label>Property ID: </label>    
            <input id="photoPropID" type="text" name="photoPropID" value="<?php echo $listOfPhoto[$propIndexCounter]['sID'];?>" readonly><br>
            <label>Number to Check: <?php echo $numberOfTBV;?></label>    
            <br><br>
            <img class="img-responsive img-thumbnail" src="<?php echo $picOne;?>">
            <img class="img-responsive img-thumbnail" src="<?php echo $picTwo;?>">
            <br><br>
<!--            <button class="btn btn-primary" type="submit" name="next">Next Property</button>-->
            <button class="btn btn-success" type="submit" name="approve">Approve</button>
            <button class="btn btn-danger" type="submit" name="reject">Reject</button>
            <br>
            <p><?php echo $testMsg;?></p>
            </form>
            <?php } else { ?>
            <p>No Photos to Check</p>
            <?php } ?>
        </div>
        
        <div id="mapEdit">
        <!-- Search box to find property to then edit map location display here -->
            <h2>Edit Map Display</h2>
            
            <input type="text" name="mapPropId" id="propID" placeholder="Property ID"><br><br>
            <button id="getMapProp" class="btn btn-primary">Get</button>
            <button id="submitUpdateMap" class="btn btn-warning">Update</button><br><br>
            <input id="resStreet" type="text" placeholder="Street"><br>
            <input id="resTown" type="text" placeholder="Town"><br>
            <input id="resPost" type="text" placeholder="Postcode"><br>
            
            <p id="mapResult"></p>
        </div>
        
        <div id="landlordDetails">
        <!-- List of all DB entries on request, with options to narrow down search here -->
            <h2>Landlord Details</h2> 
            <?php foreach($listOfLandlord as $landlord) { ?>
                <p>Property ID: <?php echo $landlord['sID'];?></p>
                <p>Name: <?php echo $landlord['sName'];?></p>
                <p>Email: <?php echo $landlord['sEmail'];?></p>
                <p>Phone: <?php echo $landlord['sPhone'];?></p>
                <p>Property Address: <?php echo $landlord['sStreet'];?>, <?php echo $landlord['sTown'];?>, <?php echo $landlord['sPostcode'];?></p>
                <hr>
            <?php } ?> 
        </div>  
    </div> <!-- /container -->
    <?php  } else { ?>

    <div class="containter">
        <div class="errorMsgStyle">
            <h1>ERROR</h1>
            <h2>Something appears to have gone wrong!</h2>
            <p>Click <a href="index.html">here</a> to go home.</p>
        </div>
    </div>  
    <?php } ?>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
    <script src="js/jfadmin.js"></script>
  </body>
</html>
