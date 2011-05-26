<?php
function restore($base){
	header("Content-type: application/json");
	database::restore('navigation', database::sanitize(request::read('navigation')));
	print '{}';
	return true;
}
?>