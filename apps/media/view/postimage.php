<?php
function postimage($base){
	try {
		$denied = security::enforce("super") ? true : false;
		if($denied){throw new Exception("You are not authorised to perform this action.");}
		$upload = !empty($_FILES) && isset($_FILES['Filedata']) &&  is_uploaded_file($_FILES['Filedata']['tmp_name']) ? $_FILES['Filedata']['tmp_name'] : false;
		if(!$upload){throw new Exception("No upload.");}
		$mime = substr_count(mime_content_type($upload), "image") > 0 ? true : false;
		if(!$mime){throw new Exception("Only images are allowed here not $mime");}
		list($width, $height, $type, $attr) = getimagesize($upload);
		require_once("$base/apps/media/model/imageCreate.php");
		$image = imageCreateRecord($_FILES['Filedata']['name'], $width, $height);
		if(!$image){throw new Exception("System error while creating image database record.");}
		$ID = $image ? $image : false;
		$home = is_null(request::read('folder')) ? "default" : request::read('folder');
		$folder = "$base/html/uploads/".$home."/$ID";
		$folder = str_replace('//','/',$folder); 
		$dir = mkdir($folder) ? true : false;
		if(!$dir){throw new Exception("Could not create $folder");}
		$filename = $_FILES['Filedata']['name'];
		$path = $folder.'/'.$filename;
		$moved = move_uploaded_file($upload, $path) ? true : false;
		if(!$moved){throw new Exception("Could not move uploaded file to $path");}
		require_once("$base/apps/media/model/imageUpdate.php");
		$uri = str_replace($base.'/html','',$path);
		if(!imageUpdate($uri, $ID)){throw new Exception("Could not correctly save the path info in the image database");};
		$aspects = database::read("aspect",0,10);
		if($aspects){
			require_once("$base/apps/media/model/imageAspectCreate.php");
			require_once("$base/apps/media/model/imageResize.php");
			foreach($aspects as $aspect){
				$imgObj = new resize($path);
				$imgObj->resizeImage($aspect['width'], $height['height'], 'auto');
				$newname = $aspect['width'].'x'.$aspect['height'].'_'.$filename;
				$newpath = str_replace($filename, $newname, $path);
				$imgObj->saveImage($newpath, 100);
				imageAspectCreate($ID, $aspect['ID'], str_replace("$base/html", '', $newpath));
			}
		}
		print '{"success": "'.$ID.'"}';
	} catch (Exception $e) {
		header("Content-type: application/json");
		error_log($e->getMessage());
		print '{"error": "'.$e->getMessage().'"}';
	}
	return true;
}
?>