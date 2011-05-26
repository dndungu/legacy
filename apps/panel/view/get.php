<?php
function get($base){
	if(security::enforce("super")){
		$doc = new DomDocument("1.0", "utf-8");
		$doc->formatOutput = true;
		$root = $doc->appendChild($doc->createElement('root'));
		global $site_settings;
		$company = $root->appendChild($doc->createElement("company", $site_settings["company"]));
		$title = $root->appendChild($doc->createElement("title", $site_settings["title"]));
		$date = $root->appendChild($doc->createElement("copyright"))->appendChild(new DOMText('&copy; '.date("o").' '.$site_settings["company"]));		
		$xsl = new DomDocument('1.0');
		$theme = $site_settings['theme'];
		$xsl->load("themes/$theme/panel.xsl");
		$xp = new XsltProcessor();
		$xp->importStylesheet($xsl);
		print $xp->transformToXML($doc);
		return true;
	} else {
		session::write('redirect', '/panel');
		header("Location: /user/login");
		exit;
	}
}
?>
