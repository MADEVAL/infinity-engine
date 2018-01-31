<?php echo '<script type="text/javascript">document.title = "Apps - Infinity Engine"</script>'; ?>

<h4>Applications</h4>


<div class="row">
	<?php
		$folders = scandir("engine/apps/");
		foreach($folders as $folder):
			if(!is_dir("engine/apps/" . $folder)) continue;
			if($folder == "." || $folder == "..") continue;
	?>
		
		<div class="col s3">
			<a href="<?=url()?>admin/apps/<?=$folder?>">
				<div class="card card-glow-image-text waves-effect waves-light">
					<div class="card-image">
						<img src="<?=url()?>engine/apps/<?=$folder?>/screenshot.jpg">
						<span class="card-title"><?=ucwords(str_replace("_", " ", $folder));?></span>
					</div>
				</div>
			</a>
		</div>

	<?php
		endforeach;
	?>
</div>