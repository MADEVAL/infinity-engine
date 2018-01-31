<?php echo '<script type="text/javascript">document.title = "Error Encountered - Infinity Engine"</script>'; ?>
<div class="white-text">
	<h1><?php if (isset($errorTitle)) echo $errorTitle; else echo "Internal Server Error"; ?></h1>
	<p><?php if (isset($errorMessage)) echo $errorMessage; else echo "Router could not find the requested file."; ?></p>
</div>