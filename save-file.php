<?php
 include_once("lib/uploader.php");
 $root_url = "http://www.pix.cl/pixfactory/";
 $u = new Uploader();
 $u->max_file_size = 10000000;
 $u->allowed_extensions = array('jpg','png','gif','bmp');
 $u->temp_path = "temp";
 $u->upload_path = "profile-images";
 if(isset($_FILES['profileimg'])){
	 
	 $uploaded_fle_name = $u->uploadFile("profileimg");
	 $image_src =  $root_url."profile-images/".$uploaded_fle_name;
	 //$image_src =  "http://www.takeatool.com/work/pixfactory/profile-images/".$uploaded_fle_name;
	 if($uploaded_fle_name != ""){
		 sleep(1);
	     ?><script type="text/javascript">window.top.window.uploadFinished("<?php echo $image_src; ?>");</script><?php 
	 }
	 else{
		 ?><script type="text/javascript">window.top.window.uploadFinished("0");</script><?php 
	 }
 }
?>