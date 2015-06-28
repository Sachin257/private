<?php
// need to restrict for company managers and admin
gatekeeper();

$limit = get_input('limit', STAD_PAGINATION_LIMIT);
$offset = get_input('offset', 0);
$s = get_sanitised_input('s');

$title = elgg_echo('employee:list');
$add_link .= "&nbsp;".elgg_view('output/url', array(
		'href' => "/employee/add/",
		'text' => elgg_echo('employee:add'),
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
if($company_id) {	
	$employees = get_employees_of_company_by_type($company_id);
} else {
	$employees = get_users();
}
if(count($employees)){
	foreach($employees as $employee){
		$employee_ids[] = $employee->guid;
	}
}
if(count($employee_ids)){
	if($s != "")
	{
		$employee_ids = get_user_search($s, join($employee_ids,",") );
		//print '<pre>';print_r($manager_ids );print '</pre>';exit;
	}
	if(count($employee_ids)){               	
		$count = get_workers(array(
				"guid"=> $employee_ids,
				'limit' => $limit,
				'offset' => $offset,
				'count' => TRUE,
		));
		$_employees = get_workers(array(
				"guid"=> $employee_ids,
				'limit' => $limit,
				'offset' => $offset,
		));		
		$pagination = elgg_view('navigation/pagination',array(
				'base_url' => 'employee/all',
				'offset' => $offset,
				'count' => $count,
				'limit' => $limit,
			));
		
			
	} else {
		$_employees = false;
		$pagination = "";
	
	}
} else {
	$_employees = false;
	$pagination = "";

}	

$profile_type_arr = get_custom_profile_types();
$profile_type_values = array();
foreach($profile_type_arr as $profile_type){
	$profile_type_values[$profile_type['guid']] = $profile_type['label'];
}

$body .= elgg_view('employee/company_employee_list',array("employees"=>$_employees , "profile_type_values" => $profile_type_values));
$body .= $pagination;
$body = elgg_view_layout('one_column', array('title' => $body_title,'content' => $body));

echo elgg_view_page($title, $body);