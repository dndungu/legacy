<?php
function isEmail($input){
	return filter_var(filter_var($input, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
}
?>
 