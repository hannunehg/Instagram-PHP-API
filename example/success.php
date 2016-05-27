<?php

/**
 * Instagram PHP API
 *
 * @link https://github.com/cosenary/Instagram-PHP-API
 * @author Christian Metz
 * @since 01.10.2013
 */
 session_start();
require '../src/Instagram.php';
require '../src/Endpoints.php';
use MetzWeb\Instagram\Instagram;
use MetzWeb\Instagram\Endpoints;

// initialize class
$instagram = new Instagram(array(
    'apiKey' => 'e9ee415633ad4c93a903013337847450',
    'apiSecret' => '4e3118742c3d422392d07bda3318d2a8',
     'apiCallback' => 'http://localhost/instagram/example/success.php' // must point to success.php
    //'apiCallback' => 'https://api.instagram.com/v1/locations/search?client_id=e9ee415633ad4c93a903013337847450&lat=26.8206&lng=30.8025&distance=5000' // must point to success.php
));


// check whether the user has granted access
if (isset($_GET['code'])) {
	
	// receive OAuth code parameter
    $code = $_GET['code'];
    // receive OAuth token object
    $data = $instagram->getOAuthToken($code);
    $username = $data->user->username;
    // store user access token
    $instagram->setAccessToken($data);
	$accessToken = $instagram->getAccessToken();
	if ($accessToken != ''){
		
		$_SESSION['InstagramAccessToken'] = $accessToken;
	}
} else {
    // check whether an error occurred
    if (isset($_GET['error'])) {
        echo 'An error occurred: ' . $_GET['error_description'];
    }
	$instagram->setAccessToken($_SESSION['InstagramAccessToken']); 
}

$endpoints = new Endpoints();
if(isset($_GET['loc_id'])){
	
    $endpoints->set_result($instagram->getLocation($_GET['loc_id']));
	
}

if(isset($_GET['lat']) && isset($_GET['lon']) ){

    $endpoints->set_result($instagram->searchLocation($_GET['lat'], $_GET['lon'], 5000));
}


  // now you have access to all authenticated user methods
    //$result = $instagram->getUserMedia();
	//$result = $instagram->searchMedia(26.8206, 30.8025, 5000);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram - trending</title>
    <link href="https://vjs.zencdn.net/4.2/video-js.css" rel="stylesheet">
    <link href="assets/style.css" rel="stylesheet">
    <script src="https://vjs.zencdn.net/4.2/video.js"></script>
</head>
<body>
<div class="container">
    <header class="clearfix">
        <img src="assets/instagram.png" alt="Instagram logo">

        <h1>Instagram photos </h1>
    </header>
    <div class="main">
	
		<form action="<?php echo $_SERVER['PHP_SELF']?>" method="get">
			<p>
			Lon: <input type="text" name="lon">
			Lat: <input type="text" name="lat">
			<input type="submit">
			<p>
		</form>
		<form action="<?php echo $_SERVER['PHP_SELF']?>" method="get">
			<p>
			Location Id: <input type="text" name="loc_id">
			<input type="submit">
			<p>
		</form>
        <ul class="grid">
            <?php
			if(!isset($endpoints->result) || is_null($endpoints->result)){
				echo "no result";
				exit;
			}
			
			//echo "result:".print_r($result);
			//echo count($data) > 0;
			//echo count($result->$data);
			//print_r($result->data);
			//print_r($result->$data);
			
			if(isset($_GET['loc_id'])){
				
				$endpoints->display_getLocation_results();
			}
			if(isset($_GET['lat']) && isset($_GET['lon']) ){
				$endpoints->display_searchLocation_results();
			}
            ?>
        </ul>
        <!-- GitHub project -->
        <footer>
            <p>created by <a href="https://github.com/cosenary/Instagram-PHP-API">cosenary's Instagram class</a>,
                available on GitHub</p>
            <iframe width="95px" scrolling="0" height="20px" frameborder="0" allowtransparency="true"
                    src="http://ghbtns.com/github-btn.html?user=cosenary&repo=Instagram-PHP-API&type=fork&count=true"></iframe>
        </footer>
    </div>
</div>
<!-- javascript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        // rollover effect
        $('li').hover(
            function () {
                var $media = $(this).find('.media');
                var height = $media.height();
                $media.stop().animate({marginTop: -(height - 82)}, 1000);
            }, function () {
                var $media = $(this).find('.media');
                $media.stop().animate({marginTop: '0px'}, 1000);
            }
        );
    });
</script>
</body>
</html>
