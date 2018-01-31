
<div class="dropbox" url="<?=url()?>admin/api" redir="<?=url()?>admin/files">
	<div id="dropbox-loader" class="preloader-wrapper small active" style="display:none;opacity:0;">
		<div class="spinner-layer">
			<div class="circle-clipper left">
				<div class="circle"></div>
			</div><div class="gap-patch">
				<div class="circle"></div>
			</div><div class="circle-clipper right">
				<div class="circle"></div>
			</div>
		</div>
	</div>
	<i id="dropbox-cloud" class="material-icons">cloud_upload</i>
	<p>Drag files to upload</p>
</div>

<!-- <div class="filesbox">
	<div class="row">
		<div class="col s4">
			<img class="responsive-img" src="<?=url()?>assets/infinity-engine/stock.jpg">
		</div>
	</div>
</div> -->

<div class="divider"></div>

<script type="text/javascript">
	$(document).ready(function(){
		$(".dropbox").on("dragover", function(){
			$(this).addClass("dropbox_dragged");
			return false;
		});
		$(".dropbox").on("dragleave", function(){
			$(this).removeClass("dropbox_dragged");
			return false;
		});

		$(".dropbox").on("drop", function(e){
			e.preventDefault();
			$(this).removeClass("dropbox_dragged");
			$("#dropbox-loader").css({
				"display":"inline-block",
				"opacity":1,
			})
			$("#dropbox-cloud").remove();
			var formData = new FormData();
			var files_list = e.originalEvent.dataTransfer.files

			for (var i = 0; i < files_list.length; i++) {
				formData.append("file[]", files_list[i])
			};
			formData.append("direct_upload", true)

			$.ajax({
				url:$(this).attr("url"),
				method:"POST",
				data:formData,
				contentType:false,
				cache:false,
				processData:false,
				success:function(data){
					Materialize.toast("Uploaded to your profile")
					window.location = $(".dropbox").attr("redir")
				},
				error:function(data){
					Materialize.toast("Something went wrong.")
				}
			})
		});
	})
</script>