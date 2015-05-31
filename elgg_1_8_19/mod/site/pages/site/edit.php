<?php
	// make sure only logged in users can see this page 
	gatekeeper();
	
	// set the title
	// for distributed plugins, be sure to use elgg_echo() for internationalization
	$title = elgg_echo('site:edit');
	// start building the main column of the page
	$content = elgg_view_title($title);
	
	// Get the site entity from the id passed to the page.
	$site = get_entity(intval($segments[1]));
	
	// Get the organization entity from the id passed to the page.
	$organization = get_entity(intval(get_input("organization_guid")));

	// add the form to this section
	$vars = array();
	$vars["entity"] = $site;	
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
