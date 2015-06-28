<?php
// make sure only admin can see this page
admin_gatekeeper();
// set the title
$title = elgg_echo('employee:add');

// start building the main column of the page
$content = elgg_view_title($title);

$content .= elgg_view_form("employee/save");

$sidebar = "";

$body = elgg_view_layout('one_column', array(
		'content' => $content
));

echo elgg_view_page($title, $body);
?>