<?php

// make sure only logged in users can see this page
admin_gatekeeper();
$title = elgg_echo('admin:dashboard:title');
$vars["painting_projects"] = get_number_of_painting_projects();
$options = array(
    'type' => 'object',
    'subtype' => 'project',
    'count' => TRUE,
);
$vars["projects"] = elgg_get_entities_from_metadata($options);
$options = array(
    'type' => 'object',
    'subtype' => 'paint',
    'count' => TRUE,
);
$vars["paints"] = elgg_get_entities_from_metadata($options);

$content = elgg_view("admin/sytick_dashboard", $vars);
// layout the page
$body = elgg_view_layout('one_column', array('content' => $content));
// draw the page
echo elgg_view_page($title, $body);

