<?php
// need to restrict for company managers and admin
gatekeeper();

if(isset($segments[1])){
	$site = get_sites_by_name(($segments[1]));
} else if(get_input('guid')) {
	$site = get_entity((get_input('guid')));
}
if (! $site ) {
	register_error(elgg_echo('sites:error:not_found'));
	forward( REFERER);
}

$vars = array();
$vars["entity"] = $site;

if(elgg_is_admin_logged_in()){
	$company_id_values = get_companies_arr_list(CONSTRUCTION_TYPE_COMPANY);
	$vars["company_id_values"] = $company_id_values;
} else {
	$company = get_company_of_manager(elgg_get_logged_in_user_guid());
	$vars["company_id"] = ($company) ? $company->guid :0;
}
$company_guid = ($site) ? $site->company_guid: $company->guid;
if($company_guid){
	$sitemanagers = get_employees_of_company_by_type($company_guid, SITE_MANAGER_PROFILE_TYPE);
	$sitemanager_id_values = array();
	if(count($sitemanagers))
	{
		foreach($sitemanagers as $sitemanager)
		{
			$sitemanager_id_values[$sitemanager->name] = $sitemanager->guid;
		}
	}
	$vars["sitemanager_id_values"] = $sitemanager_id_values;
	$projects = get_projects_of_company($company_guid);
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


$vars["current_sitemanagers"] = get_sites_current_sitesmanagers($site->guid);
$vars["current_documenttypes"] = get_sites_current_documenttype($site->guid);

$file = get_file_by_sites_guid($vars["entity"]->guid);
if($file && $file[0])
{
	$vars['file_guid'] = $file[0]->guid;
}

$title = elgg_echo('sites:title:edit');

// start building the main column of the page
$content = elgg_view_title($title,array('class'=>"companytitle"));

// add the form to this section
$content .= elgg_view_form("sites/save", array("id"=>"frm_sites", 'enctype' => 'multipart/form-data'), $vars);

// layout the page
$body = elgg_view_layout('one_column', array('content' => $content));

// draw the page
echo elgg_view_page($title, $body);
