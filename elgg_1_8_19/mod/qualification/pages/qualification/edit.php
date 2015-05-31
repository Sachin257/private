<?php
	elgg_load_library('elgg:file');

	// make sure only logged in users can see this page 
	gatekeeper();
	
	// set the title
	// for distributed plugins, be sure to use elgg_echo() for internationalization
	$title = elgg_echo('qualification:edit');
	// start building the main column of the page
	$content = elgg_view_title($title);
	
	// Get the qualification entity from the id passed to the page.
	$qualification = get_entity(intval($segments[1]));
	$vars = array();
	$vars["entity"] = $qualification;
	$body_vars = file_prepare_form_vars();
	
	// add the form to this section			
	$content .= elgg_view_form("qualification/save", array('enctype' => 'multipart/form-data'), $vars);
	
	// optionally, add the content for the sidebar
	$sidebar = "";
	 
	// layout the page
	$body = elgg_view_layout('one_column', array(
	   'content' => $content,
	));
	
	// draw the page
	echo elgg_view_page($title, $body);
?>
