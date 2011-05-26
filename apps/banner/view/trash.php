<?php
function trash(){
	header("Content-type: application/json");
	database::trash('banner', database::sanitize(request::read('banner')));
	print '{}';
	return true;
}
?>