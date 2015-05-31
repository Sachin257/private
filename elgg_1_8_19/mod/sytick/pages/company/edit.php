<?php
// make sure only logged in users can see this page
gatekeeper();

// Get the entity from the id passed to the page.
//print '<pre>';print_r($segments);exit;
$company = get_company_by_name(($segments[1]));
if (! $company ) {
	register_error(elgg_echo('company:error:company_not_found'));
	forward( REFERER);
}

$vars = array();
$vars["entity"] = $company;
$vars["company_type"] = ($vars["entity"]->company_type) ? $vars["entity"]->company_type : 1;

//print '<pre>';print_r($vars['company_type']);print '</pre>';exit;

$job_types = elgg_get_entities_from_metadata(array(
		'types' => 'object',
		'subtypes' => 'job_type',
		'limit' => ELGG_ENTITIES_NO_VALUE,
		'metadata_name_value_pairs'=>array(
				'name' => "is_deleted",
				'value' => 0,
				'operand' => '='
		),

));
$job_type_values = array();
foreach ($job_types as $job_type){
	// An array of all qualification types.
	$job_type_values[$job_type->title] =$job_type->guid;
}
$vars["job_type_values"] = $job_type_values;

$job_type_guids = get_job_type_guids_company($company->guid);
$current_job_types = array();
//$current_job_types[$page_user_id]= 0;
foreach ($job_type_guids as $num7 => $job_typ_guid )
{
	$guid_job_type = $job_typ_guid->guid_one;
	$title_job_type = get_title_by_guid($guid_job_type);
	$current_job_types[$title_job_type[0]->title]= $guid_job_type;
}
$vars["current_job_types"] = $current_job_types;


$file = get_file_by_company_guid($vars["entity"]->guid);
if($file && $file[0])
{
	$vars['file_guid'] = $file[0]->guid;
}

$company_type =  (isset($vars["company_type"]) && ($vars["company_type"] == 2)) ?  elgg_echo('company:title:contracting') : elgg_echo('company:title:construction');
$title = elgg_echo('company:title:edit', array($company_type));

// start building the main column of the page
$content = "";//elgg_view_title($title,array('class'=>"companytitle"));
$body_title = elgg_view_title($title ,array('class'=>"companytitle"));

// add the form to this section
$content .= elgg_view_form("company/save", array("id"=>"frm_company_edit", 'enctype' => 'multipart/form-data'), $vars);

// layout the page
$body = elgg_view_layout('one_column', array('title' => $body_title, 'content' => $content));

// draw the page
echo elgg_view_page($title, $body);
?>