<?php
//Functions and Utils
// --- Database Code Local --- //
// define('HST','localhost');
// define('USR','root');
// define('PSW','root');
// define('DBN','g1v7c_854nz');
// --- Database Code Live --- //
//define('HST','norwichcitynewscouk.fatcowmysql.com');
//define('USR','testing');
//define('PSW','zaqwsx');
//define('DBN','g1v7c_854nz');
define('HST','norwichcitynewscouk.fatcowmysql.com');
define('USR','hjxa04_9t3jq8');
define('PSW','RIsMGc8jBU90');
define('DBN','g1v7c_854nz');
$link = mysqli_connect(HST, USR, PSW) or $failMsg = "Could not connect to server.";
mysqli_select_db($link, DBN) or $failMsg = "Could not connect to DB.";
function test_input_data($inputData) {
	$inputData = trim($inputData);
	$inputData = addslashes($inputData);
	$inputData = htmlspecialchars($inputData);
	return $inputData;
}
if( isset($_GET['sign']) && $_GET['sign'] == 'out' ){
	session_destroy();
	header("Location: index.html");
}
?>