<?php
function signout($base){
	session::destroy();
	header("Location: /");
	exit;
}
?>
