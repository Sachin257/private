<?php
// need to restrict for company managers and admin
gatekeeper();

elgg_make_sticky_form('profile:edit');

$manager = get_user_by_username_noaccess(($segments[1]));
if (! $manager ) {
	register_error(elgg_echo('profile:notfound'));
	forward( REFERER);
}

$login_user_id = elgg_get_logged_in_user_guid();
$login_user =  get_entity($login_user_id);

// Edit restriction to other users
if (!$manager || ($manager->isBanned() && !elgg_is_admin_logged_in())) {
	register_error(elgg_echo('profile:notfound'));
	//echo "1";die("/profile/".$login_user->username);
	forward();
}

//echo $login_user_id."---".$page_user_id ."--".$owner;exit;
// Profile access restriction
$title = elgg_echo('manager:edit:title');

$content = "";//elgg_view_title($title,array('class'=>"companytitle"));
$body_title = elgg_view_title($title ,array('class'=>"companytitle"));

$vars = array();
$vars["entity"] = $manager;
//print '<pre>';print_r($manager);exit;
$company = get_company_of_manager($manager->guid);
$vars["company_id"] = ($company) ? $company->guid :0;

// add the form to this section
$content .= elgg_view_form("manager/save", array(), $vars);


// layout the page
$body = elgg_view_layout('one_column', array('title' => $body_title, 'content' => $content));

// draw the page
echo elgg_view_page($title, $body);