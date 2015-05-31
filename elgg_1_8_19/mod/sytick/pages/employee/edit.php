<?php
// need to restrict for company managers and admin
gatekeeper();

elgg_make_sticky_form('profile:edit');

$employee = get_user_by_username_noaccess(($segments[1]));
if (! $employee ) {
	register_error(elgg_echo('profile:notfound'));
	forward( REFERER);
}

$login_user_id = elgg_get_logged_in_user_guid();
$login_user =  get_entity($login_user_id);

// Edit restriction to other users
if (!$employee || ($employee->isBanned() && !elgg_is_admin_logged_in())) {
	register_error(elgg_echo('profile:notfound'));
	//echo "1";die("/profile/".$login_user->username);
	forward();
}

//echo $login_user_id."---".$page_user_id ."--".$owner;exit;
// Profile access restriction
$vars = array();
$vars["entity"] = $employee;

$company = get_company_of_employee($employee->guid);
//print '<pre>';print_r($employee->guid);exit;
$vars["company_id"] = ($company) ? $company->guid :0;
if(! $vars['company_id'] )
{
	$profile_type_obj = get_user_profile_data($employee);
	if($profile_type_obj && $profile_type_obj->metadata_label)
	{
		$profile_type_label = $profile_type_obj->metadata_label;
		if($profile_type_label == CONTRACTOR_PROFILE_TYPE) {
			$vars["company_id_values"] = get_companies_arr_list(CONTRACTING_TYPE_COMPANY);
		} else {
			$vars["company_id_values"] = get_companies_arr_list(CONSTRUCTION_TYPE_COMPANY);
		}
	}
}

$title = elgg_echo('employee:edit:title');

$content = "";//elgg_view_title($title,array('class'=>"companytitle"));
$body_title = elgg_view_title($title ,array('class'=>"companytitle"));


// add the form to this section
$content .= elgg_view_form("employee/save", array(), $vars);


// layout the page
$body = elgg_view_layout('one_column', array('title' => $body_title, 'content' => $content));

// draw the page
echo elgg_view_page($title, $body);