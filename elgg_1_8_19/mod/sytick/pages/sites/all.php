<?php
// need to restrict for company managers and admin
gatekeeper();
// set the title
$title = elgg_echo('sites:title:list');

$limit = get_input('limit', SYTICK_PAGINATION_LIMIT);
$offset = get_input('offset', 0);
$s = get_sanitised_input('s');

if($segments[1])
{
  $offset =  $segments[1];
}
// start building the main column of the page
$add_link .= "&nbsp;".elgg_view('output/url', array(
		'href' => "/sites/add/",
		'text' => elgg_echo('sites:title:add'),
		'class' => 'elgg-button elgg-button-add float-alt'
));
$body_title = elgg_view_title($title . '<div class="title-button-container">' . $add_link . '</div>',array('class'=>"companytitle"));
$content = elgg_view_title($body_title);
$company_id  = 0;
if(!elgg_is_admin_logged_in()){
	$company = get_company_of_manager(elgg_get_logged_in_user_guid());
	$company_id = ($company) ? $company->guid :0;
}
//print '<pre>';print_r($company_id );print '</pre>';exit;
$site_ids = array();
if($company_id) {
	$sites = get_sites_of_company($company_id);
} else {
	$sites = get_sites();
}
//print '<pre>';print_r($sites );print '</pre>';exit;
if(count($sites)){
	foreach($sites as $_site){
		$site_ids[] = $_site->guid;
	}
}
//print '<pre>';print_r($site_ids );print '</pre>';exit;
if(count($site_ids)){
	if($s != "")
	{
		$site_ids = get_sites_search($s, join($site_ids,",") );
		//print '<pre>';print_r($site_ids );print '</pre>';exit;
	}
	if(count($site_ids)){
		$options = array(
				'type' => 'object',
				'subtype'=>'sites',
				'guid' => $site_ids,
				'limit' => $limit,
				'offset' => $offset,
				'count' => TRUE,
		);
		if(! elgg_is_admin_logged_in())
		{
			$options['metadata_name_value_pairs'][] = array(
					'name' => "is_deleted",
					'value' => 0,
					'operand' => '='
			);
		}
		$count = elgg_get_entities_from_metadata($options);
		$body ="";

		$options = array(
				'type' => 'object',
				'subtype'=>'sites',
				'guid' => $site_ids,
				'limit' => $limit,
				'offset' => $offset,
		);
		if(! elgg_is_admin_logged_in())
		{
			$options['metadata_name_value_pairs'][] = array(
					'name' => "is_deleted",
					'value' => 0,
					'operand' => '='
			);
		}
		$sites = elgg_get_entities_from_metadata($options);

		$pagination = elgg_view('navigation/pagination',array(
				'base_url' => '/sites/all',
				'offset' => $offset,
				'count' => $count,
				'limit' => $limit,
		));
	} else {
		$sites = false;
		$pagination = "";

	}
} else {
	$sites = false;
	$pagination = "";

}

$body .= elgg_view('sites/list',array("sites"=>$sites, "offset"=>$offset));
$body .= $pagination;


$body = elgg_view_layout('one_column', array('title' => $body_title,'content' => $body));

echo elgg_view_page($title, $body);
