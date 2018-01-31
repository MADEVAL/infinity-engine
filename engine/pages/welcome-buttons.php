
<div class="row">
	<div class="col s3">
		<a class="dropdown-button" data-activates='dropdown_newfile' href="#">
			<div class="card card-button color-purple tooltipped waves-effect waves-block" data-position="bottom" data-tooltip="New page">
				<i class="material-icons">insert_drive_file</i>
			</div>
		</a>
		<ul id='dropdown_newfile' class='dropdown-content'>
			<?php
				if(isset($theme_settings["pages"])){
					foreach ($theme_settings["pages"] as $page) {
						if(is_a($page, "Theme_Divider")){
							?>
								<li class="divider"></li>
							<?php
							continue;
						}
					?>
						<li><a href="<?=url()?>admin/page/<?=$page->file;?>"><i class="material-icons"><?=$page->icon;?></i> <?=$page->title;?></a></li>
			<?php	}
				}
			?>
		</ul>
		<script type="text/javascript">
		$(document).ready(function(){
			btn_width = $(".card-button").width();
			$('.dropdown-button').dropdown({
				inDuration: 300,
				outDuration: 225,
				constrainWidth: false, // Does not change width of dropdown to that of the activator
				hover: false, // Activate on hover
				gutter: btn_width, // Spacing from edge
				belowOrigin: false, // Displays dropdown below the button
				alignment: 'left', // Displays dropdown with edge aligned to the left of button
				stopPropagation: false // Stops event propagation
			});
		})
		</script>
	</div>
	<div class="col s3">
		<a href="<?=url('admin/apps')?>">
			<div class="card card-button color-pink tooltipped waves-effect waves-block" data-position="bottom" data-tooltip="Apps">
				<i class="material-icons">apps</i>
			</div>
		</a>
	</div>

	<div class="col s3">
		<a href="<?=url('admin/themes')?>">
			<div class="card card-button color-blue tooltipped waves-effect waves-block" data-position="bottom" data-tooltip="Themes">
				<i class="material-icons">store</i>
			</div>
		</a>
	</div>

	<div class="col s3">
		<a href="<?=url()?>admin/settings">
			<div class="card card-button color-dark tooltipped waves-effect waves-light waves-block" data-position="bottom" data-tooltip="Settings">
				<i class="material-icons">settings_applications</i>
			</div>
		</a>
	</div>
</div>

<div class="divider"></div>

<script type="text/javascript">
	$(document).ready(function(){
		$("#modal_new_page").modal();
	});
</script>

<div id="modal_new_page" class="modal modal-fixed-footer">
	<div class="modal-content">
		<h4>New Page</h4>
		<div class="row">
			<div class="col s12 input-field">
				<label>Page Name</label>
				<input type="text" class="browser-default" placeholder="index.html" />
			</div>
		</div>

	</div>
	<div class="modal-footer">
		<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Create</a>
	</div>
</div>
