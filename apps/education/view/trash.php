<?php
function trash(){
	header("Content-type: application/json");
	database::trash('education', database::sanitize(request::read('education')));
	print '{}';
	return true;
}
?>