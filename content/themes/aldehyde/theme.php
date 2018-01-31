<?php

$theme = array(
	"name" => "Aldehyde",
	"nickname" => "Aldehyde",
	"description" => "A basic theme with simple blog functionality. This emerald blue shaded is ready for boosting your business by presenting content in skeuographic webpages.",
	"author" => "Sampan Verma",
	"author_url" => "http://sampan.me",
	"theme_url" => "http://sampan.me/themes/aldehyde",
	"index"=> Theme::File("index.php"),
	"error"=> Theme::File("error.php"),
	"pages"=>array(
		Theme::Page("Post", "post", "note_add", true, array(
			Theme::Options("Views", "0", ThemeOptNumber),
			Theme::Options("Page Title", "Lorem Ipsum dolor sit amet", ThemeOptText),
			Theme::Options("Page Description", "", ThemeOptText),
			Theme::Options("Featured Image (960x360)", Theme::URL("assets/agora/dolly.jpg", true), ThemeOptText),
			Theme::Options("Thumbnail Image (800x450)", "", ThemeOptText),
		)),
		Theme::Page("Posts List", "list", "star_border", false, array(
			Theme::Options("Search Tag", "", ThemeOptText),
			Theme::Options("Page Title", "Lorem Ipsum dolor sit amet", ThemeOptText),
			Theme::Options("Page Description", "", ThemeOptText),
			Theme::Options("Featured Image (960x360)", Theme::URL("assets/agora/dolly.jpg", true), ThemeOptText),
			Theme::Options("Thumbnail Image (800x450)", "", ThemeOptText),
		)),
	),
	"menus"=>array(
		Theme::Menu("Almanac"),
		Theme::Menu("Footer"),
	),
	"screenshot"=> Theme::File("screenshot.jpg"),
	"settings"=>array(
		Theme::Options("Footer Description", "", ThemeOptText),
		Theme::Options("Facebook Link", "", ThemeOptText),
		Theme::Options("Twitter Link", "", ThemeOptText),
		Theme::Options("Instagram Link", "", ThemeOptText),
		Theme::Options("Tumblr Link", "", ThemeOptText),
		Theme::Options("SoundCloud Link", "", ThemeOptText),
		Theme::Options("LinkedIn Link", "", ThemeOptText),
		Theme::Options("Google Plus Link", "", ThemeOptText),
		Theme::Options("Behance Link", "", ThemeOptText),
	),
	"editable-js"=>array(Theme::File("assets/agora/script-editor.js"))
);