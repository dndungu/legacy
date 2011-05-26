<?php
function forgot($base){
	header("Content-type: text/json");
	require_once("$base/apps/user/model/isEmail.php");
	$email = request::read('email');
	if(isEmail($email)){
		require_once("$base/apps/user/model/userTokenCreate.php");
		$token = createToken();
		if(userTokenCreate($token)){
			require_once("$base/apps/user/model/userEmail.php");
			if(userEmail($email, "Password Recovery Token", "To change your password, copy and paste the password recovery token display below to the provided textbox.	\r \r ------------------------------------------------------------------------------------------------------------------------ \r $token \r ------------------------------------------------------------------------------------------------------------------------ \r	\r With thanks,	\r Technical support team.")){
				print '{"open": "change", "info": "A password recovery token has been sent to '.$email.'. Please provide it to change your password."}';
			} else {
				print '{"error": "Problems sending email. Please contact support."}';
			}
		} else {
			print '{"error": "Yikes"}';
		}
	} else {
		print '{"error": "Please enter a valid email."}';
	}
	return true;
}
?>