<?php

if (elgg_is_logged_in()) {
	forward();
}

$user_guid = base64_decode(get_input('k'));
$code = get_input('c');

$user = get_entity($user_guid);

// don't check code here to avoid automated attacks
if (!$user instanceof ElggUser) {
	register_error(elgg_echo('user:passwordreset:unknown_user'));
	forward();
}

$params = array(
		'guid' => $user_guid,
		'code' => $code,
);

$title = elgg_echo('activate_manager:title');

$body = elgg_view_form("activate_manager", array('class' => 'elgg-form-account'), $params);

$body = elgg_view_layout('one_column', array('content' => $body));

echo elgg_view_page($title, $body);