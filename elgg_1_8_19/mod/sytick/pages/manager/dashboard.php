<?php
// make sure only logged in users can see this page
gatekeeper();
$title = elgg_echo('manager:dashboard:title');

$manager = get_user_by_username_noaccess($segments[0]);
if (! $manager ) {
	register_error(elgg_echo('profile:notfound'));
	forward( REFERER);
}
$company = get_company_of_manager($page_user->guid);
if(!$company)
{
    $company = get_company_of_employee($page_user->guid);
}
if($company->company_type == 1)
{
$search_arr = array(
		'type' => 'object',
		'subtype' => 'company',
                'owner_guid'=>"$page_user->guid",
		'limit' => ELGG_ENTITIES_NO_VALUE
);
$search_arr['metadata_name_value_pairs'][] = array(
				'name' => "is_deleted",
				'value' => 0,
				'operand' => '='
		);
$companies = elgg_get_entities_from_metadata($search_arr);
$companies = count($companies);
}
if($company->company_type == 2)
{
    $companies = get_company_of_manager($page_user->guid);
    $companies = count($companies);
}



//echo $company->company_type;
//print '<pre>';print_r($companies);exit;
$company_id = ($company) ? $company->guid :0;

$vars = array();
//$vars["contracting"] = get_companies_by_type(CONTRACTING_TYPE_COMPANY, 5);
//$vars["constructing"] = get_companies_by_type(CONSTRUCTION_TYPE_COMPANY, 5);
//$vars["contactors"] = get_users_by_type(CONTRACTOR_PROFILE_TYPE, 5);
$vars["projects"] = count(get_projects_of_company($company_id));
$vars["company_type"] = ($company) ? $company->company_type:0;
$vars['no_of_companies'] = $companies;
$workers = get_employees_of_company($company->guid); 
$vars['workers'] = count($workers);
$count = 0;
foreach ($workers as $worker)
{
    if(!$worker->enabled)
    {
        $count = $count+ 1;
    }
}
$vars["workers_not_enabled"] = $count;

//print '<pre>';print_r($count);print "</pre>";exit;
// add the form to this section
$content = elgg_view("manager/sytick_dashboard", $vars);

// layout the page
$body = elgg_view_layout('one_column', array('content' => $content));

// draw the page
echo elgg_view_page($title, $body);

