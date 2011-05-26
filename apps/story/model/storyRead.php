<?php
function storyRead($section=0, $limit=1){
	$result = database::query(sprintf("SELECT * FROM `story` WHERE `section` = %d ORDER BY `creationTime` DESC LIMIT %d", $section, $limit));
	if($result && $result->num_rows){
		while($story = $result->fetch_assoc()){
			$stories[] = $story;
		}
		return $stories;
	} else {
		return false;
	}
}
?>