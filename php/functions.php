<?php
// DB Login removed from here.

$link = mysqli_connect(HST, USR, PSW) or $failMsg = "Could not connect to server.";
mysqli_select_db($link, DBN) or $failMsg = "Could not connect to DB.";

function test_input_data($inputData) {
	$inputData = trim($inputData);
	$inputData = addslashes($inputData);
	$inputData = htmlspecialchars($inputData);
	return $inputData;
}

function clean_up_input($text)  {
    $forCleaning = $text;
    $swears = array("shit", "fuck", "fucking", "bollocks", "cunt", "cnut", "twat", "fucker", "shite", "nigger", "niggers");
    foreach($swears as $swear) {
        $forCleaning = str_ireplace($swear, "****", $forCleaning); 
    }
    $cleanText = $forCleaning;
    return $cleanText;
}

?>
