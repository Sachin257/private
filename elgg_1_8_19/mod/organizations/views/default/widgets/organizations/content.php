<?php
/**
 * User organizations widget display view
 */
elgg_load_library("elgg:organizations");
$num = $vars['entity']->num_display;

$organizations = elgg_get_entities(array(
	'type' => 'object',
	'subtype' => 'organization',
	"limit" => $num,
));

foreach($organizations as $organization){
	
	if (check_entity_relationship ($vars['entity']->owner_guid, "manager_of_organization", $organization->guid)) {
		$organization_is_visible = true;
	} else {
		if (user_is_organization_contractor(get_user($vars['entity']->owner_guid), $organization))  {
			$organization_is_visible = true;
		} else {
			$organization_is_visible = false;			
		}
	}
	
	if ($organization_is_visible && $organization->is_deleted != 1){
		$content .= 
			'<div class="general-list-row">
				<div class="list-item-title">
					<a href="/organizations/view/' . $organization["guid"] . ' ">' . $organization->title . '</a>
				</div>
			</div>'; 
	}
}

echo $content;

if ($content) {
	$organization_url = "organizations/all";
	$more_link = elgg_view('output/url', array(
		'href' => $organization_url,
		'text' => elgg_echo('organizations:moreorganizations'),
		'is_trusted' => true,
	));
	echo "<span class=\"elgg-widget-more\">$more_link</span>";
} else {
	echo elgg_echo('organizations:noorganizations');
}

