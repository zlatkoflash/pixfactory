<?php include("header.php") ?>

<?php if(!isset($_POST['resetdata'])){ // If user chooses regular registration do not show facebook and twitter data if they are set ?>

<?php
  //FACEBOOK DATA 
  $token = isset($_POST['acctoken']) ? $_POST['acctoken'] : "";
  $facebook_data = isset($_POST['fbData']) ? $_POST['fbData'] : "";
  
  $first_name = isset($facebook_data['first_name']) ? $facebook_data['first_name'] : ""; 
  $last_name = isset($facebook_data['last_name']) ? $facebook_data['last_name'] : ""; 
  $email = isset($facebook_data['email']) ? $facebook_data['email'] : ""; 
  $gender = isset($facebook_data['gender']) ? $facebook_data['gender'] : ""; 
  $birth_date = isset($facebook_data['birthday']) ? $facebook_data['birthday'] : "";
  $picture = isset($facebook_data['username']) ? "https://graph.facebook.com/".$facebook_data['username']."/picture?type=large&access_token=".$token : "";
?>
<?php
 //TWITTER DATA
 if(empty($facebook_data)){
	  $user_data = isset($_SESSION['tw_user_data']) ? $_SESSION['tw_user_data'] : "";
	  if(!empty($user_data)){
		  $full_name = isset($user_data->name) ? $user_data->name : ""; 
		  if(!empty($full_name)){
			  $name_parts = preg_split("/\s{1,}/",$full_name);
		  }
		  $first_name = isset($name_parts[0]) ? $name_parts[0] : ""; 
		  $last_name = isset($name_parts[1]) ? $name_parts[1] : ""; 
		  $picture = isset($user_data->profile_image_url) ? preg_replace("/_normal/","",$user_data->profile_image_url) : "";
	  }
 }
?>

<script type="text/javascript">
$(document).ready(function(e) {
    
	<?php if(!empty($picture)): ?>
	 $("#placeholder").prop('src',"<?php echo $picture ?>");
	<?php endif; ?>
	<?php
	//First name
	if(!empty($first_name)){
		?>$("#first-name").parent().find(".pass-labels").css('display','none');<?php
	}
	//Last name
	if(!empty($last_name)){
		?>$("#last-name").parent().find(".pass-labels").css('display','none');<?php
	}
	//Email
	if(!empty($email)){
		?>$("#email-address").parent().find(".pass-labels").css('display','none');<?php
	}
	//Gender
	if(!empty($gender)){
		?>$("#gender").parent().find(".pass-labels").css('display','none');<?php
	}
	//Birth Date
	if(!empty($birth_date)){
		?>
		  $("#birth-date").parent().find(".pass-labels").css('display','none');
		<?php
	}
	
	?>
	
});
</script>
<?php }//End of regular registration ?>

<div id="content" class="margin-top255">
  <div class="pix-logo"><a href="index.php" id="home-link"><img src="images/logo.png" width="260" height="204" /></a></div>
  <div class="form-wrapper">
     <form action="#" method="post" id="register-form">
       <div class="form-row">
          <div class="pass-labels">Nombres</div>
         <input type="text" id="first-name" value="<?php if(isset($first_name)) echo $first_name ?>" />
       </div>
       <div class="form-row">
          <div class="pass-labels">Apellidos</div>
         <input type="text" id="last-name" value="<?php if(isset($last_name)) echo $last_name ?>" />
       </div>
       <div class="form-row">
          <div class="pass-labels">Correo eletronico</div>
         <input type="text" id="email-address" value="<?php if(isset($email)) echo $email ?>" />
       </div>
       <div class="form-row">
         <div class="pass-labels">Contraseña</div>
         <input type="password" id="password" />
       </div>
       <div class="form-row">
         <div class="pass-labels">Repetir contraseña</div>
         <input type="password" id="confirm-password" />
       </div>
       <div class="form-row">
          <div class="pass-labels">Fecha de nacimiento (Dia/Mes/Ano)</div>
         <input type="text" id="birth-date" value="<?php if(isset($birth_date)) echo $birth_date ?>" />
       </div>
       <div class="form-row">
          <div class="pass-labels">Sexo</div>
         <input type="text" id="gender" value="<?php if(isset($gender)) echo ucfirst($gender); ?>" />
       </div>
       <input type="hidden" name="profile_image" id="profile-image" value="" />
       <input type="submit" id="submit-button" value="Register" />
     </form>
  </div>
  <div class="profile">
    <div class="profile-wrap">
      <div class="loaderp"></div>
      <img src="images/profile_placeholder.jpg" id="placeholder" width="241" height="151" />
    </div>
    
    <a href="#" id="upload-photo">
      <form action="save-file.php" id="upload-form" method="post" enctype="multipart/form-data" target="upload_handler">
        <input type="file" id="profileimg" name="profileimg" />
      </form>
      <img src="images/submit-photo.jpg" width="140" height="27" />
    </a>
    <iframe id="upload_handler" name="upload_handler" src="#" width="0" height="0" frameborder="0"></iframe>
  </div>
</div>
<?php include("footer.php") ?>
  


