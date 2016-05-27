<?php

require '../src/Instagram.php';

use MetzWeb\Instagram\Instagram;

// initialize class
$instagram = new Instagram(array(
    'apiKey' => 'e9ee415633ad4c93a903013337847450',
    'apiSecret' => '4e3118742c3d422392d07bda3318d2a8',
    'apiCallback' => 'http://localhost/instagram/example/success.php' // must point to success.php
    //'apiCallback' => 'https://api.instagram.com/v1/locations/search?client_id=e9ee415633ad4c93a903013337847450&lat=26.8206&lng=30.8025&distance=5000' // must point to success.php
));

// create login URL
$loginUrl = $instagram->getLoginUrl();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram - OAuth Login</title>
    <link rel="stylesheet" type="text/css" href="assets/style.css">
    <style>
        .login {
            display: block;
            font-size: 20px;
            font-weight: bold;
            margin-top: 50px;
        }
    </style>
</head>
<body>
<div class="container">
    <header class="clearfix">
        <h1>Instagram <span>display your photo stream</span></h1>
    </header>
    <div class="main">
        <ul class="grid">
            <li><img src="assets/instagram-big.png" alt="Instagram logo"></li>
            <li>
                <a class="login" href="<?php echo $loginUrl ?>">» Login with Instagram</a>
                <h4>Use your Instagram account to login.</h4>
            </li>
        </ul>
        <!-- GitHub project -->
        <footer>
            <p>created by <a href="https://github.com/cosenary/Instagram-PHP-API">cosenary's Instagram class</a>,
                available on GitHub</p>
        </footer>
    </div>
</div>
</body>
</html>
