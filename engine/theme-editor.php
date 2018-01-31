<?php

$theme = SiteSettings::get("WORKING_THEME");
$theme_settings = ThemeAPI::settings();
$theme_index = $theme_settings["index"]->file_name;
ThemeAPI::editMode();

ob_start();
require "content/themes/" . $theme . "/" . $theme_index;
$data = ob_get_contents();
ob_end_clean();

echo ThemeApi::refractPageDefaults($data, array_pop(ThemeAPI::getURLComponents()));

ThemeAPI::editMode(0);
