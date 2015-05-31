<?php
//die("here");
// need to restrict for company managers and admin
gatekeeper();

$limit = get_input('limit', SYTICK_PAGINATION_LIMIT);
$offset = get_input('offset', 0);
$s = get_sanitised_input('s');

$profile_type_arr = get_custom_profile_types(SECURITY_PERSON_PROFILE_TYPE);
$profile_type_guid = ($profile_type_arr && isset($profile_type_arr['guid']) ) ? $profile_type_arr['guid'] :0;
$profile_type_label = ($profile_type_arr && isset($profile_type_arr['label']) ) ? $profile_type_arr['label'] :"";
$profile_type_name = ($profile_type_arr && isset($profile_type_arr['name']) ) ? $profile_type_arr['name'] :"";

$title = elgg_echo('securityperson:title:list');
$add_link .= "&nbsp;".elgg_view('output/url', array(
		'href' => "/employee/add/$profile_type_guid",
		'text' => elgg_echo('securityperson:title:add'),
		'class' => 'elgg-button elgg-button-add float-alt'
));

$body ="";
$body_title = elgg_view_title($title ,array('class'=>"companytitle"));
$body = '<div class="title-button-container">' . $add_link . '</div>';

$company_id  = 0;
if(!elgg_is_admin_logged_in()){
	$page_user = elgg_get_logged_in_user_entity();
	$user_profile_type = get_custom_profile_types($page_user->custom_profile_type,'guid');
	$user_profile_type_label = ($user_profile_type && isset($user_profile_type['label'])) ? $user_profile_type['label'] : "";
	if($user_profile_type_label == MANAGER_PROFILE_TYPE)
	{
		$company = get_company_of_manager($page_user->guid);
		$company_id = ($company) ? $company->guid :0;
	} else {
		$company = get_company_of_employee($page_user->guid);
		$company_id = ($company) ? $company->guid :0;
	}
}
$security_person_ids = array();
if($company_id) {
	//$inductionmanagers = get_inductionmanager_of_company($company_id);
	$security_persons = get_employees_of_company_by_type($company_id, SECURITY_PERSON_PROFILE_TYPE);
} else {
	$security_persons = get_users(SECURITY_PERSON_PROFILE_TYPE);
}
if(count($security_persons)){
	foreach($security_persons as $_security_persons){
		$security_person_ids[] = $_security_persons->guid;
	}
}

if(count($security_person_ids)){
	if($s != "")
	{
		$security_person_ids = get_user_search($s, join($security_person_ids,",") );
		//print '<pre>';print_r($manager_ids );print '</pre>';exit;
	}
	if(count($security_person_ids)){
		$count = get_workers(array(
				"guid"=> $security_person_ids,
				'limit' => $limit,
				'offset' => $offset,
				'count' => TRUE,
		));
		$employees =  get_workers(array(
				"guid"=> $security_person_ids,
				'limit' => $limit,
				'offset' => $offset,
		));
		$pagination = elgg_view('navigation/pagination',array(
				'base_url' => 'security_person/all',
				'offset' => $offset,
				'count' => $count,
				'limit' => $limit,
			));
		
			
	} else {
		$employees = false;
		$pagination = "";
	
	}
} else {
	$employees = false;
	$pagination = "";

}	

$body .= elgg_view('employee/list',array("employees"=>$employees,'role'=>$profile_type_label,"role_name" => $profile_type_name));
$body .= $pagination;
$body = elgg_view_layout('one_column', array('title' => $body_title,'content' => $body));

echo elgg_view_page($title, $body);