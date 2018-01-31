<?php echo '<script type="text/javascript">document.title = "Calendar - Infinity Engine"</script>'; ?>
<style type="text/css">
	.calendar-information{
		font-size: 24px;
		line-height: 54px;
	}
	.card-flexible .bottom{
		position: absolute;
		bottom: 10px;
	}
	.card-flexible{
		min-height: 175px;
		display: block;
		text-shadow:0px 0px 5px rgba(0,0,0, 1);
	}
</style>
<div class="card card-panel card-dark calender-controls">
	<div class="row unpad">
		<div class="col s4" style="text-align:right">
			<a id="calendar_previous" class="btn btn-large color-purple waves-effect waves-light"><i class="material-icons">arrow_back</i></a>
		</div>
		<div class="col s4 calendar-information" style="text-align:center">
			<span class="calendar-month"></span>
			<span class="calendar-year"></span>
		</div>
		<div class="col s4">
			<a id="calendar_next" class="btn btn-large color-purple waves-effect waves-light"><i class="material-icons">arrow_forward</i></a>
		</div>
	</div>
</div>

<div id="calendar" class="fc-calendar-container">
	<!-- Calendar -->
</div>

<?php require "engine/api/event_create.php"; ?>

<div class="card card-dark">
	<div class="card-content">
		<span class="card-title">Upcoming Events</span>

		<?php
			$db = db();
			$query = $db->query("SELECT * FROM events WHERE (event_user = " . $_SESSION["user"]["id"] . " AND event_completion = 0) OR event_scope=3");
			$total_rows = $query->num_rows;
		?>

		<div class="row flexible-cards" id="eventHolder" action="<?=url()?>admin/api">
			<div class="col s4">
				<a class="modal-trigger" href="#addCalendarEvent">
					<div class="card card-button-2 color-purple card-flexible text-center waves-effect waves-block waves-light">
						<i class="material-icons">add</i>
					</div>
				</a>
			</div>
<?php
			while($row = $query->fetch_array()){
?>
			<div id="event_card" class="col s4">
				<div class="card color-pink card-flexible hoverable" style="background:rgb(44,45,49) url('<?=url() . $row["event_image"]?>'); background-size:cover;">
					<div class="card-content">
						<span class="card-title text-shadow"><?=$row["event_name"]?></span>
						<p class="bottom text-shadow"><?=$row["event_date"]?></p>
						<?php if($row["event_user"] != $_SESSION["user"]["id"]){

							}else{ ?>
							<a id="eventComplete" event="<?=$row["event_id"]?>" class="btn-floating waves-effect waves-light color-blue right halfway-fab"><i class="material-icons">check</i></a>
						<?php } ?>
					</div>
				</div>
			</div>
<?php
			} 
?>
		</div>
	</div>
</div>

<div id="addCalendarEvent" class="modal modal-fixed-footer black-text">
	<form id="event_form" method="post" enctype="multipart/form-data">
		<div class="modal-content"  id="scrollbar-modern-transparent">
			<h4>Add Event</h4>
			<div class="row">
				<div class="input-field col s6">
					<input id="eventName" name="event_name" type="text" class="validate">
					<label for="eventName">Event Name</label>
				</div>
				<div class="input-field col s6">
					<input id="eventDate" name="event_date" type="date" class="validate">
				</div>
				<div class="input-field col s12">
					<select name="event_scope">
						<option value="" disabled selected>Choose your option</option>
						<option value="1">Personal</option>
						<option value="2">Holiday</option>
						<?php if($_SESSION["user"]["level"] >= 10): ?>
						<option value="3">Site Wise</option>
						<?php endif; ?>
					</select>
					<label>Event Type</label>
				</div>
				<div class="file-field input-field col s12">
					<div class="btn">
						<span>Image</span>
						<input name="event_image" type="file">
					</div>
					<div class="file-path-wrapper">
						<input class="file-path validate" type="text">
					</div>
				</div>
				<div class="col s12">
					<input type="checkbox" class="filled-in" name="event_reminder" id="filled-in-box" checked="checked" />
					<label for="filled-in-box">Reminder</label>
				</div>
			</div>
			<input type="hidden" name="event_create" value="true" />
		</div>
		<div class="modal-footer">
			<input type="submit" name="event_create" value="Save" class="waves-effect waves-green btn-flat" />
			<a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat ">Cancel</a>
	</div>
	</form>
</div>


<link rel="stylesheet" type="text/css" href="<?=url()?>assets/calendario/css/calendar.css">
<link rel="stylesheet" type="text/css" href="<?=url()?>assets/infinity-engine/calendar_custom.css">
<script type="text/javascript" src="<?=url()?>assets/calendario/js/jquery.calendario.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		cal = calendar_init();
		$("#calendar_next").on("click", function(){
			cal.gotoNextMonth(function(){ calendar_update() });
		})
		$("#calendar_previous").on("click", function(){
			cal.gotoPreviousMonth(function(){ calendar_update() });
		})
		$('.modal').modal();
		$('select').material_select();

		$("#create_event").on("click", function(e){
			e.preventDefault();
			form_el = $("#event_form")[0];
			form_el = document.querySelector("form#event_form")
			var formData = new FormData(form_el);
			url = $(this).attr("url");
			console.log(formData)
			$.ajax({
				url:url,
				type:"POST",
				data: formData,
				processData:false,
				success:function(response){
					// console.log(response)
				}
			})
			
		})

		$(document).on("click", "#eventComplete", function(e){
			event_id = $(this).attr("event");
			url = $("#eventHolder").attr("action");
			data = {
				event_complete:true,
				event_id:event_id
			}
			completed_event = $(this);
			$.post(url, data, function(response){
				for (var i = 0; i < response.success.length; i++) {
					Materialize.toast(response.success[i]);
					completed_event.parents("#event_card").remove();
				};
			})
		})
	});

	function calendar_init(){
		cal = $('#calendar').calendario();
		$(".fc-past, .fc-future, .fc-today").addClass("waves-effect waves-block")
		$(".calendar-month").html(cal.getMonthName())
		$(".calendar-year").html(cal.getYear())
		$(".fc-past, .fc-future, .fc-today").on("click", calendar_click)
		return cal;
	}
	function calendar_update(){
		$(".fc-past, .fc-future, .fc-today").addClass("waves-effect waves-block")
		$(".calendar-month").html(cal.getMonthName())
		$(".calendar-year").html(cal.getYear())
		$(".fc-past, .fc-future, .fc-today").on("click", calendar_click)
	}
	function calendar_click(e) {
		eldate = $(this).children(".fc-date")
		if(!eldate.hasClass("fc-emptydate")){
			date = eldate.text()
			month = cal.getMonthName()
			year = cal.getYear()

			d = date + " " + month + " " + year
			;
			console.log(new Date(d))

		}else{}
	}
</script>