<?php if( !isset($_SESSION) ){ session_start();}?>
<!doctype html>
<html>
    <head>
        <title>Admin Only</title>
        <style>
            h1 {text-align: center; margin-top: 50px; color: black;}
            h2 {text-align: center; padding: 10px; color: black;}
            p {text-align: center; padding: 5px; color: black;}
            a {text-decoration: none; color: black;}
            a:hover {color: black;}
        </style>
    </head>  
    <body>
        <h1>ERROR</h1>
        <h2>Something appears to have gone wrong!</h2>
        <p>Click <a href="index.html">here</a> to go home.</p>
    </body>
</html>