<?php

$title = elgg_echo('registration:success');

$body = elgg_view_form("resend_validation");

$body = elgg_view_layout('one_column', array('content' => $body));

echo elgg_view_page($title, $body , 'default', array("class" => "hm_user"));
