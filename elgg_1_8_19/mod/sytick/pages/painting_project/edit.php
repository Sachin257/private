<?php

// make sure only logged in users can see this page 
gatekeeper();

// set the title
// for distributed plugins, be sure to use elgg_echo() for internationalization
$title = elgg_echo('painting_project:edit');
// start building the main column of the page
$content = elgg_view_title($title);

// Get the qualification entity from the id passed to the page.
$paint = get_entity(intval($segments[1]));
$vars = array();
$vars["entity"] = $paint;
$vars["material_id_values"] = get_material_type_id_values();
// add the form to this section			
$content .= elgg_view_form("painting_project/save", array(), $vars);

// optionally, add the content for the sidebar
$sidebar = "";

// layout the page
$body = elgg_view_layout('one_column', array('content' => $content));

// draw the page
echo elgg_view_page($title, $body);
?>