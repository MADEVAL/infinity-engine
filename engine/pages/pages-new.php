<?php die("The page is restricted for use."); ?>
<div class="card card-panel card-dark">
	<div class="row">
		<div class="col s12">
			<h4>Creating a page</h4>
		</div>
	</div>
	<div class="row">
		<div class="input-field col s12">
			<input id="page_name" type="text" class="validate">
			<label for="page_name">Page Title</label>
		</div>
	</div>
	<div class="row">
		<div class="input-field col s12">
			<input id="page_bp" type="text" class="validate">
			<label for="page_bp">Page Blueprint</label>
		</div>
	</div>
	<div class="row">
		<div class="white-text input-field col s4"  style="vertical-align:middle;">
			<input id="page_url_head" class="white-text validate" type="text" disabled="" value="<?=url();?>">
			<label for="page_url_head" class="white-text">URL</label>
		</div>
		<div class="input-field col s8"  style="vertical-align:middle;">
			<input id="page_url" type="text" class="validate">
			<label for="page_url">Page URL</label>
		</div>
	</div>
</div>
