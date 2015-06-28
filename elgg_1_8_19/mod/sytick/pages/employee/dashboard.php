<?php
// make sure only logged in users can see this page
gatekeeper();
$title = elgg_echo('manager:dashboard:title');

$manager = get_user_by_username_noaccess($segments[0]);
if (! $manager ) {
	register_error(elgg_echo('profile:notfound'));
	forward( REFERER);
}
$company = get_company_of_employee($page_user->guid);
$company_id = ($company) ? $company->guid :0;

$vars = array();
//$vars["contracting"] = get_companies_by_type(CONTRACTING_TYPE_COMPANY, 5);
//$vars["constructing"] = get_companies_by_type(CONSTRUCTION_TYPE_COMPANY, 5);
//$vars["contactors"] = get_users_by_type(CONTRACTOR_PROFILE_TYPE, 5);
//$vars["projects"] = count(get_projects_of_company($company_id));

// add the form to this section
$content = elgg_view("employee/sytick_dashboard", $vars);

// layout the page
$body = elgg_view_layout('one_column', array('content' => $content));

// draw the page
echo elgg_view_page($title, $body);