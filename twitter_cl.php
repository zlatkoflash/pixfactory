<?php
session_start();
ob_start();
$root_url = "http://www.pix.cl/pixfactory/";
require_once('lib/codebird.php');
Codebird::setConsumerKey('B7cbYdAw1lUYFsv1J7r6A', 'yIpf9TaeG9Hzdasv8HRNz7pNAcK9J4R7ieFgZMTYbas'); // static, see 'Using multiple Codebird instances'


$cb = Codebird::getInstance();


 
if (! isset($_GET['oauth_verifier'])) {
    // gets a request token
    $reply = $cb->oauth_requestToken(array(
		//'oauth_callback' => 'http://server-2013/pixfactory/twitter_cl.php';
		'oauth_callback' => $root_url.'twitter_cl.php'
		
    ));

    // stores it
	if(isset($reply->oauth_token)){
		 $cb->setToken($reply->oauth_token, $reply->oauth_token_secret);
         $_SESSION['oauth_token'] = $reply->oauth_token;
         $_SESSION['oauth_token_secret'] = $reply->oauth_token_secret;
	}
   

    // gets the authorize screen URL
    $auth_url = $cb->oauth_authorize();
    ?><script type="text/javascript">window.location="<?php echo $auth_url; ?>"</script><?php 
    die();

} else {
    // gets the access token
    $cb->setToken($_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
    $reply = $cb->oauth_accessToken(array(
        'oauth_verifier' => $_GET['oauth_verifier']
    ));
	
	if(isset($reply->oauth_token)){
		$_SESSION['oauth_token'] = $reply->oauth_token;
	}
	if(isset($reply->oauth_token_secret)){
		$_SESSION['oauth_token_secret'] = $reply->oauth_token_secret;
	}
	
	
	//$reply1 = $cb->statuses_update('status=Whohoo, I just tweeted!');
	$cb->setToken($_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
    $userData = $cb->account_verifyCredentials();
    $_SESSION['tw_user_data'] = $userData;
	$_SESSION['tw_activated'] = 1;
	?><script type="text/javascript">setTimeout("self.close();",1000) </script><?php
}

?>