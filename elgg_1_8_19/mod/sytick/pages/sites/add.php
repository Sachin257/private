<?php
// need to restrict for company managers and admin
gatekeeper();
// set the title
$title = elgg_echo('sites:title:add');
$content = elgg_view_title($title);
if(elgg_is_admin_logged_in()){
	$company_id_values = get_companies_arr_list(CONSTRUCTION_TYPE_COMPANY);
	$vars["company_id_values"] = $company_id_values;
} else {
	$company = get_company_of_manager(elgg_get_logged_in_user_guid());
	$vars["company_id"] = ($company) ? $company->guid :0;
	$sitemanagers = get_employees_of_company_by_type($company->guid, SITE_MANAGER_PROFILE_TYPE);
	$sitemanager_id_values = array();
	if(count($sitemanagers))
	{
		foreach($sitemanagers as $sitemanager)
		{
			$sitemanager_id_values[$sitemanager->name] = $sitemanager->guid;
		}
	}
	$vars["sitemanager_id_values"] = $sitemanager_id_values;
	$projects = get_projects_of_company($company->guid);
	$projects_id_values = array();
	if(count($projects))
	{
		foreach($projects as $project)
		{
			$projects_id_values[$project->guid] = $project->title;
		}
	}
	$vars["projects_id_values"] = $projects_id_values;
}

$document_types = get_all_document_type();
$document_type_values = array();
foreach ($document_types as $document_type){
	// An array of all qualification types.
	$document_type_values[$document_type->title] = $document_type->guid;
}
$vars["document_type_values"] = $document_type_values;

// add the form to this section
$content .= elgg_view_form("sites/save", array("id"=>"frm_sites", 'enctype' => 'multipart/form-data'), $vars);

// layout the page
$body = elgg_view_layout('one_column', array('content' => $content));

// draw the page
echo elgg_view_page($title, $body);