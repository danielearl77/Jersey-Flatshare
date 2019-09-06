<?php
    include_once("php/functions.php");
// Contact Form Code Here
if(isset($_POST['contactForm'])) {
    $toEmail = "info@jerseyflatshare.com";
    $cFormSubject = "Question from Website";
    $cFormName = test_input_data($_POST['contactFormName']);
    $cFormEmail = test_input_data($_POST['contactFormEmail']);
    $cFormHeaders = "From: " . $cFormEmail . "\r\n" . "Reply-To: " . $cFormEmail;
    $cFormMsg = "Name: " . $cFormName . "\r\nEmail: " . $cFormEmail . "\r\n" . "Message\r\n" . wordwrap($_POST['contactFormMsg'], 70, "\r\n");
    // validation code for input here.
    if ($cFormEmail == "" or $_POST['contactFormName'] == "" ) {
        $contactMsg = "<p class='text-center bg-danger msg'>Error: Name or Email Address not supplied. Please try again.</p>";
    } else if( mail($toEmail, $cFormSubject, $cFormMsg, $cFormHeaders) ) { 
        $contactMsg = "<p class='text-center bg-success msg'>Message Sent</p>";   
    } else { 
        $contactMsg = "<p class='text-center bg-danger msg'>Error: Could not send message. Please try again</p>";
    }
}
// Load Flatshare Code Here
	$showFlatshareQ = "SELECT * FROM `".DBN."`.`shareLandlord` ORDER BY `shareLandlord`.`sID` DESC"; 
	$showShareResult = mysqli_query($link, $showFlatshareQ);
	if( mysqli_num_rows($showShareResult) >0 ){
		$listOfShares = array();
		while( $row = mysqli_fetch_assoc($showShareResult) ){
			array_push($listOfShares, $row);
    }	
        $noShares = FALSE;
	} else {
		$noShares = TRUE;
	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js">
    </script>
    <script>
      (adsbygoogle = window.adsbygoogle || []).push({
        google_ad_client: "ca-pub-1798485712270431",
        enable_page_level_ads: true
      });
    </script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Jersey Flatshare: The place to rent out your spare room.  The place to find a spare room to rent!">
    <meta name="keywords" content="Jersey, Property, Landlords, Flats, Houses, Apartments, Rent, Lodging Houses">
    <meta name="author" content="Jersey Flatshare Coders">
    <link rel="icon" href="images/favicon.ico">

    <title>Jersey Flatshare - Home</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/flatshare.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
      ga('create', 'UA-74704675-3', 'auto');
      ga('send', 'pageview');
    </script>
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
          <a class="navbar-brand" href="#">Jersey Flatshare</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="#flatshares">Flatshares</a></li>
            <li><a href="#about">About Us</a></li>
            <li><a href="#contact">Contact Us</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Landlords<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="php/landlords.php?page=1">Add Flatshare</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="php/landlords.php?page=3">Remove Listing</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
      
        <div id="cookieWarning" hidden>
            <p class="text-center">This site uses cookies.  By clearing this message you consent to the use of cookies.  Please see our terms of use page for more information. <button class="btn btn-primary btn-xs" onclick="cookieClose()">Close</button></p>
        </div>
         
        <div class="jumbotron text-center">
              <div class="container">
              <h1 class="textShadow">Jersey Flatshare</h1>
                <p class="textShadow">Looking for a room to rent in Jersey? Have a room you want to rent out on Jersey?</p>
                <p class="textShadow">If so then this is the site for you!</p>
                <p class="jumboSmall">
                    <a class="btn btn-default btn-lg" href="#moving" role="button">Moving to Jersey</a>
                    <a class="btn btn-default btn-lg" href="#flatshares" role="button">Flatshares</a>
              </p>
                <noscript><p class="text-danger text-center noscriptBack">Please note that some menu options and other functionality on this website only work properly with javascript enabled.</p></noscript>
             </div> 
          </div>   

<!--
      <div id="adverts" class="container text-center">
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script> 
            <ins class="adsbygoogle"
                 style="display:inline-block;width:728px;height:90px"
                 data-ad-client="ca-pub-1798485712270431"
                 data-ad-slot="7299397100"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
      </div>
-->
      
      <div id="adverts" class="container text-center ad">
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- JFSResp -->
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="ca-pub-1798485712270431"
                 data-ad-slot="6585349108"
                 data-ad-format="auto"></ins>
            <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
      </div>
      
      <div id="flatshares" class="container-fluid">
          
          <h3>Flatshares</h3>
          <?php if($noShares) { ?>
            <p>Sorry we have no flat or house shares listed at the moment.  Please check back later.</p>
            <p>If you are a looking to rent out a room in your property click on the Landlords link at the top of the page.</p>
          <?php } else { ?>
          
          <div class="row">
            <?php foreach($listOfShares as $shares) { ?>
                <?php 
                    
                    $showMoreText = FALSE;
                    $showLongText = "";
                    
                    $propDir = $shares['sDir'];
                    $propText = "";
                    $propFile = "php/" . $propDir . "/description.dre";
                    $loadedFile = fopen($propFile, "r");
                    if($loadedFile) {
                        while (!feof($loadedFile)) {$propText .= fgets($loadedFile) . "<br>";}
                        fclose($loadedFile);
                    }
    
                    $propTextLen = strlen($propText);
                    if($propTextLen > 130) {
                        $showMoreText = TRUE;
                        $showShortPropText = substr($propText,0,130);
                        $showLongText = strip_tags($propText);
                    } else {
                        $showShortPropText = $propText;
                    }
    
                    
                    if($shares['sPhotoValid'] == 0) {
                        $picOne = "images/waiting.jpg";
                        $picTwo = "images/waiting.jpg";
                        $approvalAlt = "Awaiting Approval";
                    } else {
                        //code here to get photo out of directory and into vars.
                        $picOne = "php/" . $shares['sPicOne'];
                        $picTwo = "php/" . $shares['sPicTwo'];
                        $approvalAlt = "Property Photo";
                    }
                ?>
              <div class="col-sm-3">
                <h4><?php echo $shares['sTown'];?></h4>
                <h5><?php echo $shares['sPropType'];?></h5>
                <?php $rent = "£" . $shares['sRent'] . " " . $shares['sRentType'];?>
                <p><?php echo $rent;?></p>
                <img class="img-responsive img-thumbnail propImg" src="<?php echo $picOne;?>" alt="<?php echo $approvalAlt;?>">
                <img class="img-responsive img-thumbnail propImg" src="<?php echo $picTwo;?>" alt="<?php echo $approvalAlt;?>">
                <p class="minHi"><?php echo $showShortPropText;?> 
                <?php if ($showMoreText) { ?>
                <button class="btn btn-default btn-xs" data-toggle="modal" data-target="#viewMoreText" data-proptext="<?php echo $showLongText;?>">more</button>
                <?php } ?></p>
                <button class="btn btn-primary" data-toggle="modal" data-target="#mapModel" data-post="<?php echo $shares['sPostcode'];?>" data-street="<?php echo $shares['sStreet'];?>" data-town="<?php echo $shares['sTown'];?>">Location</button> 
                
                  <button class="btn btn-primary" data-toggle="modal" data-target="#contactModel" data-propid="<?php echo $shares['sID'];?>">Contact</button>
                                
                <div id="viewMoreText" class="modal fade" role="dialog">
                  <div class="modal-dialog">
                      <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Property Description</h4>
                    </div>
                    <div class="modal-body">
                       <p class="text-justify" id="propDes">Error: The text should be here!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                      </div>
                  </div>
                </div>
                
                <div id="mapModel" class="modal fade" role="dialog">
                  <div class="modal-dialog">
                      <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Propery Location</h4>
                    </div>
                    <div class="modal-body">
                        <iframe id="propMap" src="" width="100%" height="300" frameborder="0" style="border:0"></iframe>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                      </div>
                  </div>
                </div>
                 
                <div id="contactModel" class="modal fade" role="dialog">
                  <div class="modal-dialog">
                      <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Contact Landlord</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="sentID" name="propid" id="propid" hidden>
                            <input class="form-control" type="text" id="name" name="name" placeholder="Your Name"><br>
                            <input class="form-control" type="email" id="email" name="email" placeholder="Your Email Address"><br>
                            <input class="form-control" type="tel" id="tel" name="phone" placeholder="Your Phone Number - optional"><br>
                            <textarea class="form-control" id="msg" name="questions" placeholder="Your Message Here"></textarea><br>
                            <button class="btn btn-primary" id="submitToLandlord" name="sendLandlord">Send Message</button>
                        </div>
                        <p class="text-center" id="mailresult"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                      </div>
                  </div>
                </div>
                <hr>  
            </div>
            <?php } //end of cycle through listings ?>
          </div>
          <?php echo $msg; ?>
          <?php } //end of is there flatshare if ?>
      </div>
      
      <div id="lightbox"><p id="closeLightbox">Close</p><img src="images/waiting.jpg"></div>
      
      <div id="about" class="container-fluid text-justify">
          <h3>About Us</h3>
          <p>Got a spare room to rent on the Island of Jersey and don’t want to pay a fee to advertise it? Looking to rent a room in a house or flat on the Island of Jersey and don't want to pay a fee or register with a site? Then this is the place for you!</p>

          <p><strong>Landlords</strong> do you have a spare room in your house or flat and are looking for a flatmate?  Click on the Landlords link at the top of the page and list your room on this site for free, for as long as you need to.  This site will let you list your room, with as much or as little detail as you like and puts tenants in direct contact with you to arrange viewings and the letting out of the room.  We don’t manage the property for you, as its your house or flat and the point is that you still live there with your flatmate.  We only take the bare minimum information from you to get your listing up on the site.  Tenants contact you by filling in the Contact Landlord form with your listing and will not be given your email address or contact details by us.  The website automatically sends the content of the form to the email address you provided us when you listed the room.  All you then have to do is reply using the email address, or telephone number, the tenant provided you in the Contact Landlord message.  Oh and did we mention there is no fee for landlords.</p>
          
          <p><strong>Flatmates</strong> are you looking for somewhere to live on the Island of Jersey?  Check out our listings for a suitable place to stay, and if you find somewhere you like click the contact landlord button and fill in your details on the form.  The landlord will then get in touch with you to arrange a viewing, either by the email address or telephone number you provide (so think carefully how you want to be contacted).  From this point on we take no further part in the process, everything else, including viewings, rental rates, and terms, is between the landlord and the tenant.  All we do is allow landlords to list rooms and tenants to view the listings and contact the landlords.  Oh and did we mention there is no fee for tenants.</p>
          
          <p><strong>So why are we doing it?</strong> We love the island of Jersey and noticed there are a whole load of high-end websites helping the super rich rent or buy property on the island, but there isn’t really anything for everyone else.  If you’re looking for a flat or housemate the usual letting or estate agents aren’t the best place for you, and a card in the local shop might help you find someone local but isn’t going to give the global reach we can.  If you are renting out a room as part of the lodging houses scheme, this site can advertise your room worldwide at the click of a button.</p>
          
          <p>We are UK-based, and don't charge a fee to either landlord or tenant.  We also won’t keep or sell on your data, and only ask for the bare minimum that we need to list your room.  It’s also worth saying again just to be clear that we don’t manage any property - we just put landlords and tenants together, anything else is between the two parties, check out our terms and conditions for more information on the legal side of things.</p>
      </div>
      
      <div id="moving" class="container-fluid text-justify">
          <h3>Moving to Jersey</h3>
          <p>So you want to move to Jersey?  Well that is understandable as it is a great place to live, warmer average than mainland UK, a quieter and slower pace of life, but everything your used to just a 45 minute flight away from London.  Sounds great but I’m afraid its not as easy as jumping on the plane or ferry and choosing a place to live.  Jersey has rules as to who can buy and rent property on the island and for the latest up to date information check out <a href="http://www.gov.je/LifeEvents/MovingToJersey/Pages/index.aspx" target="_blank">Gov.je moving to Jersey Pages</a>.</p>
        
          <p>Long story short, if your not a multi millionaire then its going to be renting to start with, and if you hold the lowest status then its going to be a room in a house or flat to start with, which is of course where we come in.  If you are looking for a room to rent in a house or flat check out our listing.</p>   
      </div>
      
      <div id="contact" class="container-fluid">
          <h3>Contact Us</h3>
          <?php echo $contactMsg;?>
          <p>Contact us using the form below, <!--or call us,--> we aim to respond within 48 hours.</p>
<!--          <p><span class="glyphicon glyphicon-phone"></span>+44 xxxx xxxxxx</p>-->
          
          <form action="<?php $xxx = "#contact"; echo htmlspecialchars($xxx);?>" method="post"><div class="form-group">
              <input class="form-control" type="text" placeholder="Name" name="contactFormName"><br>
              <input class="form-control" type="email" placeholder="Email Address" name="contactFormEmail"><br>
              <textarea class="form-control" placeholder="Comments or Questions" name="contactFormMsg"></textarea><br>
              <button class="btn btn-primary" type="submit" name="contactForm">Send</button>
              <button class="btn btn-warning" type="reset">Clear Form</button> 
          </div></form> 
      </div>

    <footer class="footer">
      <div class="container">
        <p class="text-muted">Jersey Flatshare &copy;2016 | <a href="php/terms.php">Click Here for The Legal Bit</a> </p>
      </div>
    </footer>
    <!-- Bootstrap core JavaScript -->
    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/ie10-viewport-bug-workaround.js"></script>  
    <!-- Site JavaScript -->
    <script src="js/flatshare.js"></script>
  </body>
</html>
