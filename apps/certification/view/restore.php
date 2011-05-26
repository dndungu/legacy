<?php
function restore($base){
	header("Content-type: application/json");
	database::restore('certification', database::sanitize(request::read('certification')));
	print '{}';
	return true;
}
?>