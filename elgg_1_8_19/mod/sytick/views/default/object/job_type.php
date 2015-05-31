<?php
/**
 * Elgg qualification view
*/

$full = elgg_extract('full_view', $vars, FALSE);
$job_type = elgg_extract('entity', $vars, FALSE);

if (!$job_type) {
	return;
}

$owner = $job_type->getOwnerEntity();
$owner_icon = elgg_view_entity_icon($owner, 'tiny');
$container = $job_type->getContainerEntity();

$owner_link = elgg_view('output/url', array(
	'href' => "user/$owner->username",
	'text' => $owner->name,
	'is_trusted' => true,
));
$author_text = elgg_echo('byline', array($owner_link));

$date = elgg_view_friendly_time($job_type->time_created);

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'job_type',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$subtitle = "$author_text $date";

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) {
	$metadata = '';
}

$params = array(
	'entity' => $job_type,
	'title' => $title,
	'metadata' => $metadata,
	'subtitle' => $subtitle,
);
$params = $params + $vars;
$summary = elgg_view('object/elements/summary', $params);

echo elgg_view('object/elements/full', array(
	'entity' => $job_type,
	'icon' => $file_icon,
	'summary' => $summary
));
