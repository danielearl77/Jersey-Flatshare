<?php
include_once("functions.php");
$propertyID = $_POST['prop1'];
$propertyStreet = $_POST['street1'];
$propertyTown = $_POST['town1'];
$propertyPostcode = $_POST['postcode1'];
$updateQ = " UPDATE `".DBN."`.`shareLandlord` 
        SET
					`shareLandlord`.`sStreet` = '$propertyStreet',
					`shareLandlord`.`sTown` = '$propertyTown',
					`shareLandlord`.`sPostcode` = '$propertyPostcode'
        WHERE
					`shareLandlord`.`sID` = '$propertyID'
        ";
$eRes = mysqli_query($link, $updateQ);
if( mysqli_affected_rows($link) == 1 ){ $msg = 'Address Details Updated.'; } else { $msg = 'Could not update details.'; }
echo $msg;
?>