<?php
	// make sure only logged in users can see this page 
	gatekeeper();
	
	// set the title
	// for distributed plugins, be sure to use elgg_echo() for internationalization
	$title = elgg_echo('organizations:title:edit_organization');
	 
	// start building the main column of the page
	$content = elgg_view_title($title);
	
	// Get the lesson entity from the id passed to the page.
	$organization = get_organization_by_guid(intval($segments[1]));
	if ($organization === false) {
		register_error(elgg_echo('organizations:message:organization_not_found'));
		forward(get_input('forward', REFERER));
	}
	
	$vars = array();
	$vars["entity"] = $organization;
	
	elgg_push_breadcrumb(elgg_echo('breadcrumb:organizations'), '/organizations/all');
	elgg_push_breadcrumb(elgg_echo($organization->title), '/organizations/view/' . $organization->guid);
	elgg_push_breadcrumb(elgg_echo('breadcrumb:edit_organization_info'));
		
	// add the form to this section
	$content .= elgg_view_form("organizations/save", array(), $vars);
	
	// optionally, add the content for the sidebar
	$sidebar = "";
	 
	// layout the page
	$body = elgg_view_layout('one_column', array('content' => $content));
	
	// draw the page
	echo elgg_view_page($title, $body);
?>