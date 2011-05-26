<form name="technology" method="post" onsubmit="return false">
	<label class="column grid_10">Acronym</label>
	<input name="acronym" type="text" class="column grid_2" />
	<label class="column grid_10">Fullname</label>
	<input name="fullname" type="text" class="column grid_2" />
	<label class="column grid_10">Description</label>
	<textarea name="notes" rows="10" cols="5" class="column grid_10"></textarea>
	<input name="technology" type="hidden" value="0"/>
	<p class="nomargin grid_10">
		<input name="save" do="submit" type="button" value="save draft" />
		<input name="cancel" type="reset" value="cancel" />
	</p>
</form>