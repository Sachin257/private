<?php
// make sure only logged in users can see this page
gatekeeper();


$limit = get_input('limit', STAD_PAGINATION_LIMIT);
$offset = get_input('offset', 0);
$s = get_sanitised_input('s');
if($segments[2])
{
    $offset = $segments[2];
}
//print_r($offset);exit;

$company_type = ($segments[1]) ? $segments[1] : 0;
$company_type_title =  (isset($segments[1]) && ($segments[1] == 2)) ?  elgg_echo('company:title:contracting') : elgg_echo('company:title:construction');
$base_url = '/company/all';
if($company_type == CONSTRUCTION_TYPE_COMPANY && elgg_is_admin_logged_in() ) 
{
	$title = elgg_echo('company:title:list', array($company_type_title));
	$add_link = elgg_view('output/url', array(
			'href' => "company/add/".CONSTRUCTION_TYPE_COMPANY,
			'text' => elgg_echo('company:title:add',array($company_type_title)),
			'class' => 'elgg-button elgg-button-add float-alt'
	));
	$base_url = '/company/all/'.CONSTRUCTION_TYPE_COMPANY;
} elseif($company_type == CONTRACTING_TYPE_COMPANY) {
	$title = elgg_echo('company:title:list', array($company_type_title));
	$add_link = elgg_view('output/url', array(
			'href' => "company/add/".CONTRACTING_TYPE_COMPANY,
			'text' => elgg_echo('company:title:add',array($company_type_title)),
			'class' => 'elgg-button elgg-button-add float-alt'
	));
	$base_url = '/company/all/'.CONTRACTING_TYPE_COMPANY;
} else {
	if( elgg_is_admin_logged_in() ) {
		$title = elgg_echo('company:title:list', array(''));
		$company_type_title =  elgg_echo('company:title:construction');
		$add_link = elgg_view('output/url', array(
				'href' => "company/add/".CONSTRUCTION_TYPE_COMPANY,
				'text' => elgg_echo('company:title:add',array($company_type_title)),
				'class' => 'elgg-button elgg-button-add float-alt'
		));
	}
	$company_type_title =  elgg_echo('company:title:contracting') ;	
	$add_link .= "&nbsp;".elgg_view('output/url', array(
			'href' => "company/add/".CONTRACTING_TYPE_COMPANY,
			'text' => elgg_echo('company:title:add',array($company_type_title)),
			'class' => 'elgg-button elgg-button-add float-alt'
	));	
}

$body ="";
$body_title = elgg_view_title($title ,array('class'=>"companytitle"));
$body = '<div class="title-button-container">' . $add_link . '</div>';

$search_arr = array();

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
	if($company->company_type == CONSTRUCTION_TYPE_COMPANY)
	{	
		if($company_type == CONSTRUCTION_TYPE_COMPANY)
		{
			$search_arr['guid'] = $company_id;
			$search_arr['company_type'] = CONSTRUCTION_TYPE_COMPANY;
		} else if($company_type == CONTRACTING_TYPE_COMPANY)
		{
			$search_arr['owner_guid'] = elgg_get_logged_in_user_guid();
			$search_arr['company_type'] = CONTRACTING_TYPE_COMPANY;
		}			
	} else if($company->company_type == CONTRACTING_TYPE_COMPANY)
	{
		$search_arr['guid'] = $company_id;
		$search_arr['company_type'] = CONTRACTING_TYPE_COMPANY;		
	}
} else {
	if($company_type)
	{
		$search_arr['company_type'] = $company_type;		
	}
}
         $search_arr['limit'] = ELGG_ENTITIES_NO_VALUE;
             
//print '<pre>';print_r($search_arr);print '</pre>';exit;
$companies = get_companies($search_arr);
//print '<pre>';print_r($companies);print '</pre>';exit;
if(count($companies)){
	foreach($companies as $_companies){
		$company_ids[] = $_companies->guid;
	}
}
//print '<pre>';print_r($company_ids);print '</pre>';exit;
if(count($company_ids)){
	if($s != "")
	{
		$company_ids = get_company_search($s, join($company_ids,",") );
		//print '<pre>';print_r($company_ids );print '</pre>';exit;
	}
    if(count($company_ids)){
    	$search_arr = array('count' => 1);
    	if($company_ids){
    		$search_arr['guid'] = $company_ids;
    	}
    	//print '<pre>';print_r($search_arr );print '</pre>';
    	$count = get_companies($search_arr);
    	$body  = '<div class="title-button-container">' . $add_link . '</div>';
		$search_arr = array('limit' => $limit,'offset' => $offset);
		if($company_ids){
			$search_arr['guid'] = $company_ids;
		}
		$companies = get_companies($search_arr);
		//print '<pre>';print_r($companies);print '</pre>';exit;
		$pagination = elgg_view('navigation/pagination',array(
				'base_url' => $base_url,
				'offset' => $offset,
				'count' => $count,
				'limit' => $limit,
		));
	} else {
		$companies = false;
		$pagination = "";	
	}
} else {
	$companies = false;
	$pagination = "";
}
if(!$company_type)
{
    $company_type = 0;
}
 
$body .= elgg_view('company/list',array("companies"=>$companies ,"company_type"=>$company_type, "offset" =>$offset));

$body .= $pagination;

$body = elgg_view_layout('one_column', array('title' => $body_title,'content' => $body));

echo elgg_view_page($title, $body);