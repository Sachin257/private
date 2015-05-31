<?php
// make sure only logged in users can see this page
gatekeeper();
// set the title
// for distributed plugins, be sure to use elgg_echo() for internationalization
global $inventory_types;


$title = elgg_echo('item:add');

// start building the main column of the page
$content = elgg_view_title($title);
$vars["inventory_types"] = $inventory_types;
// add the form to this section
$content .= elgg_view_form("inventory/save" , array(), $vars);
//print_r(elgg_view_form("paint/save"));exit;
// optionally, add the content for the sidebar
$sidebar = "";

// layout the page
$body = elgg_view_layout('one_column', array(
		'content' => $content
));

// draw the page
echo elgg_view_page($title, $body);
?>