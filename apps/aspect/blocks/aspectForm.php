<form name="aspect" method="post" onsubmit="return false">
	<label class="column grid_10">Name</label>
	<input name="title" type="text" class="column grid_10" />
	<label class="column grid_10">Width</label>
	<input name="width" type="text" class="column grid_2" />
	<label class="column grid_10">Height</label>
	<input name="height" type="text" class="column grid_2" />	
	<input name="aspect" type="hidden" value="0"/>
	<p class="nomargin grid_10">
		<input name="save" do="submit" type="button" value="save draft" />
		<input name="cancel" type="reset" value="cancel" />
	</p>
</form>