<?php
function trash(){
	header("Content-type: application/json");
	database::trash('certification', database::sanitize(request::read('certification')));
	print '{}';
	return true;
}
?>