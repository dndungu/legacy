<?php
function get(){
	$doc = new DomDocument("1.0", "utf-8");
	$doc->formatOutput = true;
	$root = $doc->appendChild($doc->createElement('root'));
	global $site_settings;
	$company = $root->appendChild($doc->createElement("company", $site_settings["company"]));
	$title = $root->appendChild($doc->createElement("title", $site_settings["title"]));
	$base = str_replace('/html', '', getcwd());
	require_once("$base/apps/widget/model/widgetRead.php");
	$widgets = widgetRead();
	if($widgets){
		$sections = $root->appendChild($doc->createElement("sections"));
		foreach($widgets as $widget){
			$section = $widget['section'];
			$$section = $sections->appendChild($doc->createElement($widget['section']));
			$$section->appendChild($doc->createElement("title", $widget['title']));
			$$section->appendChild($doc->createElement("content"))->appendChild(new DOMText(nl2br($widget['content'])));
		}
	}
	require_once("$base/apps/navigation/model/navigationRead.php");
	$navigation = $root->appendChild($doc->createElement("navigation"));
	$primary = $navigation->appendChild($doc->createElement("primary"));
	$primary->appendChild(new DOMText(navigationRead()));
	require_once("$base/apps/banner/model/bannerRead.php");
	$banner = bannerRead(1, time());
	if($banner){
		$banner_element = $root->appendChild($doc->createElement("banner"));
		foreach($banner[0] as $key => $value){
			$banner_element->appendChild($doc->createElement($key))->appendChild(new DOMText($value));
		}
	}
	require_once("$base/apps/story/model/storyRead.php");
	$openings = storyRead(2, 4);
	if($openings){
		foreach($openings as $opening){
			$element = $root->appendChild($doc->createElement("section"));
			$element->appendChild($doc->createElement("title", $opening['title']));
			$element->appendChild($doc->createElement("uri", "/story/".$opening['ID']));
			$sections->appendChild($doc->createElement("openings"))->appendChild($element);
		}
	}
	$projects = storyRead(3, 4);
	if($projects){
		foreach($projects as $project){
			$element = $root->appendChild($doc->createElement("section"));
			$element->appendChild($doc->createElement("title", $project['title']));
			$element->appendChild($doc->createElement("uri", "/story/".$project['ID']));
			$sections->appendChild($doc->createElement("projects"))->appendChild($element);
		}
	}
	$updates = storyRead(4, 4);
	if($updates){
		foreach($updates as $update){
			$element = $root->appendChild($doc->createElement("section"));
			$element->appendChild($doc->createElement("title", $update['title']));
			$element->appendChild($doc->createElement("uri", "/story/".$update['ID']));
			$sections->appendChild($doc->createElement("updates"))->appendChild($element);
		}
	}
	$xsl = new DomDocument('1.0');
	$theme = $site_settings['theme'];
	$xsl->load("themes/$theme/home.xsl");
	$xp = new XsltProcessor();
	$xp->importStylesheet($xsl);
	print $xp->transformToXML($doc);
	return true;
}
?>