<form name="page" method="post" onsubmit="return false">
	<label class="column grid_10">Title</label>
	<input name="title" type="text" class="column grid_2" />
	<label class="column grid_10">Content</label>
	<p class="column grid_10">
		<textarea name="content" class="grid_10 tinymce" rows="20" cols="5"></textarea>
	</p>
	<label class="column grid_10">Keywords</label>
	<input name="tags" type="text" class="column grid_10" />
	<input name="page" type="hidden" value="0"/>
	<label class="column grid_10">Meta description</label>
	<input name="description" type="text" class="column grid_10" />	
	<p class="nomargin grid_10">
		<input name="publish" do="submit" type="button" value="publish" />
		<input name="save" do="submit" type="button" value="save draft" />
		<input name="cancel" type="reset" value="cancel" />
	</p>
</form>