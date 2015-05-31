<?php
/**
 * Elgg qualification view
*/

$full = elgg_extract('full_view', $vars, FALSE);
$qualification = elgg_extract('entity', $vars, FALSE);

if (!$qualification) {
	return;
}

$owner = $qualification->getOwnerEntity();
$owner_icon = elgg_view_entity_icon($owner, 'tiny');
$container = $qualification->getContainerEntity();

$owner_link = elgg_view('output/url', array(
	'href' => "profile/$owner->username",
	'text' => $owner->name,
	'is_trusted' => true,
));
$author_text = elgg_echo('byline', array($owner_link));

$date = elgg_view_friendly_time($qualification->time_created);

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'qualification_type',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$subtitle = "$author_text $date";

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) {
	$metadata = '';
}

$params = array(
	'entity' => $qualification,
	'title' => $title,
	'metadata' => $metadata,
	'subtitle' => $subtitle,
);
$params = $params + $vars;
$summary = elgg_view('object/elements/summary', $params);

echo elgg_view('object/elements/full', array(
	'entity' => $qualification,
	'icon' => $file_icon,
	'summary' => $summary
));