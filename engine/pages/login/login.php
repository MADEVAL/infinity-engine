		<div class="card card-panel card-transparent white-text card-login">
			<div class="input-sizefix">
				<input id="username" type="text" placeholder="Username/Email" />
			</div>
			<div class="input-sizefix">
				<input id="password" type="password" placeholder="Password" />
			</div>
			<div class="input-sizefix">
				<a class="login-button waves-effect waves-light" url="<?=url('admin/api')?>" landingUrl="<?=url('admin/welcome')?>" id="login" href="#">Login</a>
			</div>
			<?php
			if(SiteSettings::get("USER_REGISTRATION") == "OPEN"){
			?>
			<div class="text-center">
				<a href="<?=url('admin/signup')?>">Sign Up?</a>
			</div>
			<?php } ?>
		</div>


<script type="text/javascript">
	$(document).ready(function(){
		$("#login").on("click", function(e){
			e.preventDefault();
			url = $(this).attr("url");
			landingUrl = $(this).attr("landingUrl");
			data = {
				"login":true,
				"username": $("#username").val(),
				"password": $("#password").val()
			};
			$.post(url, data, function(response){
				if(response.errors.length > 0){
					for (var i = 0; i < response.errors.length; i++) {
						Materialize.toast(response.errors[i])
					};
				};
				if(response.success.length > 0){
					Materialize.toast("You are logged in!");
					window.location = landingUrl;
				}
			});
		});
	});
</script>
