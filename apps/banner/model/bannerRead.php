<?php
function bannerRead($limit=0, $expireTime){
	$result = database::query(sprintf("SELECT `story`, `heading`, `path`, `uri`, `story`.`title`, `teaser` FROM `banner` LEFT JOIN `image` ON (`banner`.`image` = `image`.`ID`) LEFT JOIN `story` ON (`banner`.`story` = `story`.`ID`) WHERE `banner`.`inTrash` = 'No' ORDER BY `banner`.`creationTime` DESC LIMIT %d", $limit));
	if($result && $result->num_rows){
		while($banner = $result->fetch_assoc()){
			$banners[] = $banner;
		}
		return $banners;
	} else {
		return array();
	}
}
?>