
<?php   
    $db = db();
    $id = 0; 
    if(isset($_GET["board"])){
        $id = $db->real_escape_string($_GET["board"]);
    }else{
        $errorTitle = "No board was found.";
        $errorMessage = "Sorry, no board was found.";
        require "engine/pages/error.php";
        die();
    }
    $board = $db->query("SELECT * FROM boards WHERE board_id='$id'")->fetch_assoc();
?>
<style>
    #purple_hover{
        transition:all 0.2s ease;
    }
    #purple_hover:hover{
        color:#6256a9;
    }
</style>
<h4><?=$board["board_title"]?> <a class="tooltipped" data-position="right" data-delay="50" data-tooltip="Click to go back" id="purple_hover" href="<?=url("admin/apps/boards/index.php")?>"><small>Board</small></a></h4>
<div class="extendable-row white-text" id="list_card_holder">
	

</div>


<script type="text/javascript">
	$(document).ready(function(){
        $('.materialboxed').materialbox();
        $('.tooltipped').tooltip({delay: 50});
		$("#modal_boards").css({
			'height': ($(document).height() * (90/100)) + "px",
			'max-height':'100%'
		});
        updateListUI();
        BoardControls();
        updateBoard(<?=$board["board_data"]?>);
	})
	function updateListUI(){
		$(".col-33").width($('.frame-article').width()/3 + "px")
		width_calculated = $(".col-33").width()
		$(".extendable-row").children().each(function(){
			width_calculated += $(this).width()
		})
		$(".extendable-row").width(width_calculated + "px")
	}

    card_list_new = `
    <div class="col-33 skipme">
		<div class="card color-<?=$board["board_color"]?>">
			<div class="card-content">
				<span class="card-title">Add New List</span>
			</div>
			<div class="card-content">
					<input id="newListName" class="list-item-input-white" type="text" />
					<div class="text-center" style="margin-top:10px;">
						<a id="newList" class="btn btn-floating color-blue waves-effect waves-light"><i class="material-icons">add</i></a>
					</div>
			</div>
		</div>
	</div>
    `

    card_list = `
    <div class="col-33">
        <div class="card color-<?=$board["board_color"]?>" list_id="{id}">
			<div class="card-content">
				<span class="card-title">{title}</span>
			</div>
			<ul class="collection black-text">
                {items}
				<li class="collection-item skipme">
					<input id="listItemValue" class="list-item-input" type="text" />
				</li>
				<li class="collection-item skipme">
					<div class="text-center">
						<a id="addItem" class="btn btn-floating color-blue waves-effect waves-light"><i class="material-icons">add</i></a>
					</div>
                </li>
                <li class="collection-item skipme">
					<div class="text-center">
						<a id="deleteList" class="btn btn-floating red waves-effect waves-light"><i class="material-icons">delete</i></a>
					</div>
				</li>
			</ul>
		</div>
    </div>
    `;
    card_list_item = `
        <li class="collection-item">
            {item}
            <a href="#" id="deleteItem" class="red-text secondary-content"><i class="material-icons">delete</i></a>
        </li>
    `;

    function parseTemplate(tpl, find, replace){
        return tpl.replace("{" + find + "}", replace);
    }

    function updateBoard(lists){
        raw_html = ""
        list_html = ""
        items_html = ""
        lists.forEach(list => {
            list_html = parseTemplate(parseTemplate(card_list, "title", list.title), "id", list.id);
            list.items.forEach(item => {
                items_html += parseTemplate(card_list_item, "item", item)
            });
            list_html = parseTemplate(list_html, "items", items_html)
            raw_html += list_html;
            list_html = ""
            items_html = "";
        });
        raw_html += card_list_new;
        $("#list_card_holder").html(raw_html)
    }

    function getBoardData(){
        lists = []
        $("#list_card_holder .col-33").each(function(i, element){
            $element = $(element)
            if($element.hasClass("skipme")) return 0;
            title = $(element).find(".card-title").html()
            id = $(element).find(".card").attr("list_id")
            items = []
            $(element).find(".collection-item").each(function(i, e){
                $e = $(e)
                if($e.hasClass("skipme") == false){
                    item = $e.clone().children().remove().end().text().trim().trim("\n").replaceAll("\n", " ").trim();
                    items.push(item);
                }else{
                }
            })
            list = {
                "id":id,
                "title":title,
                "items": items
            }
            lists.push(list)
        })
        return lists
    }
    function BoardControls(){
        $("body").on("click", "#addItem", function(e){
            $e = $(this);
            v = $e.parent().parent().parent().find("#listItemValue").val()
            if(v.trim() == ""){
                return 0;
            }
            length = $e.parent().parent().parent().children().length - 3;
            
            tpl = parseTemplate(card_list_item, "item", v)

            if(length == 0){
                $e.parent().parent().parent().prepend(tpl)
            }else
            $e.parent().parent().parent().children(":nth-child(" + (length) + ")").after(tpl);

            //$e.append();
            $e.parent().parent().parent().find("#listItemValue").val("")
            UpdateBoardOnline()
        })

        $("body").on("click", "#deleteItem", function(e){
            $e = $(this);
            v = $e.parent().remove();
            UpdateBoardOnline()
        })

        $("body").on("click", "#newList", function(e){
            title = $("#newListName").val()
            length = $("#list_card_holder .col-33").length;
            tpl = parseTemplate(parseTemplate(parseTemplate(card_list, "title", title), "items", ""), "id", length)
            if(length - 1 == 0){
                $("#list_card_holder").prepend(tpl);
            }else{
                $("#list_card_holder").children(":nth-child(" + (length - 1) + ")").after(tpl);
            }
            $("#newListName").val("");
            UpdateBoardOnline()
        })
        $("body").on("click", "#deleteList", function(e){
            $e = $(this);
            $e.parent().parent().parent().parent().parent().remove();
            UpdateBoardOnline()
        })
    }

    function UpdateBoardOnline(){
        list = JSON.stringify(getBoardData())
        data = {
            "board_id": '<?=$board["board_id"]?>',
            "board_update": list
        }
        $.post("<?=url() . "admin/apps/boards/api.php"?>", data, function(resp){
            console.log(resp)
        });
    }
</script>