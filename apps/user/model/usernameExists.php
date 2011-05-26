<?php
function usernameExists(){
	$result = database::query(sprintf("SELECT `ID` FROM `user` WHERE `username` = '%s' LIMIT 1", database::sanitize(request::read("username"))));
	return $result && $result->num_rows ? true : false;	
}
?>