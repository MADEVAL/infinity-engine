<?php

session_destroy();

?>

<h4 class="white-text">Logging out...</h4>

<style type="text/css">
	.hidden-for-one-second{
		display: none;
	}
</style>
<p class="white-text hidden-for-one-second">Please refresh the page to successfully logout.</p>

<script type="text/javascript">
	window.location = "<?=url('admin')?>";

	$(document).ready(function(){
		setTimeout(function() {
			$(".hidden-for-one-second").removeClass("hidden-for-one-second");
		}, 1000);
	})
</script>