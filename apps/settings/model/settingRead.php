<?php
function settingRead(){
	$result = database::query(sprintf("SELECT * FROM `setting`"));
	if($result && $result->num_rows){
		global $settings;
		while($setting = $result->fetch_assoc()){
			$settings[] = $setting;
		}
		return $settings;
	} else {
		return false;
	}
}
?>