<?php
// make sure only logged in users can see this page
gatekeeper();

// permission system to be implemented
//die($segments[1]);
//print '<pre>';print_r($segments);exit;
$company = get_company_by_name(($segments[0]));
//print '<pre>';print_r($company);print '</pre>';exit;
if (! $company ) {
	register_error(elgg_echo('company:error:company_not_found'));
	forward( REFERER);
}

$title = $company->title." ".elgg_echo('company:dashboard:title');

$vars = array();
$vars["entity"] = $company;
if($company->company_type == CONSTRUCTION_TYPE_COMPANY) {
	$vars["projects"] = get_projects_of_company($company->guid, 5);
} else {
	$vars["projects"] = false;//get_projects_of_contract_company($company->guid);
}
$vars["employees"] = get_employees_of_company_by_type($company->guid, '', 5);
$vars["company_type"] = ($company) ? $company->company_type:0;
$profile_type_arr = get_custom_profile_types();
$profile_type_values = array();
foreach($profile_type_arr as $profile_type){
	$profile_type_values[$profile_type['guid']] = $profile_type['label'];
}
$vars["profile_type_values"] = $profile_type_values;

$content = elgg_view("company/dashboard", $vars);

// layout the page
$body = elgg_view_layout('one_column', array('content' => $content));

// draw the page
echo elgg_view_page($title, $body);