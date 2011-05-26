<?php
function trash(){
	header("Content-type: application/json");
	database::trash('technology', database::sanitize(request::read('technology')));
	print '{}';
	return true;
}
?>