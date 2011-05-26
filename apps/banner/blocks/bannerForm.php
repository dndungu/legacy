<form name="banner" method="post" onsubmit="return false">
	<label class="column grid_10">Article</label>
	<select name="story" class="column grid_2">
		<?php foreach(database::read("story",0,100) as $story){?>
		<option value="<?php print $story['ID']?>"><?php print $story['title']?></option>
		<?php }?>
	</select>
	<label class="column grid_10">Image</label>
	<select name="image" class="column grid_2">
		<?php
		$result = database::query(sprintf("SELECT `image`, `title` FROM `image_aspect` LEFT JOIN `image` ON (`image_aspect`.`image` = `image`.`ID`) WHERE `aspect` = 4"));
		if($result && $result->num_rows){
			while($image = $result->fetch_assoc()){
				$images[] = $image;
			}
		?>
		<?php foreach($images as $image){?>
		<option value="<?php print $image['image']?>"><?php print $image['title']?></option>
		<?php }}?>
	</select>	
	<label class="column grid_10">Heading</label>
	<input name="heading" type="text" class="column grid_10" />
	<input name="banner" type="hidden" value="0"/>
	<p class="nomargin grid_10">
		<input name="publish" do="submit" type="button" value="publish" />
		<input name="save" do="submit" type="button" value="save draft" />
		<input name="cancel" type="reset" value="cancel" />
	</p>
</form>