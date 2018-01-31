<?php
	$settings = ThemeAPI::settings();
	if(isset($settings["menus"])):
?>

<h5 style="text-align:center;">Theme Menus</h5>

<div class="row">

<?php
	foreach ($settings["menus"] as $menu):
?>

	<div class="col s2">
		<a href="<?=url('admin/menu/'.$menu->menu)?>">
			<div class="card card-dark waves-effect waves-light waves-block text-center">
				<div class="card-content">
					<h6><?=$menu->menu;?></h6>
				</div>
			</div>
		</a>
	</div>

<?php
	endforeach;
?>

</div>
<?php endif; ?>