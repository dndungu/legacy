<?php
function restore($base){
	header("Content-type: application/json");
	database::restore('technology', database::sanitize(request::read('technology')));
	print '{}';
	return true;
}
?>