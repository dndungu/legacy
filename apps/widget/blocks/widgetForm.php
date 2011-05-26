<form name="widget" method="post" onsubmit="return false">
	<label class="column grid_10">Section</label>
	<input name="section" type="text" class="column grid_2" />
	<label class="column grid_10">Title</label>
	<input name="title" type="text" class="column grid_2" />
	<label class="column grid_10">Content</label>
	<textarea name="content" rows="10" cols="5" class="column grid_10"></textarea>
	<input name="widget" type="hidden" value="0"/>
	<p class="nomargin grid_10">
		<input name="publish" do="submit" type="button" value="publish" />
		<input name="save" do="submit" type="button" value="save draft" />
		<input name="cancel" type="reset" value="cancel" />
	</p>
</form>