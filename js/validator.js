// JavaScript Document
var validator = {
  //Add required filed
  markRequiredField : function(){
	  //Append required image to all label elements with class required
	  var imgRequired = $("<img>").attr({'src':'images/required_img.jpg','width':'10px','height':'11px'}).css('padding','5px 0 0 0');
	  $(".required").append(imgRequired);
  },
  //Errors
  errors : new Array(),
  displayErrors : function(callback){
		$(".error-label").remove();
		if(validator.errors.length > 0){
			for(i=0; i< validator.errors.length; i++){
				
				$("#" + validator.errors[i].ID).parent().prepend($("<p title='"+validator.errors[i].errorMessage+"'>").addClass('error-label').html(validator.errors[i].errorMessage));
			}
			//alert(validator.errors[0].ID);
			var offsertTopPos = $("#" + validator.errors[0].ID).offset().top - $("#" + validator.errors[0].ID).height();
			$('html, body').animate({scrollTop: offsertTopPos}, 'slow');
		}
		else{
			//Process request
			$('.aloader').show();
			callback();
		}
  },
  //Required field
  requiredField : function(elementID){
	  if($("#"+elementID).val() == ""){
		  validator.errors.push({ID : elementID, errorMessage : "This field is required"});
	  }
  },
  //Required radio
  requiredRadio : function(radioName,radioID){
	    if(!$("input[name='"+radioName+"']:checked").val()){
			validator.errors.push({ID : radioID, errorMessage : "This field is required"});
		}
	
  },
  //Birth Date
  validateBirthDate : function(elementID){
		var message = "According to your date of birth, you are under 10 years old. Please review your date of birth.";
		var dateNow = new Date();
		var yearNow = dateNow.getFullYear();
		
		var selectedDate = new Date($("#"+elementID).val());
		var birthYear = selectedDate.getFullYear();
		var yearDiff = yearNow - birthYear;
		//////////////////////////SUBMIT EVENT
		if(yearDiff < 10 || $("#"+elementID).val() == "") validator.errors.push({ID : elementID, errorMessage : message});
  },
  //number
  validateNumber : function(elementID){
	 if(isNaN($("#"+elementID).val())){
			validator.errors.push({ID : radioID, errorMessage : "Please enter valid number"});
	 } 
  },
  //mobile number
  validateMobileNumber : function(elementID){
	  var message = "Please enter a valid mobile number or landline number including the area code";
	 if(isNaN(parseInt($("#"+elementID).val())) || $("#"+elementID).val().length != 10){	
		validator.errors.push({ID : elementID, errorMessage : message});  
	 } 
  },
  //Email
  validateEmail : function(elementID){
	  var message = "Email field is required";
	  var pattern = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	  if(!pattern.test($("#"+elementID).val())) validator.errors.push({ID : elementID, errorMessage : message});  
  },
  //Address
  validateAddress : function(elementID){
	  var message = "Please enter either your physical business address or your home address. Not a PO Box";
	  var spacePattern = /^\s*$/; 
	  if(spacePattern.test($("#"+elementID).val())) validator.errors.push({ID : elementID, errorMessage : message});
  },
  //Validate checkbox
  validateCheckbox : function(elementID){
	  if(!$("#"+elementID).is(":checked")){
		  validator.errors.push({ID : elementID, errorMessage : "This field is required"});
	  }
  },
  //Validate number of characters
  validateLength : function(elementID, stringLength){
	  var message = "The information you provided about your BUSINESS ACTIVITY and INDUSTRY is a too short. Please provide a more detailed answer.";
	 
	  if($("#"+elementID).val().length < stringLength){
		  validator.errors.push({ID : elementID, errorMessage : message});
	  }
  },
  //Validate minimum number of characters
  validateMinLength : function(elementID, minLength){
	  var message = "Your message is to short. Please enter at least " + minLength + " characters";
	  if($("#"+elementID).val().length < minLength){
		  validator.errors.push({ID : elementID, errorMessage : message});
	  }
  },
   //Validate maximum number of characters
  validateMaxLength : function(elementID, maxLength){
	  var message = "Your message is to long. Please enter maximum " + maxLength + " characters";
	  if($("#"+elementID).val().length > maxLength){
		  validator.errors.push({ID : elementID, errorMessage : message});
	  }
  },
  //Validate date
  validateDate : function(elementID){
	  var message = "This filed is required.";
	  var pattern = /\d{2}\/\d{2}\/\d{4}/;
	  if(!pattern.test($("#"+elementID).val()))  validator.errors.push({ID : elementID, errorMessage : message});
  }
}