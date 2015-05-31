<?php
/**
 * Elgg qualification view
*/

$full = elgg_extract('full_view', $vars, FALSE);
$qualification = elgg_extract('entity', $vars, FALSE);

if (!$qualification) {
	return;
}

$options_image = array(
	"limit" => false,
	"relationship" => "image_of_qualification",
	"relationship_guid" => $qualification->guid,
	"inverse_relationship" => true
);

$image_of_qualification = elgg_get_entities_from_relationship($options_image);

$options_qualification_type = array(
	"limit" => false,
	"relationship" => "qualification_of_qualification_type",
	"relationship_guid" => $qualification->guid,
	"inverse_relationship" => false
);

foreach ($image_of_qualification as $file) {
	$file_icon = elgg_view('output/img', array(
		'src' => $file->getIconUrl('small'),
	    'alt' => $file->title,
	));
}

$qualification_of_qualification_type = elgg_get_entities_from_relationship($options_qualification_type);

foreach ($qualification_of_qualification_type as $qualification_type) {
	$title = elgg_view('output/url', array(
		'href' => "qualification/view/$qualification->guid/$qualification_type->title",
		'text' => $qualification_type->title,
		'is_trusted' => true,
	));
}

$mime = $file->mimetype;
$base_type = substr($mime, 0, strpos($mime,'/'));

$owner = $qualification->getOwnerEntity();
$owner_icon = elgg_view_entity_icon($owner, 'tiny');
$container = $qualification->getContainerEntity();

$options = array(
	'relationship' => 'validated_by',
    'relationship_guid' => $qualification->guid, 
    'inverse_relationship' => false,
);

$validator = elgg_get_entities_from_relationship($options);

$validator_link = elgg_view('output/url', array(
	'href' => 'profile/' . $validator[0]->username,
	'text' => $validator[0]->name,
	'is_trusted' => true,
));

$relationship = check_entity_relationship($qualification->guid, 'validated_by', $validator[0]->guid);

$validator_text = elgg_echo('qualification:extra:validated_by') . ' ' . $validator_link;

$date = elgg_view_friendly_time($relationship->time_created);

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'qualification',
	'show_section_headers' => false,
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));
if (!empty($validator))
	$subtitle = "$validator_text $date";
else
	$subtitle = elgg_echo('qualification:extra:not_validated');

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) {
	$metadata = '';
}

$params = array(
	'entity' => $qualification,
	'title' => $title,
	'metadata' => $metadata,
	'subtitle' => $subtitle,
	'tags' => false,
);
$params = $params + $vars;
$summary = elgg_view('object/elements/summary', $params);

echo elgg_view('object/elements/full', array(
	'entity' => $qualification,
	'icon' => $file_icon,
	'summary' => $summary
));