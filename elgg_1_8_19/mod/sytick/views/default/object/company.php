<?php
$full = elgg_extract('full_view', $vars, FALSE);
$company = elgg_extract('entity', $vars, FALSE);
if (!$company) {
	return;
}

$delete_url = "/action/company/delete/?guid={$company['guid']}";
$delete_link = elgg_view('output/confirmlink', array(
		'href' => $delete_url,
		'text' => elgg_echo('entity:delete'),
		'class' => 'elgg-button-delete float-alt'
));
	
// Edit info button HTML.
$edit_info_url = "/company/edit/{$company->name}";
$edit_info_link = elgg_view('output/url', array(
		'href' => $edit_info_url,
		'text' => elgg_echo('dashboard:edit'),
		'class' => 'MR_20 elgg-button-edit-information float-alt'
));

$view_info_url = "/company/{$company->name}";
/*$view_info_link == elgg_view('output/url', array(
		'href' => $view_info_url,
		'text' => $company->title,
		'class' => 'elgg-button elgg-button-edit-information float-alt'));*/



$params = array(
		'entity' => $company,
		'title' => $title,		
		'view_info_link' => $view_info_url,
		'edit_info_link' => $edit_info_link,
		'delete_link' => $delete_link,		
);
$params = $params + $vars;
$summary = elgg_view('object/elements/company_summary', $params);

echo elgg_view('object/elements/full', array(
		'entity' => $company,
		'icon' => '',
		'summary' => $summary
));
