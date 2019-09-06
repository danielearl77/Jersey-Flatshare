<?php
    include_once("functions.php");
    // Select Correct Page to Display Code
    $pageType = (int)$_GET['page'];
    
    // Add Flat or House Share Code
    if(isset($_POST['addShareBtn'])) {

        //create folder name to store property details and pics
        $folder = time() . rand(0,999);
        $imgFolder = $folder . "/img";
        
        //create landlord DB Entry
        if( $_POST['shareName'] != NULL && 
            $_POST['shareEmail'] != NULL &&
            $_POST['shareStreet'] != NULL &&
            $_POST['sharePassword'] != NULL &&
            $_POST['sharePhone'] != NULL && 
            $_POST['sharePostcode'] != NULL && 
            $_POST['shareTown'] != NULL &&
            $_POST['shareType'] != NULL && 
            $_POST['shareRent'] != NULL ) {
            $notBlank = true;
        } else {
            $notBlank = false;
        }
        
        $sName = test_input_data($_POST['shareName']);
        $sEmail = test_input_data($_POST['shareEmail']);
        $sStreet = test_input_data($_POST['shareStreet']);
        $sPassword = SHA1($_POST['sharePassword']);
        $sPhone = test_input_data($_POST['sharePhone']);
        $sPostcode = test_input_data($_POST['sharePostcode']);
        $cleanTown = clean_up_input($_POST['shareTown']);
        $sTown = test_input_data($cleanTown);
        $cleanPropertyType = clean_up_input($_POST['shareType']);
        $sPropertyType = test_input_data($cleanPropertyType);
        $cleanRent = clean_up_input($_POST['shareRent']);
        $sRent = test_input_data($cleanRent);
        
        $sRentType = $_POST['shareRentType'];
        
        if (!preg_match("/^[a-zA-Z ]*$/",$sName)) {
            $realName = false;    
        } else {
            $realName = true;
            $sName = mysqli_real_escape_string($link, $sName);
        }
        
        if (!filter_var($sEmail, FILTER_VALIDATE_EMAIL)) {
  	         $notRealEmail = true; 
        } else {
            $notRealEmail = false;
            $sEmail = mysqli_real_escape_string($link, $sEmail);
        }
     
        if ( $notBlank && $realName && !$notRealEmail ) {
            $allDataValid = true;
        } else {
            $allDataValid = false;
            $successMsg = "<p class='text-center bg-danger msg'>Sorry, something has gone wrong. Your property has not been added.</p>";
        }
            
        if($allDataValid) {
            $sPhone = mysqli_real_escape_string($link, $sPhone);
            $sPostcode = mysqli_real_escape_string($link, $sPostcode);
            $sTown = mysqli_real_escape_string($link, $sTown);
            $sStreet = mysqli_real_escape_string($link, $sStreet);
            $sPropertyType = mysqli_real_escape_string($link, $sPropertyType);
            $sRent = mysqli_real_escape_string($link, $sRent);
            
            //save photos but leave DB flag to hidden pending
            mkdir($folder);
            mkdir($imgFolder);
            // code to check if photo has been added //
            $isPhotoOne = TRUE;
            $isPhotoTwo = TRUE;
            if($_FILES['photoOne']["name"] == ""){
                $isPhotoOne = FALSE;
            }
            if($_FILES['photoTwo']["name"] == ""){
                $isPhotoTwo = FALSE;
            }
           
            $uploadDir = $imgFolder;
                
            if($isPhotoOne) {
                $finalFileNameOne = $uploadDir . "/" . basename($_FILES["photoOne"]["name"]);
                $tempFileNameOne = $_FILES['photoOne']['tmp_name'];
                move_uploaded_file($tempFileNameOne,$finalFileNameOne);
                $photoOne = TRUE;
            } else {
                $finalFileNameOne = "noImg.png";
                $photoOne = FALSE;
            }
            
            if($isPhotoTwo) {
                $finalFileNameTwo = $uploadDir . "/" . basename($_FILES["photoTwo"]["name"]);
                $tempFileNameTwo = $_FILES['photoTwo']['tmp_name'];
                move_uploaded_file($tempFileNameTwo,$finalFileNameTwo);
                $photoTwo = TRUE;
            } else {
                $finalFileNameTwo = "noImg.png";
                $photoTwo = FALSE;
            }
            
            if( $photoTwo == FALSE and $photoOne == FALSE) {
                $isPhotoValid = 1;
            } else {
                $isPhotoValid = 0;
            }
            
            $shareQ = "
                INSERT INTO `".DBN."`.`shareLandlord`
                    (
                    `shareLandlord`.`sName`,
                    `shareLandlord`.`sEmail`,
                    `shareLandlord`.`sPassword`,
                    `shareLandlord`.`sPhone`,
                    `shareLandlord`.`sPostcode`,
                    `shareLandlord`.`sTown`,
                    `shareLandlord`.`sStreet`,
                    `shareLandlord`.`sPropType`,
                    `shareLandlord`.`sRent`,
                    `shareLandlord`.`sRentType`,
                    `shareLandlord`.`sDir`,
                    `shareLandlord`.`sPicOne`,
                    `shareLandlord`.`sPicTwo`,
                    `shareLandlord`.`sPhotoValid`
                    )
                VALUES
                    (
                    '$sName',
                    '$sEmail',
                    '$sPassword',
                    '$sPhone',
                    '$sPostcode',
                    '$sTown',
                    '$sStreet',
                    '$sPropertyType',
                    '$sRent',
                    '$sRentType',
                    '$folder',
                    '$finalFileNameOne',
                    '$finalFileNameTwo',
                    '$isPhotoValid'
                    )
            ";
            
            $result = mysqli_query($link, $shareQ);
            
            if( mysqli_affected_rows($link) == 1  ){
                //create folder to store property description
                //create property description doc
                $sDescription = clean_up_input($_POST['shareDescription']);
                //$sDescription = $_POST['shareDescription'];
                $sDescripFile = $folder . "/description.dre";
                $fileDescription = fopen($sDescripFile, "w");
                fwrite($fileDescription, $sDescription);
                fclose($fileDescription);
                $successMsg = "<p class='text-center bg-success msg'>Thank You, Your property has been added.</p>";
            } else {
                $successMsg = "<p class='msg text-center bg-danger'>Sorry, something has gone wrong. Your property has not been added.</p>";
            }
        }     
    } // END ADD FLAT or HOUSE SHARE
    
    // Remove Listing Code
    if(isset($_POST['removeBtn'])) {
        $isLoggedIn = FALSE;        
        // get login details and log in
        if( $_POST['removeName'] != NULL && 
            $_POST['removePassword'] != NULL ) {
            $notBlank = true;
        } else {
            $notBlank = false;
        }
        
        $remName = test_input_data($_POST['removeName']);
        
        if (!filter_var($remName, FILTER_VALIDATE_EMAIL)) {
  	         $notRealEmail = true; 
        } else {
            $notRealEmail = false;
            $remEmail = mysqli_real_escape_string($link, $remName);
            $remPassword = SHA1($_POST['removePassword']);
        }

        $showFlatshareD = "SELECT * FROM `".DBN."`.`shareLandlord`
                            WHERE `shareLandlord`.`sEmail` = '$remEmail'
                            AND `shareLandlord`.`sPassword` = '$remPassword' ";
            
        $showShareResultD = mysqli_query($link, $showFlatshareD);
        if( mysqli_num_rows($showShareResultD) >0 ){
            $listOfSharesD = array();
            while( $row = mysqli_fetch_assoc($showShareResultD) ){
                array_push($listOfSharesD, $row);
            }	
            $isLoggedIn = TRUE;
        } else {
            $isLoggedIn = FALSE;
        }
   
        if(!$isLoggedIn) {
            $loginMsg = "<p class='msg text-center bg-danger'>Error: Wrong Username or Password or No Listing</p>";    
        }     
    } // END REMOVE LISTING
    
    //Delete selected Property
    if(isset($_POST['delProperty'])) {
        $toBeDel = $_POST['PropID'];
        
            // use $toBeDel to get directory containing text and img
        $getDirQ = "SELECT * FROM `".DBN."`.`shareLandlord` WHERE `shareLandlord`.`sID` = '$toBeDel'";
        $getDirRes = mysqli_query($link, $getDirQ);
                        if( mysqli_num_rows($getDirRes) == 1 ){
                            $useDir = mysqli_fetch_assoc($getDirRes);
                            $removeThisDir = $useDir['sDir'];
                            // unlink contents of img dir
                            $removeImgFiles = $removeThisDir . "/img/*.*";
                            array_map('unlink', glob($removeImgFiles));
                            $removeImgDir = $removeThisDir . "/img";
                            rmdir($removeImgDir);
                            $removeText = $removeThisDir . "/description.dre";
                            unlink($removeText);
                            rmdir($removeThisDir);
                        } 
		$delPropQ = "DELETE FROM `".DBN."`.`shareLandlord` WHERE `shareLandlord`.`sID` = '$toBeDel'";
		$delPropResult = mysqli_query($link, $delPropQ);
		if( mysqli_affected_rows($link) == 1 ){
			$msg = "<p class='msg text-center bg-success'>Property Listing successfully removed</p>";
            $isLoggedIn = FALSE;
		} else {
			$msg = "<p class='msg text-center bg-danger'>Error: Could not delete property</p>";
		}//end DELETE    
    } // END DEL PROP
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../images/favicon.ico">
    <title>Jersey Flatshare - Landlord Section</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/flatshare.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    
    <nav class="navbar navbar-default navbar-fixed-top customColor">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="../index.php">Jersey Flatshare</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="../index.php">Main Site</a></li>
            <li><a href="../index.php#contact">Contact Us</a></li>
              <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Landlords<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="landlords.php?page=1">Add Flatshare</a></li>
<!--                <li><a href="landlords.php?page=2">Add Property</a></li>-->
                <li role="separator" class="divider"></li>
                <li><a href="landlords.php?page=3">Remove Listing</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    
    <?php if($pageType == 1){ ?>
        <div class="container">
            <noscript><p class="text-danger text-center">Please note that some menu options and other functionality on this website only work properly with javascript enabled.</p></noscript>
            <h3>Add Flat or House Share</h3>
            <p class="text-justify">Add a flat or house share to our listings here.  Please make sure you have fully read our terms and conditions before adding a listing. Please also make sure you have fully read The States of Jersey <a href="http://www.gov.je/Home/RentingBuying/OtherRentalOptions/Pages/LodgingHouseAdmin.aspx" target="_blank">information regarding Lodging Houses</a>.</p>
            <p class="text-justify">Give as much detail as you can, including one or two photos.  Please note that <span class="text-danger">once published you can not edit your listing</span> so please take the time check it over before hitting submit.  This includes adding photos or changing photos at a later date.  If you do publish your listing and want to change anything you will have to remove it and start again.</p>  
            <p class="text-justify">Please make sure you provide a password so that you can remove the listing once it has been let. If you forget your password contact us and we will remove your listing for you.</p>
            
            <?php echo $successMsg;?>
            
            <form action="<?php $aaa = "#"; echo htmlspecialchars($aaa);?>" method="post" enctype="multipart/form-data"><div class="form-group">
            
                <label>Landlord Details</label><br>
                <div class="row">
                <div class="col-sm-3"><input class="form-control" type="text" name="shareName" placeholder="Name"></div>
                <div class="col-sm-3"><input class="form-control" type="email" name="shareEmail" placeholder="Email Address"></div>
                <div class="col-sm-3"><input class="form-control" type="password" name="sharePassword" placeholder="Password"></div>
                <div class="col-sm-3"><input class="form-control" type="tel" name="sharePhone" placeholder="Telephone Number"></div>
                </div>
                
                <hr>
                <label>Property Details</label><br>
                <div class="row">
                <div class="col-sm-2"><input class="form-control" type="text" name="shareStreet" placeholder="Street"></div>
                <div class="col-sm-2"><input class="form-control" type="text" name="shareTown" placeholder="Town"></div>
                <div class="col-sm-2"><input class="form-control" type="text" name="sharePostcode" placeholder="Postcode"></div>
                <div class="col-sm-2"><input class="form-control" type="text" name="shareType" placeholder="Type of Property"></div>
                <div class="col-sm-2"><input class="form-control" type="text" name="shareRent" placeholder="Rent"></div>
                <div class="col-sm-2"><select class="form-control" name="shareRentType">
                    <option>Frequency</option>
                    <option>Per Week</option>
                    <option>Per Month</option>
                </select></div>
                </div>
                <br>
                <textarea class="form-control" rows="4" name="shareDescription" placeholder="Description of Property"></textarea>
                <hr>
                <label>Photos</label><br>
                <p>Choose Two photos to add to your listing. If the file size of your photo is large it may take a while to add the listing.  Small photos upload quicker and can be viewed by our users quicker that big high definition photographs. <span id="iOSFix">If you are using iOS or Android please upload one image only.</span></p>
                <input type="file" name="photoOne" id="photoOne">
                <input type="file" name="photoTwo" id="photoTwo">
                <hr>
                <div id="waitingForUpload" hidden><p class="bg-warning msg text-center">Adding Listing -- Please Wait -- With Large Photos This May Take Some Time</p></div>
                <button id="addPropertyButton" class="btn btn-primary" type="submit" name="addShareBtn" onclick="disableFunction()">Add Listing</button>
                <button id="resetFormButton" class="btn btn-warning" type="reset">Clear Form and Start Again</button>
                <script> function disableFunction() { $("#addPropertyButton").addClass("disabled"); $("#resetFormButton").addClass("disabled"); $("#waitingForUpload").show();} </script>
            </div></form>  
          </div>
    <?php } if($pageType == 2) { ?>
        <div class="container">
            <h3>Opps! Something appears to have broken.</h3>
            <p>Please choose a link from the top of the page to continue.</p>
        </div>
    <?php } if($pageType == 3) { ?>
        
        <div class="container">
            <p><?php echo $testD;?></p>
            <p><?php echo $testE;?></p>
            <noscript><p class="text-danger text-center">Please note that some menu options and other functionality on this website only work properly with javascript enabled.</p></noscript>
            <?php echo $msg;?>
            <h3>Remove Property Listing</h3>
            <p class="text-justify">If your listing has been rented out or you longer wish to list your property on this site use to form below to log in and remove your listing.</p>
            <form action="<?php $bbb = "#"; echo htmlspecialchars($bbb);?>" method="post"><div class="form-group">
            <div class="row">
                <div class="col-sm-4"><input class="form-control" type="email" name="removeName" placeholder="Email Address used to Register"></div>
                <div class="col-sm-3"><input class="form-control" type="password" name="removePassword" placeholder="Password"></div>
                <div class="col-sm-3"><button class="btn btn-primary" id="removeBtn" type="submit" name="removeBtn">Log In</button></div>
            </div>
            <?php echo $loginMsg;?>
            <hr>
            </div></form>
            <?php if($isLoggedIn) { ?> 
                <h3>Select Listing to Remove</h3>
                <div class="row">
                <?php foreach($listOfSharesD as $logInProp) { ?>
                <div class="col-sm-3">
                    <p>Postcode of Property: <?php echo $logInProp['sPostcode'];?></p>
                    <p>Property Type: <?php echo $logInProp['sPropType'];?></p>
                    <p>Rent: <?php echo $logInProp['sRent'];?></p>
                    <button class="btn btn-danger" data-toggle="modal" data-target="#delModal" data-propid="<?php echo $logInProp['sID'];?>">Remove Property</button>
                    <div id="delModal" class="modal fade" role="dialog">
                  <div class="modal-dialog modal-sm">
                      <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Remove Propery Listing</h4>
                    </div>
                    <div class="modal-body">
                        <p class="bg-warning msg">Remove Listing - Are you sure?</p>
                    </div>
                    <div class="modal-footer">
                        <form action="<?php $ccc = "#"; echo htmlspecialchars($ccc);?>" method="post">
                            <input type="text" name="PropID" id="propid" hidden>
                            <button class="btn btn-danger" type="submit" name="delProperty">Remove Property</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </form>
                    </div>
                      </div>
                  </div>
                </div>    
                </div>  
                <?php } //end of cycle through list ?>
                </div>
            <?php } ?>
        </div>
    <?php } if($pageType > 3 or $pageType == 0) { ?>
        <div class="container">
            <h3>Opps! Something appears to have broken.</h3>
            <p class="text-justify">Please choose a link from the top of the page to continue.</p>
        </div>
    <?php } ?>
         
<footer class="footer">
      <div class="container">
        <p class="text-muted">Jersey Flatshare &copy;2016 | <a href="terms.php">Click Here for The Legal Bit</a> </p>
      </div>
</footer>


    <!-- Bootstrap core JavaScript -->
    <script src="../js/jquery-1.11.3.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/ie10-viewport-bug-workaround.js"></script>
    <script>
        $('#delModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); 
        var id = button.data('propid');
        var modal = $(this);
        modal.find('.modal-footer #propid').val(id);
        })
    </script>
</body>
</html>
