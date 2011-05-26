<?php
function widgetRead(){
	$result = database::query("SELECT * FROM `widget` WHERE `inTrash` = 'No' ORDER BY `weight`");
	if($result && $result->num_rows){
		while($widget = $result->fetch_assoc()){
			$widgets[] = $widget;
		}
		return $widgets;
	} else {
		return false;
	}
}
?>