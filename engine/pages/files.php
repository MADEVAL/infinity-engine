<?php echo '<script type="text/javascript">document.title = "NetDrive - Infinity Engine"</script>'; ?>
<nav class="color-dark">
	<div class="nav-wrapper">
		<div class="col s12">
			<a href="#!" class="breadcrumb">NetDrive</a>
			<a href="#!" class="breadcrumb">Your Files</a>
		</div>
	</div>
</nav>

<?php $counter = 0; ?>


<?php /* ?>

<div class="row">
	<div class="col s2">
		<a href='#'>
			<div class="card card-fs-file tooltipped text-center width-height hoverable waves-effect waves-light waves-block"  data-position="bottom" data-delay="50" data-tooltip="New folder">
				<i class="whable material-icons">create_new_folder</i>
			</div>
		</a>
	</div>

	<?php
		$root = "content/user/" . user_folder($_SESSION["user"]["id"]) . "/files/";
		foreach (scandir($root) as $file) {
			if($file == "." or $file == ".."){continue;}
			if(!is_dir($root . $file)){continue;}
			$dropdownid = "_folder_" . $counter ++;
		?>
	<div class="col s2">
		<a class='dropdown-button' href='#' data-activates='dropdown<?=$dropdownid?>'>
			<div class="card card-fs-file tooltipped text-center width-height hoverable waves-effect waves-light waves-block"  data-position="bottom" data-delay="50" data-tooltip="<?=$file?>">
				<i class="whable material-icons">folder</i>
			</div>
		</a>
		<ul id='dropdown<?=$dropdownid?>' class='dropdown-content'>
			<li><a href="#!">Open</a></li>
			<li><a href="#!">Delete</a></li>
		</ul>
	</div>

		<?php }
	?>

</div>


<div class="divider"></div>

<?php */ ?>

<div class="row">

	<?php
function endswith($string, $test) {
	$strlen = strlen($string);
	$testlen = strlen($test);
	if ($testlen > $strlen) return false;
	return substr_compare($string, $test, $strlen - $testlen, $testlen) === 0;
}

		$root = "content/user/" . user_folder($_SESSION["user"]["id"]) . "/files/";
		$thumbroot = "content/user/" . user_folder($_SESSION["user"]["id"]) . "/thumbs/";
		foreach (scandir($root) as $file) { 
			if($file == "." or $file == ".."){continue;}
			if(is_dir($root . $file)){continue;}
			$dropdownid = "_file_" . $counter ++;
			if(endswith($file, "jpg") or endswith($file, "png") or endswith($file, "gif")){
				$raw_array = explode(".", $file); 
				array_pop($raw_array);
				$raw_file_name = implode(".", $raw_array);
				if(!file_exists($thumbroot . $raw_file_name . ".jpg")){
					$resizeObj = new resize($root.$file);
					$resizeObj->resizeImage(256, 256, 'crop');
					$resizeObj->saveImage($thumbroot.$raw_file_name.".jpg", 80);
				}
				$thumbfile = $thumbroot . $raw_file_name . ".jpg";
?>

	<div class="col s2">
		<a class='dropdown-button' href='#' data-activates='dropdown<?=$dropdownid?>'>
			<div class="card card-fs-file card-fs-file-img tooltipped text-center width-height hoverable waves-effect waves-light waves-block" data-position="top" data-delay="50" data-tooltip="<?=$file?>">
				<i class="material-icons">photo</i>
				<img class="responsive-img" src="<?=url().$thumbfile;?>">
			</div>
		</a>
		<ul id='dropdown<?=$dropdownid?>' class='dropdown-content'>
			<li><a href="<?=url() . $root . $file?>" target="_blank">Open</a></li>
			<li><a href="<?=url() . $root . $file?>" download="<?=$file?>">Download</a></li>
			<li><a href="#!">Edit</a></li>
			<li><a href="<?=url('admin/file-delete/'.$file)?>">Delete</a></li>
			<li><a href="#modal<?=$dropdownid?>">Details</a></li>
		</ul>
	</div>

	<div id="modal<?=$dropdownid?>" class="black-text modal">
		<div class="modal-content">
			<p><b><?=$file;?></b></p>
			<p>URL  : <a class="blue-text" href="<?=url().$root.$file?>">Link</a></p>
			<p>Size : <?=round(filesize($root.$file)/1024, 2)?>KB</p>
		</div>
		<div class="modal-footer">
			<a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Close</a>
		</div>
	</div>

<?php
			}else{
		?>
	<div class="col s2">
		<a class='dropdown-button' href='#' data-activates='dropdown<?=$dropdownid?>'>
			<div class="card card-fs-file tooltipped text-center width-height hoverable waves-effect waves-light waves-block"  data-position="top" data-delay="50" data-tooltip="<?=$file?>">
				<i class="whable material-icons">insert_drive_file</i>
			</div>
		</a>
		<ul id='dropdown<?=$dropdownid?>' class='dropdown-content'>
			<li><a href="<?=url() . "content/user/" . user_folder($_SESSION["user"]["id"]) . "/files/" . $file?>">Download</a></li>
			<li><a href="#!">Delete</a></li>
			<li><a href="#!">Details</a></li>
		</ul>
	</div>

		<?php }}
	?>
</div>
<!-- 
<div class="row">
	<div class="col s2">
		<a class='dropdown-button' href='#' data-activates='dropdown1'>
			<div class="card card-fs-file tooltipped text-center width-height hoverable waves-effect waves-light waves-block"  data-position="bottom" data-delay="50" data-tooltip="system.dat">
				<i class="whable material-icons">insert_drive_file</i>
			</div>
		</a>
		<ul id='dropdown1' class='dropdown-content'>
			<li><a href="#!">Download</a></li>
			<li><a href="#!">Delete</a></li>
			<li><a href="#!">Details</a></li>
		</ul>
	</div>
	<div class="col s2">
		<a class='dropdown-button' href='#' data-activates='dropdown2'>
			<div class="card card-fs-file card-fs-file-img tooltipped text-center width-height hoverable waves-effect waves-light waves-block" data-position="bottom" data-delay="50" data-tooltip="Sheldon.jpg">
				<i class="material-icons">photo</i>
				<img class="responsive-img" src="assets/infinity-engine/fsdemo.png">
			</div>
		</a>
		<ul id='dropdown2' class='dropdown-content'>
			<li><a href="#!">Open</a></li>
			<li><a href="#!">Download</a></li>
			<li><a href="#!">Edit</a></li>
			<li><a href="#!">Delete</a></li>
			<li><a href="#!">Details</a></li>
		</ul>
	</div>
	<div class="col s2">
		<a class='dropdown-button' href='#' data-activates='dropdown3'>
			<div class="card card-fs-file card-fs-file-img tooltipped text-center width-height hoverable waves-effect waves-light waves-block" data-position="bottom" data-delay="50" data-tooltip="The Big Bang Theory S09E17.mp4">
				<i class="material-icons">videocam</i>
				<img class="responsive-img" src="assets/infinity-engine/fsdemo.png">
			</div>
		</a>
		<ul id='dropdown3' class='dropdown-content'>
			<li><a href="#!">Open</a></li>
			<li><a href="#!">Download</a></li>
			<li><a href="#!">Edit</a></li>
			<li><a href="#!">Delete</a></li>
			<li><a href="#!">Details</a></li>
		</ul>
	</div>
</div> -->

<div style="height:40px;"></div>

<script type="text/javascript">
	$(document).ready(function(){
		wdh = $(".width-height").width();
		$(".width-height").css({
			"height":wdh + "px",
		});
		$(".width-height i.whable").css({
			"line-height": wdh + "px"
		});
		$('.tooltipped').tooltip({delay: 50});
		$('.dropdown-button').dropdown({
			inDuration: 300,
			outDuration: 225,
			constrainWidth: false, // Does not change width of dropdown to that of the activator
			hover: false, // Activate on hover
			gutter: wdh, // Spacing from edge
			belowOrigin: false, // Displays dropdown below the button
			stopPropagation: false // Stops event propagation
		});
	})
</script>

<div class="divider"></div>

<?php require "engine/pages/welcome-dropbox.php"; ?>
<?php require "engine/pages/welcome-footer.php"; ?>