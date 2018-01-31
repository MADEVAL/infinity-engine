<!DOCTYPE html>
<html>
<head>
	<title>Infinity Engine</title>

	<!-- jQuery Imports -->
	<script type="text/javascript" src="<?=url()?>assets/jquery/dist/jquery.min.js"></script>

	<!-- Materialize Imports -->
	<link rel="stylesheet" type="text/css" href="<?=url()?>assets/materialize/dist/css/materialize.min.css">
	<script type="text/javascript" src="<?=url()?>assets/materialize/dist/js/materialize.min.js"></script>

	<!-- MaterialIcons Imports -->
	<link rel="stylesheet" type="text/css" href="<?=url()?>assets/materialicons/materialicons.css">

	<!-- TemplateFonts Imports -->
	<link rel="stylesheet" type="text/css" href="<?=url()?>assets/infinity-engine-fonts/fonts.css">

	<!-- Template Imports -->
	<link rel="stylesheet" type="text/css" href="<?=url()?>assets/infinity-engine/style.css">
	<script type="text/javascript" src="<?=url()?>assets/infinity-engine/script.js"></script>

</head>
<body class="color-dark">

	<div class="container container-login">
		<div class="site-logo">
			<img class="responsive-img" src="<?=url()?>assets/infinity-engine/logo.png">
		</div>

		<?php require $file; ?>
	</div>

</body>
</html>