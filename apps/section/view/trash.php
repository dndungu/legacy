<?php
function trash(){
	header("Content-type: application/json");
	database::trash('section', database::sanitize(request::read('section')));
	print '{}';
	return true;
}
?>