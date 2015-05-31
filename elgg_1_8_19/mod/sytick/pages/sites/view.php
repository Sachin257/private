<?php

// need to restrict for company managers and admin
gatekeeper();

if(isset($segments[1])){
	$site = get_sites_by_name(($segments[1]));
} else if(get_input('guid')) {
	$site = get_entity((get_input('guid')));
}
if (! $site ) {
	register_error(elgg_echo('sites:error:not_found'));
	forward( REFERER);
}

$vars = array();
$vars["entity"] = $site;
$vars["company"] = get_entity($site->company_guid);
$vars["project"] = get_entity($site->project_guid);
$vars["employee"] = false;

$title = elgg_echo('sites:dashboard:title');


$content = elgg_view("sites/dashboard", $vars);

// layout the page
$body = elgg_view_layout('one_column', array('content' => $content));

// draw the page
echo elgg_view_page($title, $body);


