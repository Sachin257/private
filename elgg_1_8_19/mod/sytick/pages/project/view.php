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
$vars["company"] = get_entity($project->company_guid);
$vars["manager"] = get_entity($project->manager_guid);
$vars["sites"] = get_sites_of_projects ( $project->guid, 5);

$profile_type_arr = get_custom_profile_types();
$profile_type_values = array();
foreach($profile_type_arr as $profile_type){
	$profile_type_values[$profile_type['guid']] = $profile_type['label'];
}

//$vars["employees"] = get_employees_of_projects ( $project->guid);

$title = elgg_echo('project:dashboard:title');
//print "<pre>";print_r($vars['contracting_companies']) ;print "</pre>"; exit;

$content = elgg_view("project/dashboard", $vars);
$content .= elgg_view_form("project_workers/workers_add", array('id'=>"ftm_add_workers"), $vars);

// layout the page
$body = elgg_view_layout('one_column', array('content' => $content));

// draw the page
echo elgg_view_page($title, $body);