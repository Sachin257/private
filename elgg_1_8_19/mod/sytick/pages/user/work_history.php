<?php
// make sure only logged in users can see this page
gatekeeper();

elgg_make_sticky_form('profile:edit');

$login_user_id = elgg_get_logged_in_user_guid();
$login_user =  get_entity($login_user_id);
$page_user_id = $page_user->guid;
$owner = get_entity($page_user_id);

// Edit restriction to other users

if (!$login_user || ($login_user->isBanned() && !elgg_is_admin_logged_in())) {
	register_error(elgg_echo('profile:notfound'));
	//echo "1";die("/profile/".$login_user->username);
	forward("/user/".$login_user->username);
}

if (!elgg_is_admin_logged_in() && ( $login_user_id != $page_user_id) ) {
	register_error(elgg_echo('profile:edit:fail'));
	//echo "2";die("/profile/".$login_user->username);
	forward("/user/".$login_user->username);
}
//echo $login_user_id."---".$page_user_id ."--".$owner;exit;
// Profile access restriction

$title = elgg_echo('profile:workhistory:title');

$content = elgg_view_title("<span>6</span> ".$title);

$vars = array();
$vars["entity"] = $login_user;
$vars["current_menu"] = $segments[1];


// add the form to this section
$content .= elgg_view("user/work_history", array(), $vars);

// optionally, add the content for the sidebar
$sidebar = elgg_view('user/sidebar', $vars);

// layout the page
$body = elgg_view_layout('one_sidebar', array('content' => $content,'sidebar'=>$sidebar));

// draw the page
echo elgg_view_page($title, $body);