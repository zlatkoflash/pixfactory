<?php
	session_start();
	ob_start();
	$root_url = "http://www.pix.cl/pixfactory/";
	//error_reporting(E_ALL);
	//ini_set('display_errors', '1');
	require_once('lib/db_actions.php');
	require_once('lib/tools.php');
	//print_r( $_SESSION[$u->session_user_data] );
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
			font-size:18px;
			color:#a1a1a1;	
		}
		.selection
		{
			width:350px;
			position:relative;
			height:30px;
			line-height:30px;
			margin-top:5px;
		}
		.selection .label{width:140px; background:none; font-size:16px !important; font-weight:normal; color:#a1a1a1; float:left;}
		.selection .select_box
		{
			width:182px;
			padding:0px 10px;
			float:right;
			border-radius:8px;	
			-webkit-border-radius:8px;
			-moz-border-radius:8px;
			-o-border-radius:8px;
			-ms-border-radius:8px;
			background-color: #f5f5f5;
			*background-color: #e6e6e6;
			background-image: -moz-linear-gradient(top, #ffffff, #e6e6e6);
			background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#e6e6e6));
			background-image: -webkit-linear-gradient(top, #ffffff, #e6e6e6);
			background-image: -o-linear-gradient(top, #ffffff, #e6e6e6);
			background-image: linear-gradient(to bottom, #ffffff, #e6e6e6);
			background-repeat: repeat-x;
			border-bottom:2px solid #CCC;
			border-left:1px solid #CCC;
			border-top:1px solid #FFF;
			height:28px;
			line-height:28px;
			font-size:12px;
			font-weight:bold;
			color:#333333;
			cursor:pointer;
		}
		.btn-group{top:0px; margin-top:-17px;}
		.dropdown-menu{min-width:200px !important;}
		.selected{font-size:12px !important; font-weight:bold; color:#333333; text-align:left; padding-left:10px; width:175px;}
		
		.width150px{width:150px;}
		.width175px{width:175px;}
		.width600px{width:600px;}
		.width700px{width:700px;}
		.width725px{width:725px;}
		
    </style>
    
    <script type="text/javascript">
	
		function TheForm()
		{
			this.insert_values = function()
			{
				$("#formato").val( $("#formato_select").html() );
				$("#duracion").val( $("#duracion_select").html() );
				$("#capitulos").val( $("#capitulos_select").html() );
				$("#genero").val( $("#genero_select").html() );
				$("#publico_objetivo").val( $("#publico_select").html() );
				$("#censura").val( $("#censura_select").html() );
			}
			this.submit_me = function()
			{
				this.insert_values();
				//alert($("#formato").val()+" "+$("#duracion").val()+" "+$("#capitulos").val()+" "+$("#genero").val()+" "+$("#publico_objetivo").val()+" "+$("#censura").val());
				$("#myForm").submit();
			}
		}
		TheForm.TF = new TheForm();
    	
		$(document).ready(function(e) 
		{
            $(".dropdown-menu li a").each(function(index, element) 
			{
                $(this).click(function(e) 
				{
                    var value = $(this).text();
					$(this).parent("li").parent(".dropdown-menu").parent(".btn-group").children(".selected").html(value);
                });
            });
        });
		
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
                	<div class="menu_item menu_item_active">Formato</div>
                	<div class="menu_item">Idea</div>
                	<div class="menu_item">Casting</div>
                	<div class="menu_item">Propuesta de Valor</div>
                	<div class="menu_item">Otros</div>
                    <div class="clearBoth"></div>
                </div>
            </div>
            <div id="main" class="paddingTop100px">
            	<form action="page_3.php" method="post" enctype="multipart/form-data" name="myForm" id="myForm">
                	<input type="hidden" name="formato" id="formato" value="" />
                    <input type="hidden" name="duracion" id="duracion" value="" />
                    <input type="hidden" name="capitulos" id="capitulos" value="" />
                    <input type="hidden" name="genero" id="genero" value="" />
                    <input type="hidden" name="publico_objetivo" id="publico_objetivo" value="" />
                    <input type="hidden" name="censura" id="censura" value="" />
                </form>
            	<div class="paddingLeft200px">
                	<div class="paddingLeft15px">
                    	Completa los siguientes Campos.
                    </div>
                	<div class="paddingTop10px">
                    	<div class="paddingLeft10px">
                        	<div class="selection">
                            	<div class="label">Formato</div>
                                <div class="btn-group">
                                    <button id="formato_select" class="btn selected">selecionar</button>
                                    <button class="btn dropdown-toggle" data-toggle="dropdown">
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">option 1</a></li>
                                        <li><a href="#">option 2</a></li>
                                        <li><a href="#">option 3</a></li>
                                    </ul>
                                </div>
                                <div class="clearBoth"></div>
                            </div>
                        	<div class="selection">
                            	<div class="label">Duracion</div>
                                <div class="btn-group">
                                    <button id="duracion_select" class="btn selected">selecionar</button>
                                    <button class="btn dropdown-toggle" data-toggle="dropdown">
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">option 1</a></li>
                                        <li><a href="#">option 2</a></li>
                                        <li><a href="#">option 3</a></li>
                                    </ul>
                                </div>
                                <div class="clearBoth"></div>
                            </div>
                        	<div class="selection">
                            	<div class="label">Capitulos</div>
                                <div class="btn-group">
                                    <button id="capitulos_select" class="btn selected">selecionar</button>
                                    <button class="btn dropdown-toggle" data-toggle="dropdown">
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">option 1</a></li>
                                        <li><a href="#">option 2</a></li>
                                        <li><a href="#">option 3</a></li>
                                    </ul>
                                </div>
                                <div class="clearBoth"></div>
                            </div>
                        	<div class="selection">
                            	<div class="label">Genero</div>
                                <div class="btn-group">
                                    <button id="genero_select" class="btn selected">selecionar</button>
                                    <button class="btn dropdown-toggle" data-toggle="dropdown">
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">option 1</a></li>
                                        <li><a href="#">option 2</a></li>
                                        <li><a href="#">option 3</a></li>
                                    </ul>
                                </div>
                                <div class="clearBoth"></div>
                            </div>
                        	<div class="selection">
                            	<div class="label">Publico Objetivo</div>
                                <div class="btn-group">
                                    <button id="publico_select" class="btn selected">selecionar</button>
                                    <button class="btn dropdown-toggle" data-toggle="dropdown">
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">option 1</a></li>
                                        <li><a href="#">option 2</a></li>
                                        <li><a href="#">option 3</a></li>
                                    </ul>
                                </div>
                                <div class="clearBoth"></div>
                            </div>
                        	<div class="selection">
                            	<div class="label">Censura</div>
                                <div class="btn-group">
                                    <button id="censura_select" class="btn selected">selecionar</button>
                                    <button class="btn dropdown-toggle" data-toggle="dropdown">
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">option 1</a></li>
                                        <li><a href="#">option 2</a></li>
                                        <li><a href="#">option 3</a></li>
                                    </ul>
                                </div>
                                <div class="clearBoth"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="paddingTop30px width725px">
                    <div class="submit_btn floatRight" onclick="TheForm.TF.submit_me();">Siguiente</div>
                </div>
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