<?php
function trash(){
	header("Content-type: application/json");
	database::trash('aspect', database::sanitize(request::read('aspect')));
	print '{}';
	return true;
}
?>