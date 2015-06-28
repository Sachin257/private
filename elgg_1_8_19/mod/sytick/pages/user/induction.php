<?php
// make sure only logged in users can see this page
gatekeeper();

elgg_load_js('twitter_bootstrap.fancybox');
elgg_load_css('twitter_bootstrap.fancybox');
elgg_load_js('lessonviewer.bootbox');

$limit = get_input('limit', STAD_PAGINATION_LIMIT);
$offset = get_input('offset', 0);

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

$title = elgg_echo('profile:induction:title');

$content = elgg_view_title("<span>5</span> ".$title);

//$induction_ids = get_users_induction($page_user_id);
$induction_ids = get_employees_induction($page_user);
//print '<pre>';print_r($induction_ids);echo '</pre>'.count($induction_ids);exit;
if(is_array($induction_ids) && count($induction_ids)){
	$count = get_inductions(array(
									"guid"=> $induction_ids,
									'limit' => $limit,
									'offset' => $offset,			
									'induction_status' => 1,
									'count' => TRUE,
							));
	$inductions = get_inductions(array(
										"guid"=> $induction_ids,
										'limit' => $limit,
										'offset' => $offset,
										'induction_status' => 1,
								));
	$pagination = elgg_view('navigation/pagination',array(
									'base_url' => "/user/".$page_user->username."/induction",
									'offset' => $offset,
									'count' => $count,
									'limit' => $limit,
							));
}	else {
	$inductions = false;
	$pagination = "";

}

$vars = array();
$vars["entity"] = $page_user;
$vars["current_menu"] = $segments[1];
$vars["inductions"] = $inductions;
//print "<pre>";print_r($vars);exit;
// add the form to this section
$content .= elgg_view("user/induction", $vars);
$content .= $pagination;
// optionally, add the content for the sidebar
$sidebar = elgg_view('user/sidebar', $vars);

// layout the page
$body = elgg_view_layout('one_sidebar', array('content' => $content,'sidebar'=>$sidebar));

// draw the page
echo elgg_view_page($title, $body);