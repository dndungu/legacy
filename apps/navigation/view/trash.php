<?php
function trash(){
	header("Content-type: application/json");
	database::trash('navigation', database::sanitize(request::read('navigation')));
	print '{}';
	return true;
}
?>