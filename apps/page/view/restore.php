<?php
function restore($base){
	header("Content-type: application/json");
	database::restore('page', database::sanitize(request::read('page')));
	print '{}';
	return true;
}
?>