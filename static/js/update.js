$("#identity").keyup(function() {
	
		var email = $("#identity").val();
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		if(re.test(email) == false){
			$("#identity").css("border","1px solid #E63742");
			$("#email_error").css("display","initial");
			$("#email_success").css("display","none");
		}else{
			$("#identity").css("border","1px solid #1EC857");
			$("#email_error").css("display","none");
			$("#email_success").css("display","initial");
		}

	});

$("#register_form").click(function ( event ) {
		$(".loader_block").css("display","initial");
	});

$(".loader_block").click(function(){
		$(".loader_block").css("display","none");
	});


/*$( ".blue_btn" ).click(function ( event ) {
event.preventDefault();
});
*/


$("#password").keyup(function() {
		var myInput = document.getElementById("password");
		var mystring = $("#password").val();
		/* var lowerCaseLetters = /[a-z]/g;
		var upperCaseLetters = /[A-Z]/g;
		var numbers = /[0-9]/g;*/
    
    
    
		if(myInput.value.length < 8 ){
			$("form.alert-danger").css("display","block");
			$("#password").css("border","1px solid #E63742");
			$("#pwd_error").css("display","initial");
			$("#pwd_success").css("display","none"); 
		}else{
			$("form.alert-danger").css("display","none");
			$("#password").css("border","1px solid #1EC857");
			$("#pwd_error").css("display","none");
			$("#pwd_success").css("display","initial"); 
		}
    

	});

$("#password_confirm").keyup(function() {
		var mystring = $("#password").val();
		var pwd_confirm = $("#password_confirm").val();
    
		if(mystring == pwd_confirm){
			$("#password_confirm").css("border","1px solid #1EC857");
			$("#pwd_success_conf").css("display","initial");
			$("#pwd_error_conf").css("display","none"); 
		}else{
			$("#password_confirm").css("border","1px solid #E63742");
			$("#pwd_error_conf").css("display","initial"); 
			$("#pwd_success_conf").css("display","none");
		}
	});

//alert(12312312312)