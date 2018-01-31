<?php echo '<script type="text/javascript">document.title = "Menu Editor - Infinity Engine"</script>'; ?>
<?php 
$menu_name = array_shift($url);
$settings = ThemeApi::settings();
if(isset($settings["menus"])):

foreach ($settings["menus"] as $menu) {
  if($menu->menu == $menu_name){
    $super_menu = $menu_name;
  }
}

if(isset($super_menu)):
unset($menu);
$db = db();
$query = $db->query("SELECT * FROM menus WHERE menu_title='" . $super_menu ."'");
$menu_created = 0;
if($query->num_rows == 1){
  $menu_created = 1;
  $menu = $query->fetch_array();
}
$db->close();

?>

<script type="text/javascript" src="<?=url('assets/jquery-domenu/')?>jquery.domenu.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	superMenu = $('#domenu').domenu()
<?php
  if($menu_created == 1):
?>
	superMenu.parseJson('<?=$menu["menu_data"]?>');
<?php else: ?>
  superMenu.parseJson('[{"id":7,"title":"Item 7","http":""},{"id":6,"title":"Item 6","http":"","children":[{"id":5,"title":"Item 5","http":""},{"id":4,"title":"Item 4","http":""},{"id":3,"title":"Item 3","http":""}]},{"id":2,"title":"Item 2","http":""},{"id":1,"title":"Item 1","http":""}]');
<?php endif; ?>
	$(".renderList").on("click", function(e){
		e.preventDefault();
		menu_data = superMenu.toJson();
    url = "<?=url()?>" + "admin/api/createMenu";
    data = {
      createMenu:"<?=$super_menu?>",
      menuData : menu_data
    }
    $.post(url, data, function(resp){
      Materialize.toast("Menu has been saved.")
      console.log(resp)
    });
	});

  $(".refresh").on("click", function(){
    location.reload();
  })
})
</script>
<style type="text/css">
.dd {
  position: relative;
  display: block;
  margin: 0;
  padding: 0;
  max-width: 600px;
  list-style: none;
  font-size: 13px;
  line-height: 20px;
}
.dd-edit-box { position: relative; }
.dd-edit-box input {
  border: 1px solid rgb(120,130, 135) !important;
  border-radius: 4px;
  text-align: center;
  outline: none !important;
  font-size: 13px;
  color: #444;
  width: 45%;
  height: 20px;
  color:white;
}
.dd-edit-box input:focus, .dd-edit-box input:active {
  border: 1px solid rgb(120,130, 135) !important;
  box-shadow: none !important;
  outline:0px;
}
.dd-edit-box i {
  right: 0;
  overflow: hidden;
  cursor: pointer;
  position: absolute;
}
.dd-item-blueprint { display: none; }
.dd-list {
  display: block;
  position: relative;
  margin: 0;
  padding: 0;
  list-style: none;
}
.dd-list .dd-list { padding-left: 30px; }
.dd-collapsed .dd-list { display: none; }

.dd-item,  .dd-empty,  .dd-placeholder {
  display: block;
  position: relative;
  margin: 0;
  padding: 0;
  min-height: 40px;
  line-height: 20px;
  font-size: 13px;
}

.dd-handle {
  cursor: move;
  display: block;
  height: 30px;
  margin: 5px 0;
  padding: 5px 10px;
  color: white;
  text-decoration: none;
  font-weight: bold;
  background: #E74C3C;
  border-radius: 3px;
  box-sizing: border-box;
}

.dd-handle:hover {
  color: #2ea8e5;
  background: #fff;
}

.dd-item > button {
  display: inline-block;
  position: relative;
  cursor: pointer;
  float: left;
  width: 40px;
  height: 40px;
  margin: 0px 5px 5px 40px;
  padding: 0;
  white-space: nowrap;
  overflow: hidden;
  border: 0;
  border-top: 1px solid rgb(70,76,79);
  border-bottom: 1px solid rgb(70,76,79);
  background: #f92f7a;
  font-size: 18px;
  line-height: 35px;
  text-align: center;
  font-weight: bold;
  color: white;
}

.dd-item .item-remove {
  float:right;
  width: 20px;
  height: 20px;
  padding: 0px 5px;
  background:#04aec6;
  border:0px;
  border-radius: 4px;
}
.dd-item .item-remove:hover {
  background:#17E0FB;
  color:black;
}

.dd3-item > button:first-child { margin-left: 30px; }

.dd-item > button:before {
  display: block;
  position: absolute;
  width: 100%;
  text-align: center;
  text-indent: 0;
}

.dd-placeholder,  .dd-empty {
  margin: 5px 0;
  padding: 0;
  min-height: 40px;
  background: #f2fbff;
  border: 1px dashed #b6bcbf;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
}

.dd-empty {
  border: 1px dashed #bbb;
  min-height: 100px;
  background-color: #e5e5e5;
  background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),  -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
  background-image: -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),  -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
  background-image: linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),  linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
  background-size: 60px 60px;
  background-position: 0 0, 30px 30px;
}

.dd-dragel {
  height: 60px;
  position: absolute;
  pointer-events: none;
  z-index: 9999;
}

.dd-dragel > .dd-item .dd-handle { margin-top: 0; }

.dd-dragel .dd-handle {
  -webkit-box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
  box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
}

.dd3-content {
  display: block;
  height: 40px;
  margin: 5px 0;
  padding: 9px 15px 5px 50px;
  color: white;
  text-decoration: none;
  font-weight: bold;
  border: 1px solid rgb(70,76,79);
  background: rgb(70,76,78);
  border-radius: 3px;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
}

.dd3-content:hover {
  background: rgb(80,85,88);
}

.dd-dragel > .dd3-item > .dd3-content { margin: 0; }

.dd3-handle {
  position: absolute;
  margin: 0;
  left: 0;
  top: 0;
  cursor: move;
  width: 40px;
  height: 40px;
  line-height: 35px;
  text-indent: 100%;
  white-space: nowrap;
  overflow: hidden;
  border: 1px solid rgb(70,76,79);
  text-shadow: 0 1px 0 #807B7B;
  background: #6256a9;
  border-top-right-radius: 0;
  border-bottom-right-radius: 0;
}

.dd3-handle:before {
  content: '≡';
  display: block;
  position: absolute;
  left: 0;
  top: 3px;
  width: 100%;
  text-align: center;
  text-indent: 0;
  color: #fff;
  font-size: 20px;
  font-weight: normal;
}

.dd3-handle:hover {
  background: #6256a9; 
}
.dd-new-item{
	height:40px;
	width:40px;
	background:#6256a9;
	color: white;
	border:0px;
	border-radius: 4px;
	font-size: 28px;
}
.dd-new-item:focus{
	background:#7C70C3;
}
</style>

<div class="row">
	<div class="col s12">
		<!--  -->
	</div>
	<div class="col s12">
		<div class="dd" id="domenu">
			<button class="dd-new-item">+</button>
			<!-- .dd-item-blueprint is a template for all .dd-item's -->
			<li class="dd-item-blueprint">
				<div class="dd-handle dd3-handle">Drag</div>
				<div class="dd3-content"> <span>[item_name]</span>
					<button class="item-remove">&times;</button>
					<div class="dd-edit-box" style="display: none;">
						<input type="text" name="title" placeholder="name">
						<input type="url" name="http" placeholder="http://">
					</div>
				</div>
			</li>
			<ol class="dd-list">
			</ol>
		</div>

    <div style="height:100px;"></div>

    <a class="btn renderList waves-effect waves-light color-purple">Save</a>
		<a class="btn refresh waves-effect waves-light color-purple">Refresh</a>
	</div>
</div>



<?php
else:
  $errorTitle = "Menu Not Available";
  $errorMessage = "Requested Menu Type is not compatible with the theme.";
  require "engine/pages/error.php";
endif;

endif; ?>
