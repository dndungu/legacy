<?php
function restore($base){
	header("Content-type: application/json");
	database::restore('widget', database::sanitize(request::read('widget')));
	print '{}';
	return true;
}
?>