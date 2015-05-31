<?php
// make sure only logged in users can see this page
gatekeeper();
// set the title
// for distributed plugins, be sure to use elgg_echo() for internationalization
global $inventory_types;
$vars["types"] = array_merge($inventory_types, array("paint" =>'paint'));
$vars["materials"]= array(""=> "select");
$title = elgg_echo('add:incoming:stock');
// start building the main column of the page
$content = elgg_view_title($title);

// add the form to this section
$content .= elgg_view_form("items/save",array(), $vars);
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