<!DOCTYPE html>
<html>
<head>
	<title><?php Theme::Title(); ?></title>
	<link rel="stylesheet" type="text/css" href="<?=Theme::URL("", true)?>assets/materialize/dist/css/materialize.min.css">
	<script type="text/javascript" src="<?=Theme::URL("", true)?>assets/jquery/dist/jquery.min.js"></script>
	<script type="text/javascript" src="<?=Theme::URL("", true)?>assets/materialize/dist/js/materialize.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?=Theme::URL("", true)?>assets/materialicons/materialicons.css">
	<link rel="stylesheet" type="text/css" href="<?=Theme::URL("", true)?>assets/agora/style.css">
	<link rel="stylesheet" type="text/css" href="<?=Theme::URL("", true)?>assets/font/font.css">
	<link rel="stylesheet" type="text/css" href="<?=Theme::URL("", true)?>assets/font/flaticon.css">
	<script type="text/javascript" src="<?=Theme::URL("", true)?>assets/agora/jquery.ba-resize.min.js"></script>
	<script type="text/javascript" src="<?=Theme::URL("", true)?>assets/agora/script.js"></script>
	<?php Theme::Header(); ?>
</head>
<body>
	<div class="navbar">
		<span class="title"><?php echo Theme::Information("SITE_TITLE"); ?></span>
		<div class="right">
			<a class="navbar-button" href="#">
				<i class="flaticon-user-3"></i>
			</a>
			<a class="navbar-button dropdown-button " href="#" data-activates='dropdown1'>
				<i class="flaticon-agenda"></i>
			</a>
				<ul id='dropdown1' class='dropdown-content'>
					<li><a href="#!">travel blog</a></li>
					<li><a href="#!">web designs</a></li>
					<li><a href="#!">game dev</a></li>
					<li class="divider"></li>
					<li><a href="#!">youtube</a></li>
					<li><a href="#!">instagram</a></li>
				</ul>
		</div>
	</div>

	<div class="jumbotron navbar-fix">
		<h3>Latest News</h3>
		<div class="small">
			<b>Our siteline.</b>
		</div>
	</div>

	<div class="page-height"></div>

	<div class="page-wrapper">
		<?php Theme::Content(); ?>
	</div>

	<div class="footer">
		<div class="container container-site">
			<div class="row footer-row">
				<div class="col s4">
					<span class="title">Agora</span>
					<p class="description">
						<?php echo ThemeGet::getSettings("Footer Description"); ?>
					</p>
				</div>
				<div class="col s5">
					<span class="title">Links</span>
					<ul class="links">
					<?php foreach(ThemeGet::getMenu("Footer") as $menu_item): ?>
						<li><a href="<?=$menu_item['http']?>"><?=$menu_item['title']?></a></li>
					<?php endforeach; ?>
					</ul>

				</div>
				<div class="col s3">
					<span class="title">Social</span>
					<ul class="social row">
							<?php
								$link = ThemeGet::getSettings("Facebook Link");
								if(isset($link) and $link != ""):
							?>
						<li class="col s3">
							<a href="<?=$link?>">
								<img class="responsive-img" src="<?=Theme::URL("", true)?>assets/font/png/facebook.png">
							</a>
						</li>
							<?php
								endif;
							?>

							<?php
								$link = ThemeGet::getSettings("Twitter Link");
								if(isset($link) and $link != ""):
							?>
						<li class="col s3">
							<a href="<?=$link?>">
								<img class="responsive-img" src="<?=Theme::URL("", true)?>assets/font/png/twitter.png">
							</a>
						</li>
							<?php
								endif;
							?>
							<?php
								$link = ThemeGet::getSettings("Instagram Link");
								if(isset($link) and $link != ""):
							?>
						<li class="col s3">
							<a href="<?=$link?>">
								<img class="responsive-img" src="<?=Theme::URL("", true)?>assets/font/png/instagram.png">
							</a>
						</li>
						<?php
								endif;
							?>
							<?php
								$link = ThemeGet::getSettings("Tumblr Link");
								if(isset($link) and $link != ""):
							?>
						<li class="col s3">
							<a href="<?=$link?>">
								<img class="responsive-img" src="<?=Theme::URL("", true)?>assets/font/png/tumblr.png">
							</a>
						</li>
						<?php
								endif;
							?>
							<?php
								$link = ThemeGet::getSettings("SoundCloud Link");
								if(isset($link) and $link != ""):
							?>
						<li class="col s3">
							<a href="<?=$link?>">
								<img class="responsive-img" src="<?=Theme::URL("", true)?>assets/font/png/soundcloud.png">
							</a>
						</li>
						<?php
								endif;
							?>
							<?php
								$link = ThemeGet::getSettings("LinkedIn Link");
								if(isset($link) and $link != ""):
							?>
						<li class="col s3">
							<a href="<?=$link?>">
								<img class="responsive-img" src="<?=Theme::URL("", true)?>assets/font/png/linkedin.png">
							</a>
						</li>
						<?php
								endif;
							?>
							<?php
								$link = ThemeGet::getSettings("Google Plus Link");
								if(isset($link) and $link != ""):
							?>
						<li class="col s3">
							<a href="<?=$link?>">
								<img class="responsive-img" src="<?=Theme::URL("", true)?>assets/font/png/google-plus.png">
							</a>
						</li>
						<?php
								endif;
							?>
							<?php
								$link = ThemeGet::getSettings("Behance Link");
								if(isset($link) and $link != ""):
							?>
						<li class="col s3">
							<a href="<?=$link?>">
								<img class="responsive-img" src="<?=Theme::URL("", true)?>assets/font/png/behance.png">
							</a>
						</li><?php
								endif;
							?>
					</ul>
				</div>
			</div>
		</div>
	</div>

</body>
</html>