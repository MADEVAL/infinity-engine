		
			<?php
				if(SiteSettings::get("USER_REGISTRATION") == "CLOSED") { ?>
		<div class="red-text card-login-message message">
			User Registration is closed.
		</div>
				<?php }
			?>

		<div class="card card-panel card-transparent white-text card-login">
			<div class="input-sizefix">
				<input id="name" type="text" placeholder="Name" />
			</div>
			<div class="input-sizefix">
				<input id="username" type="text" placeholder="Username" />
			</div>
			<div class="input-sizefix">
				<input id="email" type="text" placeholder="Email" />
			</div>
			<div class="input-sizefix">
				<input id="password" type="password" placeholder="Password" />
			</div>
			<div class="input-sizefix">
				<input id="dob" type="date" placeholder="Date of Birth" />
			</div>
			<div class="input-sizefix">
				<a class="login-button waves-effect waves-light" url="<?=url('admin/api')?>" id="signup" href="#">Signup</a>
			</div>
			<div class="text-center">
				<a href="<?=url('admin/login')?>">Login</a>
			</div>
		</div>

<script type="text/javascript">
	$(document).ready(function(){
		$("#signup").on("click", function(e){

			e.preventDefault();

			url = $(this).attr("url");
			data = {
				"signup":true,
				"name": $("#name").val(),
				"username": $("#username").val(),
				"email": $("#email").val(),
				"password": $("#password").val(),
				"date_birth": $("#dob").val()
			}
			$.post(url, data, function(response){
				if(response.success.length == 1){
					Materialize.toast("Yippee!! User has been created! Please goto the link sent to you in the email.", 10000);
				}else if(response.errors.length > 0){
					for (var i = 0; i < response.errors.length; i++) {
						error = response.errors[i];
						Materialize.toast(error, 10000);
					};
				}
			});
		})
	});
</script>

<div style="height:100px;"></div>