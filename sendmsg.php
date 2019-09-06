<?php
    // contact landlord code here
    include_once("php/functions.php");
    $landlordID = $_POST['prop1'];
    $getEmailAddress = "
        SELECT * FROM `".DBN."`.`shareLandlord`
        WHERE `shareLandlord`.`sID` = '$landlordID'";
    $res = mysqli_query($link, $getEmailAddress);
    if( mysqli_num_rows($res) == 1 ){
        $useLandlord = mysqli_fetch_assoc($res);
    } else {
        $msg = "Error: Could not send message. Please try again";
    }                    
    $toEmailAddress = $useLandlord['sEmail'];                    
    $nameOfSharer = clean_up_input($_POST['name1']);
    $emailOfSharer = clean_up_input($_POST['email1']);
    $telOfSharer = clean_up_input($_POST['tel1']);
    $messageFromSharer = clean_up_input($_POST['msg1']);                    
    $subject = "Someone wants to rent your room.";
    $headers = "From: " . $emailOfSharer . "\r\n" . "Reply-To: " . $emailOfSharer; 
    $wrapMessage = wordwrap($messageFromSharer, 70, "\r\n");              
    $message = "Sharer Name: " . $nameOfSharer . "\r\n" . "Sharer Email Address: " . $emailOfSharer . "\r\n" . "Sharer Phone: " . $telOfSharer . "\r\n" . $wrapMessage;                    
    //send the message
    if ($_POST['name1'] == "" or $_POST['email1'] == "" ) {
        $msg = "Error: Name or Email Address not supplied. Please try again.";
    } else if( mail($toEmailAddress, $subject, $message, $headers) ) { 
        $msg = "Thank You, Message Sent. The Landlord should be in touch soon. ";
    } else { 
        $msg = "Error: Could not send message. Please try again";
    }
    echo $msg;
?>  