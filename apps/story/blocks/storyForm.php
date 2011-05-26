<form name="story" method="post" action="/story/post" onsubmit="return false">
	<label class="column grid_10">Section</label>
	<p class="column grid_10">
	<?php foreach(database::read("section",0,100) as $section){?>
		<label class="column"><input type="radio" name="section" value="<?php print $section['ID']?>"/> <?php print $section['name']?></label>
	<?php }?>
	</p>
	<label class="column grid_10">Title</label>
	<input name="title" type="text" class="column grid_2" />
	<label class="column grid_10">Teaser</label>
	<input name="teaser" type="text" class="column grid_10" />
	<label class="column grid_10">Content</label>
	<p class="column grid_10">
		<textarea name="content" rows="20" cols="5" class="column grid_10 tinymce"></textarea>
	</p>
	<label class="column grid_10">Tags</label>
	<input name="tags" type="text" class="column grid_10" />
	<input name="story" type="hidden" value="0"/>
	<p class="nomargin grid_10">
		<input name="publish" do="submit" type="button" value="publish" />
		<input name="save" do="submit" type="button" value="save draft" />
		<input name="cancel" type="reset" value="cancel" />
	</p>
</form>