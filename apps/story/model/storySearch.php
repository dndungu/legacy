<?php
function storySearch($limit=1){
	$result = database::query(sprintf("SELECT * FROM `story` WHERE MATCH(`teaser`, `title`, `content`, `description`) AGAINST('%s') LIMIT %d", database::sanitize(request::read("keywords")), $limit));
	if($result && result->num_rows){
		while($story = $result->fetch_assoc()){
			$stories[] = $story;
		}
		return $stories;
	} else {
		return false;
	}
}
?>