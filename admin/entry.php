<?php
    include_once("functions.php");
    if( !isset($_SESSION) ){session_start();}
    // Log in Code
    $user = test_input_data($_POST['inputEmail']);
    $password = test_input_data($_POST['inputPassword']);
    $cryptUser = sha1($user);
    $cryptPassword = sha1($password);
    //load in user and password from xml files
    $filename = "dat.xml";
    $xml=simplexml_load_file($filename);
    $loadedUser = $xml->username;
    $loadedPassword = $xml->password;
    //check given values with loaded values
    if($cryptUser == $loadedUser && $cryptPassword == $loadedPassword) {
        $_SESSION['isLoggedIn'] = 1;
        header("location: landing.php");
    } else {
        $_SESSION['isLoggedIn'] = 2;
        header("location: errors.php");
    }
?>

