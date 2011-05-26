<?php
function get(){
	if(security::enforce('normal')){
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
		$recruitment = $root->appendChild($doc->createElement("recruitment"));
		$certifications = database::read("certification", 0, 10);
		if($certifications){
			foreach($certifications as $certification){
				$element = $recruitment->appendChild($doc->createElement("certification"));
				$element->appendChild($doc->createElement("ID", $certification["ID"]));
				$element->appendChild($doc->createElement("name", $certification["name"]));
			}
		}
		require_once("$base/apps/navigation/model/navigationRead.php");
		$navigation = $root->appendChild($doc->createElement("navigation"));
		$primary = $navigation->appendChild($doc->createElement("primary"));
		$primary->appendChild(new DOMText(navigationRead()));
		$technologies = database::read("technology", 0, 999);
		if($technologies){
			$element = $root->appendChild($doc->createElement("technologies"));
			foreach($technologies as $technology){
				$tech = $element->appendChild($doc->createElement("technology"));
				$tech->appendChild($doc->createElement("ID", $technology['ID']));
				$tech->appendChild($doc->createElement("fullname", $technology['fullname']));
			}
		}
		$user = database::read("user", session::read("user"));
		if($user){
			$element = $root->appendChild($doc->createElement("user"));
			foreach($user as $column => $value){
				$value = $column == "DOB" ? date("m/d/o", $value) : $value;
				$element->appendChild($doc->createElement($column))->appendChild(new DOMText($value));
			}
		}
		require_once("$base/apps/education/model/educationRead.php");
		$educations = educationRead(session::read('user'));
		if($educations){
			foreach($educations as $education){
				$element = $root->appendChild($doc->createElement("education"));
				foreach($education as $column => $value){
					$value = ($column == 'start' or $column == 'completion') ? date("m/d/o", $value) : $value;
					$element->appendChild($doc->createElement($column))->appendChild(new DOMText($value));
				}
			}
		}
		require_once("$base/apps/experience/model/experienceRead.php");
		$experiences = experienceRead(session::read('user'));
		if($experiences){
			require_once("$base/apps/experience/model/experienceTechnologyRead.php");
			foreach($experiences as $experience){
				$element = $root->appendChild($doc->createElement("experience"));
				$technologies = experienceTechnologyRead($experience['ID']);
				$techs = array();
				foreach($technologies as $tech){
					$techs[] = $tech['fullname'];
				}
				$technologies = implode(", ", $techs ? $techs : array());
				$element->appendChild($doc->createElement("technologies"))->appendChild(new DOMText($technologies));
				foreach($experience as $column => $value){
					$value = ($column == 'start' or $column == 'completion') ? date("m/d/o", $value) : $value;
					$element->appendChild($doc->createElement($column))->appendChild(new DOMText($value));
				}
			}			
		}
		$xsl = new DomDocument('1.0');
		$theme = $site_settings['theme'];
		$xsl->load("themes/$theme/recruitment.xsl");
		$xp = new XsltProcessor();
		$xp->importStylesheet($xsl);
		print $xp->transformToXML($doc);
		return true;
	} else {
		session::write('redirect', '/recruitment');
		header('Location: /user/login');
		exit;
	}
}
?>