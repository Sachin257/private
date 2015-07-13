<?php
// make sure only logged in users can see this page
gatekeeper();
$title = elgg_echo('manager:dashboard:title');

$office = get_user_by_username_noaccess($segments[0]);
if (! $office ) {
	register_error(elgg_echo('profile:notfound'));
	forward( REFERER);
}
$vars = array();
// add the form to this section
$content = elgg_view("employee/sytick_dashboard", $vars);

// layout the page
$body = elgg_view_layout('one_column', array('content' => $content));

// draw the page
echo elgg_view_page($title, $body);