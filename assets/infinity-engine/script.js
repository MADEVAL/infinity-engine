// EVENT HANDLERS
String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};

$(document).ready(function(){
	frame_create();
	inbox_create();
	searchbox_create();
	button_cards_create();
	dropbox_create();
	flexible_cards_create();
	$('.tooltipped').tooltip({delay: 50});
	$('.modal').modal();
});
$(window).on("resize", function(){
	frame_refresh();
	inbox_refresh();
	searchbox_refresh();
	button_cards_refresh();
	dropbox_refresh();
});

// EVENTS
function frame_create(){
	frame_height = $(".frame").height()
	dx_height = 70;
	new_height = frame_height - dx_height;
	$(".frame").height( new_height + "px");
}
function frame_refresh(){
	frame_height = $(".frame").height()
	dx_height = 70; // Navigation Bar - 70px
	document_height = $(window).height();
	new_height = document_height - dx_height;
	$(".frame").height( new_height + "px");
}
function inbox_create(animSpeed = 1000){
	document_height = $(window).height();

	// For friendlist
	dx_height = 70 + 11.5 + 70 + 11.5 + 15 + 5;
	new_height = document_height - dx_height;
	$(".inbox .friendlist .users").height(new_height)

	// For ChatLog
	//dx_height = 70 + 11.5 + $(".inbox .chat .user").height() + $(".inbox .chat .form").height() + 11.5 + 15 + 5;
	dx_height = 70 + 11.5 + $(".inbox .chat .user").height() + 20 + $(".inbox .chat .form").height() + 20 + 1 + 11.5 + 20 + 20 + 10;
	new_height = document_height - dx_height;
	$(".inbox .chat .chatlog").height(new_height)

	//$('.inbox .chat .chatlog').scrollTop($('.inbox .chat .chatlog').prop("scrollHeight"));;
	$(".inbox .chat .chatlog").animate({ scrollTop: $('.inbox .chat .chatlog').prop("scrollHeight")}, animSpeed);
}
function inbox_refresh(animSpeed = 1000){
	inbox_create(animSpeed);
}

function searchbox_create(){
	$("#searchbar").focus(function(){
		$(".searchbox").addClass("active");
		$(".searchbox .search_form").focus();
		$(".results").html("");
		$(".searchbox .search_form").val("");
	});
	$(".searchbox .search_form").focusout(function(){
		setTimeout(function(){
			$(".searchbox").removeClass("active");
		}, 1000)
	});
}
function searchbox_refresh(){
	$("#searchbox").height($(window).height() + "px");
	$("#searchbox").width($(window).width() + "px");
}
function button_cards_create(){
	$(".card-button").each(function(){
		$(this).css({
			"height": $(this).width() + "px",
			"line-height": $(this).width() + "px"
		});
	});

	$(".card-button-2").each(function(){
		$(this).css({
			"line-height": $(this).height() + "px"
		});
	});
}
function button_cards_refresh(){
	button_cards_create();
}
function dropbox_create(){
	$(".dropbox").css({
		"line-height":$(".dropbox").height()+"px"
	})
}
function dropbox_refresh(){
	dropbox_create()
}
function flexible_cards_create(){
	$(".flexible-cards").each(function(){
		row_height = $(this).height()
		$(this).children(".card-flexible").each(function(){
			$(this).height(row_height + "px")
		})
	});
}
function flexible_cards_refresh(){
	$(".flexible-cards").each(function(){
		$(this).children(".card-flexible").height($(this).height());
	});
}