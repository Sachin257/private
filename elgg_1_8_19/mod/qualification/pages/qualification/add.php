<?php
	elgg_load_library('elgg:file');	

	// make sure only logged in users can see this page 
	gatekeeper();
	// set the title
	// for distributed plugins, be sure to use elgg_echo() for internationalization
	$title = elgg_echo('qualification:add');
	 
	// start building the main column of the page
	$content = elgg_view_title($title);
	 
	// add the form to this section
	$form_vars = array('enctype' => 'multipart/form-data');
	$body_vars = file_prepare_form_vars();	
	$body_vars["default_qualification_type_guid"] = get_input('qualification_type_guid');

	$content .= elgg_view_form("qualification/save", $form_vars, $body_vars);
	 
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