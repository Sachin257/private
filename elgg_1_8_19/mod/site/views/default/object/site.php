<?php
/**
 * Elgg site view
*/

$full = elgg_extract('full_view', $vars, FALSE);
$site = elgg_extract('entity', $vars, FALSE);

if (!$site) {
	return;
}

$title = elgg_view('output/url', array(
	'href' => "site/view/$site->guid/$site->title",
	'text' => $site->title,
	'is_trusted' => true,
));

$owner = $site->getOwnerEntity();
$owner_icon = elgg_view_entity_icon($owner, 'tiny');
$container = $site->getContainerEntity();

$owner_link = elgg_view('output/url', array(
	'href' => "profile/$owner->username",
	'text' => $owner->name,
	'is_trusted' => true,
));
$author_text = elgg_echo('byline', array($owner_link));

$date = elgg_view_friendly_time($site->time_created);

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'site',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$subtitle = "$author_text $date";

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) {
	$metadata = '';
}

$params = array(
	'entity' => $site,
	'title' => $title,
	'metadata' => $metadata,
	'subtitle' => $subtitle,
);
$params = $params + $vars;
$summary = elgg_view('object/elements/summary', $params);

echo elgg_view('object/elements/full', array(
	'entity' => $site,
	'summary' => $summary
));