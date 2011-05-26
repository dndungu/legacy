<?php
function restore($base){
	header("Content-type: application/json");
	database::restore('section', database::sanitize(request::read('section')));
	print '{}';
	return true;
}
?>