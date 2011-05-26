<?php
function emailExists(){
	$result = database::query(sprintf("SELECT `ID` FROM `user` WHERE `email` = '%s' LIMIT 1", database::sanitize(request::read("email"))));
	return $result && $result->num_rows ? true : false;	
}
?>