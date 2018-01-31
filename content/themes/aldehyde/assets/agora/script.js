$(document).ready(function(){
	onLoadAndResize();
	$(".page-height").resize(onLoadAndResize)
	$(".post").each(function(){
		img = $(this).children(".post-image")
		desc = $(this).children(".post-desc")
		ih = img.height()
		dh = desc.height()
	})

  	$('.dropdown-button').dropdown({
		inDuration: 300,
		outDuration: 225,
		constrainWidth: false, // Does not change width of dropdown to that of the activator
		hover: false, // Activate on hover
		gutter: 0, // Spacing from edge
		belowOrigin: true, // Displays dropdown below the button
		alignment: 'left', // Displays dropdown with edge aligned to the left of button
		stopPropagation: false // Stops event propagation
	});
});

function loadContentTools() {
	var editor;
	editor = ContentTools.EditorApp.get();
	editor.init('*[data-editable]', 'data-name');
};

function onLoadAndResize(){
	$(".image-title").each(function(){
		vignette = $(this).children(".image-vignette")
		src = $(this).children(".image-src")
		image_width = src.width()
		image_height = src.height()
		vignette.css({
			height: image_height + "px",
			width : image_width  + "px",
		})
	})
	page_height = $(".page").height();
	$(".page-height").css({
		height:page_height
	})
}