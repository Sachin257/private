<?php
//die("here");
// need to restrict for company managers and admin
gatekeeper();

$limit = get_input('limit', STAD_PAGINATION_LIMIT);
$offset = get_input('offset', 0);
$s = get_sanitised_input('s');

$profile_type_arr = get_custom_profile_types(PROJECT_MANAGER_PROFILE_TYPE);
$profile_type_guid = ($profile_type_arr && isset($profile_type_arr['guid']) ) ? $profile_type_arr['guid'] :0;
$profile_type_label = ($profile_type_arr && isset($profile_type_arr['label']) ) ? $profile_type_arr['label'] :"";
$profile_type_name = ($profile_type_arr && isset($profile_type_arr['name']) ) ? $profile_type_arr['name'] :"";

$title = elgg_echo('project_manager:title:list');
$add_link .= "&nbsp;".elgg_view('output/url', array(
		'href' => "/employee/add/$profile_type_guid",
		'text' => elgg_echo('project_manager:title:add'),
		'class' => 'elgg-button elgg-button-add float-alt'
));

$body ="";
$body_title = elgg_view_title($title ,array('class'=>"companytitle"));
$body = '<div class="title-button-container">' . $add_link . '</div>';

$company_id  = 0;
if(!elgg_is_admin_logged_in()){
	$company = get_company_of_manager(elgg_get_logged_in_user_guid());
	$company_id = ($company) ? $company->guid :0;
}
$project_manager_ids = array();
if($company_id) {
	$project_managers = get_employees_of_company_by_type($company_id, PROJECT_MANAGER_PROFILE_TYPE);
} else {
	$project_managers = get_users(PROJECT_MANAGER_PROFILE_TYPE);
}
if(count($project_managers)){
	foreach($project_managers as $_project_manager){
		$project_manager_ids[] = $_project_manager->guid;
	}
}
//print '<pre>';print_r($project_manager_ids);print '</pre>';exit;
if( count($project_manager_ids) ) {
	if($s != "")
	{
		$project_manager_ids = get_user_search($s, join($project_manager_ids,",") );
		//print '<pre>';print_r($manager_ids );print '</pre>';exit;
	}
	if( count($project_manager_ids) ) {
		$count = get_workers(array(
				"guid"=> $project_manager_ids,
				'limit' => $limit,
				'offset' => $offset,
				'count' => TRUE,
		));
		$employees = get_workers(array(
				"guid"=> $project_manager_ids,
				'limit' => $limit,
				'offset' => $offset,
		));
		$pagination = elgg_view('navigation/pagination',array(
				'base_url' => 'project_manager/all',
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