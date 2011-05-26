<?php
function trash(){
	header("Content-type: application/json");
	database::trash('image', database::sanitize(request::read('image')));
	print '{}';
	return true;
}
?>