<?php
function tokenRead(){
	$result = database::query(sprintf("SELECT `ID` FROM `user` WHERE `token` = '%s' LIMIT 1", database::sanitize(request::read('token'))));
	return $result ? $result->num_rows : false;
}
?>