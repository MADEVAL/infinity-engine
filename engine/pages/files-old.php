<?php echo '<script type="text/javascript">document.title = "Your Files Old - Infinity Engine"</script>'; ?>

<h4 class="white-text">Your Files</h4>

<div class="row">

	<?php
		foreach (scandir("content/user/" . user_folder($_SESSION["user"]["id"]) . "/files/") as $file) { 
			if($file == "." or $file == ".."){continue;}
		?>
		
	<div class="col s6">
		<div class="row white-text">
			<div class="col s2 text-center">
				<i class="material-icons medium">insert_drive_file</i>
			</div>
			<div class="col s10">
				<div class="file-name"><?=$file?></div>
				<div class="btn-group">
					<a href="<?=url() . "content/user/" . user_folder($_SESSION["user"]["id"]) . "/files/" . $file?>" class="btn color-purple">Download</a>
				</div>
			</div>
		</div>
	</div>

		<?php }
	?>
</div>


<div class="divider"></div>

<?php
	require "welcome-dropbox.php";
	require "welcome-footer.php";