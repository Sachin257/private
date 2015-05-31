<?php
// make sure only logged in users can see this page
admin_gatekeeper();
$title = elgg_echo('admin:dashboard:title');


$vars = array();
$contracting_active = get_number_of_companies_by_type(CONTRACTING_TYPE_COMPANY);
$contracting_in_active = get_companies_by_type(CONTRACTING_TYPE_COMPANY, 0, 0);
$params = array('company_type'=>CONTRACTING_TYPE_COMPANY, 'limit'=>ELGG_ENTITIES_NO_VALUE);
$contracting_companies = get_companies($params);
$vars["contracting_active"] = $contracting_active;
$vars["contracting_in_active"] = count_inactive_companies($contracting_companies);
$constructing_active = get_number_of_companies_by_type(CONSTRUCTION_TYPE_COMPANY);
$constructing_in_active = get_companies_by_type(CONSTRUCTION_TYPE_COMPANY, 0, 0);
$params = array('company_type'=>CONSTRUCTION_TYPE_COMPANY, 'limit'=>ELGG_ENTITIES_NO_VALUE);
	//print '<pre>';print_r(get_companies($params));exit;
$construction_companies = get_companies($params);
$vars["constructing_active"] = $constructing_active;
$vars["constructing_in_active"] = count_inactive_companies($construction_companies);
//exit;
$active_contractor = get_users_by_type(CONTRACTOR_PROFILE_TYPE, ELGG_ENTITIES_NO_VALUE,'yes'); 
//$in_active_contractor = get_users_by_type(CONTRACTOR_PROFILE_TYPE, 5,'no');
$vars["active_contractor"] = count($active_contractor);
$vars["in_active_contractor"] = get_unvalidated_user_count(CONTRACTOR_PROFILE_TYPE);


// add the form to this section
$content = elgg_view("admin/sytick_dashboard", $vars);

// layout the page
$body = elgg_view_layout('one_column', array('content' => $content));

// draw the page
echo elgg_view_page($title, $body);

