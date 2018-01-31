<table class="custom-highlight">
	<tbody>
			<tr>
				<td>(<?php
						$db = db();
						echo $db->query("SELECT COUNT(1) FROM api_apps")->fetch_array()[0];
						$db->close();
					?>)</td>
				<td>Applications</td>
				<td width="20%">
					<a class="btn waves-effect waves-light color-blue btn-floating modal-trigger" href="#modal_applications">
						<i class="material-icons">open_in_new</i>
					</a>
				</td>
			</tr>
			<tr>
				<td>(<?php
						$db = db();
						echo $db->query("SELECT COUNT(1) FROM api_queries")->fetch_array()[0];
						$db->close();
					?>)</td>
				<td>Queries</td>
				<td width="20%">
					<a class="btn waves-effect waves-light color-blue btn-floating modal-trigger" href="#modal_query">
						<i class="material-icons">open_in_new</i>
					</a>
				</td>
			</tr>
	</tbody>
</table>

<div id="modal_applications" class="modal modal-dark modal-slim scrollbar-modern-light bottom-sheet">
	<div class="modal-content">
		<?php require "create-api-application.php"; ?>
		<?php require "view-api-application.php"; ?>
	</div>
</div>

<div id="modal_query" class="modal modal-dark modal-slim  scrollbar-modern-light bottom-sheet">
	<div class="modal-content">
		<?php require "create-api-query.php"; ?>
		<?php require "view-api-query.php"; ?>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$("#modal_query, #modal_applications").css({
			'height': ($(document).height() * (90/100)) + "px",
			'max-height':'100%'
		})
	})
</script>