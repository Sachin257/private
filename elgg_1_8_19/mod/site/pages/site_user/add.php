<?php
	// make sure only logged in users can see this page 
	gatekeeper();
	
	// set the title
	// for distributed plugins, be sure to use elgg_echo() for internationalization
	$title = elgg_echo('site:view:add_contractor');
	
	// start building the main column of the page
	$content = elgg_view_title($title);
	
	// Get the site entity from the id passed to the page.
	$site = get_entity(get_input("site_guid"));
	$organization = get_entity(get_input("organization_guid"));

	// add the form to this section
	$vars = array();
	$vars["site"] = $site;
	$vars["organization"] = $organization;	
	$content .= elgg_view_form("site_user/save", array(), $vars);
	
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
