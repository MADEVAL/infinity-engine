<?php
	$current_user = array_pop($url);
	if($current_user == "" ){
		$current_user = $_SESSION["user"]["id"];
	}
	$db = db();
	$current_user = $db->query("SELECT * FROM users WHERE id = '$current_user'")->fetch_assoc();
?>
<?php echo '<script type="text/javascript">document.title = "Messages - Infinity Engine"</script>'; ?>
<div class="card card-inbox inbox">
	<div class="row">
		<div class="col s4 friendlist">
			<div class="heading">
				Inbox
			</div>
			<div class="users" id="scrollbar-modern">

				<?php
					$query = $db->query("SELECT * FROM users ORDER BY name ASC");

					while($user = $query->fetch_assoc()):

						if($user["id"] == $_SESSION["user"]["id"]){ continue; }
				?>
					<div class="user">
						<div class="row">
							<div class="col s4">
								<a class="user-profile btn-floating btn-large waves-effect waves-light color-purple" href="<?=url()?>admin/messages/<?=$user["id"]?>">
									<img class="responsive-img" src="<?=url()?><?=$user['profile_picture']?>">
								</a>
							</div>
						<a href="<?=url()?>admin/messages/<?=$user["id"]?>">
							<div class="col s8">
								<div class="user-name"><?=$user['name']?></div>
								<div class="user-bio"><?=$user["status"]?></div>
							</div>
						</a>
						</div>
					</div>
				<?php
					endwhile;
				?>

			</div>
		</div>
		<div class="col s8 chat">
			<div class="user">
				<div class="row">
					<div class="col s2">
						<a class="user-profile btn-floating btn-large waves-effect waves-light color-purple" href="#">
							<img class="responsive-img" src="<?=url()?><?=$current_user["profile_picture"]?>">
						</a>
					</div>
					<div class="col s10">
						<div class="user-name"><?=$current_user["name"]?></div>
						<div class="user-bio"><?=$current_user["bio"]?></div>
					</div>
				</div>
			</div>
			<div class="chatlog" id="scrollbar-modern-light">

				<!-- MESSAGES WILL APPEAR HERE -->

			</div>
			<div class="form">
				<div class="row">
					<div class="col s10"><input class="message" type="text" id="message_content" name="message" placeholder="Enter message here" sender_id="<?=$current_user_id?>" /></div>
					<div class="col s2"><a id="message_submit" class="btn waves-effect waves-block white-text color-purple" href="#"><i class="material-icons">send</i></a></div>
				</div>
			</div>
		</div>
	</div>
</div>


<?php
	$db->close(); 
?>

<script type="text/javascript">
	template_recv_message = `
		<div class="message received">
			<a class="btn-floating btn-large waves-effect waves-light color-purple" href="#">
				<img class="responsive-img" src="<?=url()?><?=$current_user["profile_picture"]?>">
			</a>
			<div class="card-panel card-message">{message}</div>
			<div style="display:inline-block; font-size:10px; color:grey">{time}</div>
		</div>
	`;
	template_send_message = `
		<div class="message sent">
			<div style="display:inline-block; font-size:10px; color:grey">{time}</div>
			<div class="card-panel card-message">{message}</div>
			<a class="btn-floating btn-large waves-effect waves-light color-purple" href="#">
				<img class="responsive-img" src="<?=url()?><?=$_SESSION["user"]["profile_picture"]?>">
			</a>
		</div>
	`;
	function message_dom(message, send = true, time='1510207542'){
		template = template_send_message;
		if(send == false){ template = template_recv_message; }
		t = new Date(parseInt(time) * 1000)
		time_formatted = t.getHours() + " : " + t.getMinutes();
		return template.replace("{message}", message).replace("{time}", time_formatted)
	}
	function clear_chat(){
		$(".chatlog").html("")
	}
	function replenish_chat(scroll = true){
		data = {
			message_log:"",
			sender_user:"<?=$current_user["id"]?>",
			index:"0",
		}
		$.post("<?=url()?>admin/api/messages", data, function(r){
			if(scroll == true)
			window.last_scroll = $(".inbox .chat .chatlog").scrollTop();
			clear_chat();
			for (var i = r.success.messages.length - 1; i >= 0; i--) {
				message = r.success.messages[i]
				if(message.send_id == "<?=$_SESSION["user"]["id"]?>"){
					message_html = message_dom(message.message, true, message.time_stamp);
					$(".chatlog").append(message_html)
				}else{
					message_html = message_dom(message.message, false, message.time_stamp);
					$(".chatlog").append(message_html)
				}
			}
			if(scroll == true)
			$(".inbox .chat .chatlog").scrollTop(window.last_scroll);
			//inbox_create(1000);
		})
	}
	function refresh_chat(){
		replenish_chat();
		setTimeout(refresh_chat, 5000)
	}

	$(document).ready(function(){
		window.last_scroll = $('.inbox .chat .chatlog').prop("scrollHeight")
		refresh_chat();
	})
	$("#message_submit").on("click", function(e){
		e.preventDefault();
		data = {
			message_send:"",
			sender_user:"<?=$current_user["id"]?>",
			message:$("#message_content").val()
		}
		$.post("<?=url()?>admin/api/messages", data, function(r){
			$("#message_content").val("")
			replenish_chat();
		})

	})
</script>