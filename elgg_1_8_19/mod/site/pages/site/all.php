<?php

$organization = get_entity(intval($segments[1]));

$sites = elgg_get_entities_from_relationship(array(
      'types' => 'object',
      'subtypes' => 'site',
      'limit' => false,
      'relationship' => 'site_of_organization',
      'relationship_guid' => $organization->guid,
      'inverse_relationship' => true,        
));

$current_user = elgg_get_logged_in_user_entity();

$can_add = true; // Users will have to pay for this.
	
// Create link for adding a new site.
$add_link = elgg_view('output/url', array(
	'href' => "site/add/{$organization['guid']}",
	'text' => elgg_echo('site:add'),
	'class' => 'elgg-button elgg-button-add float-alt'
));
	
if ($can_add)
	$title = elgg_echo('site:mine');

$body = elgg_view_title($title . '<div class="title-button-container">' . $add_link . '</div>');

foreach($sites as $site) {		
	// Delete button HTML.
	$delete_url = "action/site/delete?guid={$site['guid']}";
	$delete_link = elgg_view('output/confirmlink', array(
		'href' => $delete_url,
		'text' => elgg_echo('site:extra:delete'),
		'class' => 'elgg-button elgg-button-delete float-alt'
	));

	// Edit info button HTML.
	$edit_info_url = "site/edit/{$site['guid']}";
	$edit_info_link = elgg_view('output/url', array(
		'href' => $edit_info_url,
		'text' => elgg_echo('site:edit'),
		'class' => 'elgg-button elgg-button-edit-information float-alt'
	));

	// Edit sites button HTML.
	$view_sites_url = "/site/all/{$site['guid']}";
	$view_sites_link = elgg_view('output/url', array(
		'href' => $view_sites_url,
		'text' => elgg_echo('site:extra:view_lessons'),
		'class' => 'elgg-button elgg-button-edit-screens float-alt'
	));

	$body .= 
		'<div class="general-list-row">
			<div class="list-item-title">' . $site->title . '</div> 
			<div class="list-item-options">' . 
				$view_sites_link . ' &nbsp; ' . $edit_info_link . ' &nbsp; ' . $delete_link . '
			</div>
		</div>';
}

$body = elgg_view_layout('one_column', array('content' => $body));
 
echo elgg_view_page($title, $body);