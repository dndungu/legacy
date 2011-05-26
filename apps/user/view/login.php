<?php
function login($base){
	$doc = new DomDocument("1.0", "utf-8");
	$doc->formatOutput = true;
	$root = $doc->appendChild($doc->createElement('root'));
	global $site_settings;
	$company = $root->appendChild($doc->createElement("company", $site_settings["company"]));
	$title = $root->appendChild($doc->createElement("title", $site_settings["title"]));
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
	$xsl = new DomDocument('1.0');
	$theme = $site_settings['theme'];
	$xsl->load("themes/$theme/login.xsl");
	$xp = new XsltProcessor();
	$xp->importStylesheet($xsl);
	print $xp->transformToXML($doc);
	return true;
}
?>