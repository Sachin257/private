<?php

$title = elgg_echo('forgotpasssword:title');

$body = elgg_view_form("forgot_password");

$body = elgg_view_layout('one_column', array('content' => $body));

$vars = array();
$vars['class']= "hm_user";
echo elgg_view_page($title, $body,'default',$vars);