<?php
function trash(){
	header("Content-type: application/json");
	database::trash('widget', database::sanitize(request::read('widget')));
	print '{}';
	return true;
}
?>