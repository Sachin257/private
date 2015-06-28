<?php
admin_gatekeeper();

elgg_make_sticky_form('profile:edit');

$employee = get_entity($segments[1]);
if (! $employee ) {
	register_error(elgg_echo('profile:notfound'));
	forward( REFERER);
}

// Edit restriction to other users
if (elgg_instanceof($employee, 'object', 'employee') && $employee->canEdit()) {
    
} else {
            register_error(elgg_echo('employee:error:cannot_edit'));
            forward("/employee");
}

$vars = array();
$vars["entity"] = $employee;

$title = elgg_echo('employee:edit:title');

$content = "";

$body_title = elgg_view_title($title ,array('class'=>"companytitle"));

$content .= elgg_view_form("employee/save", array(), $vars);

$body = elgg_view_layout('one_column', array('title' => $body_title, 'content' => $content));

echo elgg_view_page($title, $body);