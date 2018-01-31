<?php
    if(isset($_POST["board_new"])){

        $db = db();
        $title = $db->real_escape_string($_POST["board_title"]);
		$desc =  $db->real_escape_string($_POST["board_desc"]);
		$color =  $db->real_escape_string($_POST["board_color"]);
		$bcolor =  $db->real_escape_string($_POST["board_background"]);
        $date = date(DATE_FORMAT);
        if(trim($title) != ""){
            $user = $_SESSION["user"]["id"];
            $db->query("INSERT INTO boards VALUES(NULL, '$title', '$desc', '$bcolor', '$color', '[]', '$user', '0', '$date')");
        }
        
        $db->close();
    }
?>

<h4>Your Boards</h4>
<div class="row white-text">
	<a class="modal_trigger" href="#modal_boards">
		<div class="col s4 boardAdd_card">
			<div class="card card-panel color-dark  waves-effect waves-light waves-block hoverable text-center">
				<i class="material-icons">add</i>
			</div>
		</div>
	</a>

	<?php
			$db = db();
			$query = $db->query("SELECT * FROM boards");
			echo $db->error;
			$counter = 0;
			while($app = $query->fetch_assoc()):
				$counter++;
		?>
			<a href="<?=url("admin/apps/boards/board.php?board=" . $app["board_id"]);?>">
				<div class="col s4 board_card">
					<div class="card card-panel color-<?=$app["board_background"]?> waves-effect waves-light waves-block hoverable">
						<h5><?=$app["board_title"]?></h5>
						<p><?=$app["board_description"]?></p>
					</div>
				</div>
			</a>
		<?php endwhile; ?>
</div>



<div id="modal_boards" class="modal modal-dark modal-slim scrollbar-modern-light bottom-sheet">
	<div class="modal-content">
		<?php require "new.modal.php"; ?>
		<?php require "view.modal.php"; ?>
	</div>
</div>


<script type="text/javascript">
	$(document).ready(function(){
		$('.materialboxed').materialbox();
		board_card = $(".board_card");
		if(board_card.length > 0){
			board_card_height = board_card.children(".card").height();
			$(".boardAdd_card .card").height(board_card_height + "px");
			$(".boardAdd_card i").css({"line-height":board_card_height + "px"});
		}
		updateListUI();
		$("#modal_boards").css({
			'height': ($(document).height() * (90/100)) + "px",
			'max-height':'100%'
		})
	})
	function updateListUI(){
		// $(".extendable-row").height($(".frame-article").height()-100 + "px")
		// $(".col-33").css({
		// 	"max-height":$(".frame-article").height()-100 + "px"
		// })
		$(".col-33").width($('.frame-article').width()/3 + "px")
		width_calculated = $(".col-33").width()
		$(".extendable-row").children().each(function(){
			width_calculated += $(this).width()
		})
		$(".extendable-row").width(width_calculated + "px")
		// $(".extendable-row .col-33 .card .collection").css({
		// 	"height": ($(".extendable-row .col-33 .card").height() - 70) + "px"
		// })
	}
</script>