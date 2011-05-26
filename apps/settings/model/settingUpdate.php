<?php
function settingUpdate(){
	foreach($_POST['setting'] as $key => $data){
		$value = database::sanitize($data['value']);
		$notes = database::sanitize($data['notes']);
		$result = database::query(request::read("UPDATE `setting` SET `value` = '%s', `notes` = '%s' WHERE `key` = '%s' LIMIT 1", $value, $notes, $key));
	}
	return isset($result) ? true : false;
}
?>