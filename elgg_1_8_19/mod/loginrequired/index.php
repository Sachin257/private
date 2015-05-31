<?php
/**
 * Elgg index page for web-based applications
 *
 * @package Elgg
 * @subpackage Core
 */

//grab the login form
/*$login = elgg_view("core/account/login_box");

$params = array(
		'login'  => $login
);*/

$register = elgg_view("forms/register");

$params = array(
		'register'  => $register
);
$body = elgg_view_layout('loginrequired_index', $params);
$user = elgg_get_logged_in_user_guid();
$vars = array();
if(!$user)
    {
        $vars['class']= "hm_user";
    }
echo elgg_view_page(null, $body,'default',$vars);
