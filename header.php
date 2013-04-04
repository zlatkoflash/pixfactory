<?php
session_start();
ob_start();
//$root_url = "http://www.pix.cl/pixfactory/";
$root_url = "http://www.pix.cl/pixfactory/temp/";
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
require_once('lib/db_actions.php');
require_once('lib/tools.php');
/**/
require_once('lib/codebird.php');
Codebird::setConsumerKey('B7cbYdAw1lUYFsv1J7r6A', 'yIpf9TaeG9Hzdasv8HRNz7pNAcK9J4R7ieFgZMTYbas'); // static, see 'Using multiple Codebird instances'
$cb = Codebird::getInstance();
//twitter oauth login url
$reply = $cb->oauth_requestToken(array(
    //'oauth_callback' => 'http://server-2013/pixfactory/twitter_cl.php'
    'oauth_callback' => $root_url . 'twitter_cl.php'
        ));
// stores it
if (isset($reply->oauth_token)) {
    $cb->setToken($reply->oauth_token, $reply->oauth_token_secret);
    $_SESSION['oauth_token'] = $reply->oauth_token;
    $_SESSION['oauth_token_secret'] = $reply->oauth_token_secret;
}
$auth_url = $cb->oauth_authorize();

?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Pix Factory</title>
        <link rel="stylesheet" type="text/css" href="style.css" media="all" />
        <link rel="shortcut icon" href="favicon.ico" />
        <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="js/validator.js"></script>
        <script type="text/javascript" src="js/tools.js"></script>
        <!--[if lt IE 9]>
        <script type="text/javascript" src="js/html5.js"></script>
        <![endif]-->
        <script type="text/javascript">
            $(document).ready(function() {
                //FB connection
                faceinit();
                $("#fb-reg").click(function(event) {
                    FB.login(function(response) {
                        if (response.authResponse) {
                            fbUserId = response.authResponse.userID;
                            token = response.authResponse.accessToken;
                            //Get all user data
                            FB.api('/me', function(response) {
                                var resp = response;
                                console.log(response);
                                showLoader();
                                $(".main-container").load("registration.php", {fbData: resp, acctoken: token}, function(data) {
                                    hideLoader();
                                });

                            });
                        }
                        else {
                            console.log('User cancelled login or did not fully authorize.');
                        }
                    }, {scope: 'email,user_birthday'});
                    //Display login dialog if use is not logged in to facebook
                    FB.getLoginStatus(function(response) {
                        if (response.authResponse) {
                            fbUserId = response.authResponse.userID;
                            token = response.authResponse.accessToken;
                            //Get all user data
                            FB.api('/me', function(response) {
                                console.log(response);
                                var resp = response;
                                showLoader();
                                $(".main-container").load("registration.php", {fbData: resp, acctoken: token}, function(data) {
                                    hideLoader();
                                });
                            });
                        }
                    }, true);
                });
            });

            function faceinit() {
                window.fbAsyncInit = function() {
                    // init the FB JS SDK
                    FB.init({
                        appId: '101011190000603', // App ID from the App Dashboard
                        channelUrl: 'http://localhost.local', // Channel File for x-domain communication
                        status: true, // check the login status upon init?
                        cookie: true, // set sessions cookies to allow your server to access the session?
                        xfbml: true  // parse XFBML tags on this page?
                    });


                };

                // Load the SDK's source Asynchronously
                // Note that the debug version is being actively developed and might 
                // contain some type checks that are overly strict. 
                // Please report such bugs using the bugs tool.
                (function(d, debug) {
                    var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
                    if (d.getElementById(id)) {
                        return;
                    }
                    js = d.createElement('script');
                    js.id = id;
                    js.async = true;
                    js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";
                    ref.parentNode.insertBefore(js, ref);
                }(document, /*debug*/false));
            }

            var intervalID = null;
            $(document).ready(function(e) {
                //Twitter call
                $("#tw-reg").click(function(event) {
                    event.preventDefault();
                    var twwindow = window.open('<?php echo $auth_url ?>', 'twitter', 'resizable=0,location=no,menubar=no,scrollbars=no,status=no,width=500,height=400,left=' + ($(window).width() / 2 - 250) + ',top=200');
                    intervalID = setInterval("checkTwitterStatus()", 3000);
                });
            });
            function checkTwitterStatus() {
                jQuery.ajax({
                    url: 'lib/tools.php',
                    type: "post",
                    datatype: 'text',
                    data: {checkTwStatus: 1},
                    success: function(data) {
                        if (data == "activated") {
                            clearInterval(intervalID);
                            showLoader();
                            $(".main-container").load("registration.php", function(data) {
                                hideLoader();
                            });
                        }
                    }
                });
            }
        </script>
    </head>

    <body>
        <div id="fb-root"></div>

        <div class="ajax-loader"><img src="images/ajax-loader.gif" width="128" height="128" /></div>
        <div class="main-container">