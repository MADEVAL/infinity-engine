<?php
if(!isset($_SESSION["user"])){redir("admin/login");}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home - Infinity Engine</title>

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
<body class="white-text">

	<!-- Navigation -->
	<div class="navbar">
		<div class="row">
			<div class="col s3 navbar-logo">
				<img src="<?=url()?>assets/infinity-engine/logo.png">
			</div>
			<div class="col s7 navbar-search">
				<input id="searchbar" name="search" type="text" class="search" placeholder="Search Pages..." />
				<div class="btns">
					<a class="btn-floating waves-effect waves-light color-purple" href="<?=url()?>admin/files">
						<i class="material-icons">cloud</i>
					</a>
					<a class="btn-floating waves-effect waves-light color-purple" href="<?=url()?>admin/calendar">
						<i class="material-icons">perm_contact_calendar</i>
					</a>
					<!-- <a class="btn-floating waves-effect waves-light color-purple" href="#">
						7
					</a> -->
					<a class="btn-floating waves-effect waves-light color-purple" href="<?=url()?>admin/user-settings">
						<img class="responsive-img" src="<?=url() . $_SESSION["user"]["profile_picture"]?>">
					</a>
				</div>
			</div>
			<div class="col s2 navbar-user">
				<div class="userbio">
					<span class="username"><?=$_SESSION["user"]["name"] ?></span>
					<span class="usertag">@<?=$_SESSION["user"]["username"] ?></span>
				</div>
				<a class="btn-floating waves-effect waves-light color-purple right" href="<?=url();?>admin/logout">
					<i class="material-icons">power_settings_new</i>
				</a>
			</div>
		</div>
	</div>
	<!-- /Navigation -->

	<!-- Frame -->
	<div class="frame">
		<div class="row">
			<div class="col s2 frame-sidebar sidebar" id="scrollbar-modern">
				<!-- Sidebar -->
				<div class="user">
					<div class="profile-image">
						<img class="responsive-img circle" src="<?=url() . $_SESSION["user"]["profile_picture"]?>">
					</div>
					<div class="user-name"><?=$_SESSION["user"]["name"] ?></div>
					<div class="user-handle">@<?=$_SESSION["user"]["username"] ?></div>
				</div>

				<div class="navigation">
					<a href="<?=url()?>admin/welcome">
						<div class="row">
							<div class="col s5 right-align"><i class="material-icons">computer</i></div>
							<div class="col s7 left-align">Dashboard</div>
						</div>
					</a>
					<a href="<?=url()?>admin/pages">
						<div class="row">
							<div class="col s5 right-align"><i class="material-icons">insert_drive_file</i></div>
							<div class="col s7 left-align">Pages</div>
						</div>
					</a>
					<a href="<?=url()?>admin/data">
						<div class="row">
							<div class="col s5 right-align"><i class="material-icons">data_usage</i></div>
							<div class="col s7 left-align">Data</div>
						</div>
					</a>
					<a href="<?=url()?>admin/messages">
						<div class="row">
							<div class="col s5 right-align"><i class="material-icons">message</i></div>
							<div class="col s7 left-align">Messages</div>
						</div>
					</a>
					<a href="<?=url()?>admin/settings">
						<div class="row">
							<div class="col s5 right-align"><i class="material-icons">settings</i></div>
							<div class="col s7 left-align">Settings</div>
						</div>
					</a>
				</div>
				<!-- /Sidebar -->
			</div>
			<div class="col s8 frame-article article" id="scrollbar-modern-dark">
				<!-- Article -->

					<?php $theme_settings = ThemeAPI::settings(); ?>

					<?php
						if(file_exists($file)){
							require $file;
						}else{
							require $error_file;
						}
					?>
				<!-- /Article -->
			</div>
			<div class="col s2 frame-notifs notifs" id="scrollbar-modern">
				<!-- Messages -->

				<div class="button-group">
					<div class="row">
						<div class="col s6">
							<a class="btn waves-effect seperate-right" href="<?=url('admin/messages')?>" target="_blank"><i class="material-icons">people</i></a>
						</div>
						<div class="col s6">
							<a class="active btn waves-effect seperate-left"><i class="material-icons">notifications</i></a>
						</div>
					</div>
				</div>

				<div class="heading">NOTIFICATIONS</div>

				<?php
					$db = db();
					$query = $db->query("SELECT * FROM notifications WHERE user_id = " . $_SESSION["user"]["id"] . " ORDER BY time_stamp DESC LIMIT 0, 10");
					while($notif = $query->fetch_assoc()):
				?>

				<div class="notif">
					<div class="row">
						<div class="col s3 notif-icon-holder">
							<i class="material-icons"><?=$notif["icon"]?></i>
						</div>
						<div class="col s9 notif-bio">
							<span class="notif-title"><?=$notif["title"]?></span>
							<span class="notif-description"><?=$notif["message"]?></span>
						</div>
					</div>
				</div>

				<?php
					endwhile;
					$db->close();
				?>
				
				<!-- /Messages -->
			</div>
		</div>
	</div>
	<!-- /Frame -->

	<div class="searchbox" id="scrollbar-modern-transparent">
		<input id="search_form" class="search_form"  type="text" placeholder="Search Pages..." />
		<div class="results" id="scrollbar-modern-transparent">
			
		</div>
		<script type="text/javascript">
		$(document).ready(function(){
			//alert("Make Search Work :: $.post() at Line no 205 template-admin.php")
			$("#search_form").on("input", function(){
				$(".results").html("");
				value = $(this).val();
				window.searchVal = value
				url = "<?=url()?>admin/api"
				if(value.length > 2){
					data = {
						searchData:value
					}
					$.post(url, data, function(r){
						$(".results").html("")
						for (var i = 0; i < r.data.length; i++) {
							search_result = r.data[i]
							page = r.data[i].link.title
							_result = `<a href="<?=url()?>admin/edit/{link}"><div class="result">{counter}. <b>{search}</b> in page titled <b>{page}</b></div></a>`.replace("{link}", r.data[i].link.id).replace("{counter}", i+1).replace("{search}", window.searchVal).replace("{page}",page);
							$(".results").append(_result)
						};
					})
				}
			})
		});
		</script>
	</div>

</body>
</html>