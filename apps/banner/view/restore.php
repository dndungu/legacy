<?php
function restore($base){
	header("Content-type: application/json");
	database::restore('banner', database::sanitize(request::read('banner')));
	print '{}';
	return true;
}
?>