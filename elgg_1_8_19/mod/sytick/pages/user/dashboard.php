<?php
// make sure only logged in users can see this page
gatekeeper();

elgg_make_sticky_form('profile:edit');

$login_user_id = elgg_get_logged_in_user_guid();
$login_user =  get_entity($login_user_id);
$page_user_id = $page_user->guid;

// Edit restriction to other users

if (!$page_user || ($page_user->isBanned() && !elgg_is_admin_logged_in())) {
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

// Profile access restriction - stilltobeimplemented

$title = elgg_echo('profile:dashboard:title');


$vars = array();
$vars["entity"] = $page_user;
$vars["current_menu"] = $segments[1];
$vars["certificates"] = get_certificate_by_type(0, $page_user->guid,5);

$projects_arr = array();
$projects = get_users_projects($page_user_id);
foreach($projects as $project)
{
    $projects_arr[$project->guid]['name'] = $project->title;
    $company = get_company_of_project($project->guid);
    //print "<pre>";print_r($company);exit;
    $projects_arr[$project->guid]['company']= $company[0]->description;
}
$vars['projects'] = $projects_arr;
//print "<pre>";print_r($projects_arr);exit;

// add the form to this section
$content = elgg_view("user/dashboard/personal", $vars);
//$content .= elgg_view("user/dashboard/alerts", $vars);
//$content .= elgg_view("user/dashboard/certification", $vars);
//$content .= elgg_view("user/dashboard/sites", $vars);

// layout the page
$body = elgg_view_layout('one_column', array('content' => $content));

// draw the page
echo elgg_view_page($title, $body);

//check

