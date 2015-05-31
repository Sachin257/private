<?php
//die("here");
// need to restrict for company managers and admin
gatekeeper();

$limit = get_input('limit', SYTICK_PAGINATION_LIMIT);
$offset = get_input('offset', 0);
$s = get_sanitised_input('s');

$title = elgg_echo('manager:title:list');
$add_link .= "&nbsp;".elgg_view('output/url', array(
		'href' => "/manager/add/",
		'text' => elgg_echo('manager:title:add'),
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
$manager_ids = array();
if($company_id) {
	$managers = get_manager_of_company($company_id);	
} else {
	$managers = get_users(MANAGER_PROFILE_TYPE);
}
if(count($managers)){
	foreach($managers as $_manager){
		$manager_ids[] = $_manager->guid;
	}
}
if(count($manager_ids)){
	if($s != "")
	{
		$manager_ids = get_user_search($s, join($manager_ids,",") );
		//print '<pre>';print_r($manager_ids );print '</pre>';exit;
	}
	if(count($manager_ids)){
		$count = get_workers(array(
				"guid"=> $manager_ids,
				'limit' => $limit,
				'offset' => $offset,
				'count' => TRUE,
		));
		$managers = get_workers(array(
				"guid"=> $manager_ids,
				'limit' => $limit,
				'offset' => $offset,
		));
		$pagination = elgg_view('navigation/pagination',array(
				'base_url' => 'manager/all',
				'offset' => $offset,
				'count' => $count,
				'limit' => $limit,
			));		
		
	} else {
		$managers = false;
		$pagination = "";
	
	}	
} else {
	$managers = false;
	$pagination = "";

}	
$body .= elgg_view('manager/list',array("managers"=>$managers));
$body .= $pagination;

$body = elgg_view_layout('one_column', array('title' => $body_title,'content' => $body));

echo elgg_view_page($title, $body);