<?php
	// make sure only logged in users can see this page 
	gatekeeper();
	// set the title
	// for distributed plugins, be sure to use elgg_echo() for internationalization
	$title = elgg_echo('site:add');

	// Get the organization entity from the id passed to the page.
	$organization = get_entity(intval($segments[1]));
	// add the form to this section
	$vars = array();
	$vars["organization"] = $organization;	
	$content .= elgg_view_form("site/save", array(), $vars);
	 
	// optionally, add the content for the sidebar
	$sidebar = "";
	 
	// layout the page
	$body = elgg_view_layout('one_column', array(
	   'content' => $content,
	   'sidebar' => $sidebar
	));
	
	// draw the page
	echo elgg_view_page($title, $body);
?>