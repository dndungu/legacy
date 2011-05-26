<?php
function restore($base){
	header("Content-type: application/json");
	database::restore('image', database::sanitize(request::read('image')));
	print '{}';
	return true;
}
?>