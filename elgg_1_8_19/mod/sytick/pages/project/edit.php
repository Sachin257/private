<?php
// need to restrict for company managers and admin
gatekeeper();

if(isset($segments[1])){
	$project = get_project_by_name(($segments[1]));
} else if(get_input('guid')) {
	$project = get_entity((get_input('guid')));
}
if (! $project ) {
	register_error(elgg_echo('project:error:not_found'));
	forward( REFERER);
}

$vars = array();
$vars["entity"] = $project;


$title = elgg_echo('project:title:edit');

$body_title = elgg_view_title($title ,array('class'=>"companytitle"));

$content = "";//elgg_view_title($title,array('class'=>"companytitle"));

// add the form to this section
$content .= elgg_view_form("project/save", array("id"=>"frm_project", 'enctype' => 'multipart/form-data'), $vars);

// layout the page
$body = elgg_view_layout('one_column', array('title' => $body_title, 'content' => $content));

// draw the page
echo elgg_view_page($title, $body);
