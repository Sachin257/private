<?php
/**
 * View a qualification
 */
$qualification = get_entity(intval($segments[1]));

if (!$qualification) {
	register_error(elgg_echo('noaccess'));
	$_SESSION['last_forward_from'] = current_page_url();
	forward('');
}

$content = elgg_view_entity($qualification, array('full_view' => true));

$content .= elgg_view_comments($qualification);

$body = elgg_view_layout('content', array(
	'content' => $content,
	'sidebar' => $side_bar,
	'title' => $title,
	'filter' => '',
));

echo elgg_view_page($title, $body);
