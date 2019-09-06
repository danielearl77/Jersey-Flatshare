<?php
include_once("functions.php");
$propertyID = $_POST['prop1'];
$getMapPropertyQ = "SELECT * FROM `".DBN."`.`shareLandlord` WHERE `shareLandlord`.`sID` = '$propertyID' ";
$getMapPropResult = mysqli_query($link, $getMapPropertyQ);
if( mysqli_num_rows($getMapPropResult) == 1 ){ $mapProperty = mysqli_fetch_assoc($getMapPropResult); }
$street = $mapProperty['sStreet'];
$town = $mapProperty['sTown'];
$postcode = $mapProperty['sPostcode'];
echo $street . "-" . $town . "-" . $postcode;
?>