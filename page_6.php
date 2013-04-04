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
								"propuesta_textarea_1" => $_POST['textarea_1'],
								"propuesta_textarea_2" => $_POST['textarea_2'],
								"propuesta_textarea_3" => $_POST['textarea_3']
							);
		DB_actions::DbUpdate2("questionary_form",$arr_fields,"user_id='".$_SESSION[$u->session_user_data]->id."' ");
	}
	else
	{
		/*
			Return to Start page??
		*/
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
    	
		#main
		{
			font-size:16px;
			color:#a1a1a1;	
		}
		
    </style>
    
    <script type="text/javascript">
    	
		function TheForm()
		{
			this.insert_values = function()
			{
			}
			this.submit_me = function()
			{
				//alert($("#textarea_1").val()+"\n\n"+$("#textarea_2").val()+"\n\n"+$("#textarea_3").val());
				$("#myForm").submit();
			}
		}
		TheForm.TF = new TheForm();
		
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
                <div id="menu_holder" class="paddingTop10px paddingLeft100px">
                	<div class="menu_item">Formato</div>
                	<div class="menu_item">Idea</div>
                	<div class="menu_item">Casting</div>
                	<div class="menu_item">Propuesta de Valor</div>
                	<div class="menu_item menu_item_active">Otros</div>
                    <div class="clearBoth"></div>
                </div>
            </div>
            <div id="main" class="">
            	<form action="page_1.php" method="post" enctype="multipart/form-data" name="myForm" id="myForm" class="margin0">
					<div class="paddingLeft10px paddingTop10px">
                    	<div class="selection">
                        	Referencias de otros programas
                            <br/>
                            <textarea name="textarea_1" id="textarea_1" class="textarea" maxlength="1000"></textarea>
                        </div>
                        <div class="selection">
                        	Observaciones 
                            <br/>
                            <textarea name="textarea_2" id="textarea_2" class="textarea" maxlength="1000"></textarea>
                        </div>
                        <div class="width725px">
                        	<div class="submit_btn floatRight" onclick="TheForm.TF.submit_me();">Terminar</div>
                        </div>
                    </div>
                </form>
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