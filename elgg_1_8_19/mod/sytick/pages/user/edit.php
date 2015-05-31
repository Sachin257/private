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
// Profile access restriction

$title = elgg_echo('profile:edit:title');

$content = elgg_view_title("<span>1</span> ".$title);

$vars = array();
$vars["entity"] = $page_user;
$vars["current_menu"] = $segments[1];

$job_types = elgg_get_entities_from_metadata(array(
		'types' => 'object',
		'subtypes' => 'job_type',
		'limit' => ELGG_ENTITIES_NO_VALUE,
		'metadata_name_value_pairs'=>array(
				'name' => "is_deleted",
				'value' => 0,
				'operand' => '='
		),

));
$job_type_values = array();
foreach ($job_types as $job_type){
	// An array of all qualification types.
	$job_type_values[$job_type->guid] =$job_type->title;
}
$vars["job_type_values"] = $job_type_values;

$job_type_guids = get_job_type_guids($page_user_id);
$current_job_types = array();
//$current_job_types[$page_user_id]= 0;
foreach ($job_type_guids as $num7 => $job_typ_guid )
{
	$guid_job_type = $job_typ_guid->guid_one;
	$title_job_type = get_title_by_guid($guid_job_type);
	$current_job_types[$title_job_type[0]->title]= $guid_job_type;
}
$vars["current_job_types"] = $job_type_guids[0]->guid_one;
//print"<pre>";print_r($job_type_guids);exit;
// add the form to this section
$content .= elgg_view_form("user/save", array(), $vars);

// optionally, add the content for the sidebar
$sidebar = elgg_view('user/sidebar', $vars);

// layout the page
$body = elgg_view_layout('one_sidebar', array('content' => $content,'sidebar'=>$sidebar));

// draw the page
echo elgg_view_page($title, $body);


