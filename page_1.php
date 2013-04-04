<?php
	session_start();
	ob_start();
	$root_url = "http://www.pix.cl/pixfactory/";
	//error_reporting(E_ALL);
	//ini_set('display_errors', '1');
	require_once('lib/db_actions.php');
	require_once('lib/tools.php');
	//print_r( $_SESSION[$u->session_user_data] );
	
	if(isset($_POST['textarea_1']))
	{
		/*
			Update table
		*/
		$arr_fields = array(
								"otros_textarea_1" => $_POST['textarea_1'],
								"otros_textarea_2" => $_POST['textarea_2']
							);
		DB_actions::DbUpdate2("questionary_form",$arr_fields,"user_id='".$_SESSION[$u->session_user_data]->id."' ");
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PIX</title>
	<link href="css/questionary_style.css" rel="stylesheet" />
    <link href="css/bootstrap.css" rel="stylesheet" />
	<script src="js/jquery-1.9.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/questionary_tools.js"></script>
    
	<style type="text/css">
    	
		
    </style>
    
    <script type="text/javascript">
    	
    </script>

</head>

<body>

	<div id="page">
    	<div class="left_forms_holder posRel">
        	<div id="header">
            	<div id="logo_holder" class="paddingTop40px">
                	<a href="page_1.php"><img src="css/images/logo.png" width="74" height="45" border="0" /></a>
                </div>
                <div class="clearBoth"></div>
                <div id="menu_holder" class="paddingTop10px paddingLeft100px displayNone">
                	<div class="menu_item">Formato</div>
                	<div class="menu_item">Idea</div>
                	<div class="menu_item">Casting</div>
                	<div class="menu_item">Propuesta de Valor</div>
                	<div class="menu_item">Otros</div>
                    <div class="clearBoth"></div>
                </div>
            </div>
            <div id="main" class="paddingTop100px paddingLeft200px">
            	<div class="crear_btn floatLeft" onclick="javascript:window.location = 'page_2.php'"></div>
                <div class="portafolio_btn floatLeft"></div>
                <div class="clearBoth"></div>
            </div>
        </div>
    	<div class="right_form_holder">
        	<div class="posRel">
            	<div id="show_hide_right_form_btn" onclick="TheRightFormHolder.TRFH.show_hide();"></div>
            </div>
        </div>
        <div class="clearBoth"></div>
    </div>

</body>
</html>