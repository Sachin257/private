<?php
//elgg_load_library('elgg:relationship');
/**
 * View a qualification
 */
$qualification = get_entity(intval($segments[1]));

if (!$qualification) {
	register_error(elgg_echo('noaccess'));
	$_SESSION['last_forward_from'] = current_page_url();
	forward('');
}

$options = array(
	"limit" => false,
	"relationship" => "image_of_qualification",
	"relationship_guid" => $qualification->guid,
	"inverse_relationship" => true
);

$image_of_qualification = elgg_get_entities_from_relationship($options);

foreach ($image_of_qualification as $file) {
	$file_icon = elgg_view('output/img', array(
		'src' => $file->getIconUrl('large'),
	    'alt' => $file->title,
	));
}

$content = elgg_view_entity($qualification, array('full_view' => true));

$content .= "</br><div style='float:left;'><strong>" . elgg_echo("description") . ": </strong>" . elgg_view('output/longtext', array('name' => 'description', 'value' => $qualification->description)) . "</br>";
$content .= "<strong>" . elgg_echo("qualification:extra:number") . ": </strong>" . elgg_view('output/text', array('name' => 'number', 'value' => $qualification->number)) . "</br>";
$content .= "<strong>" . elgg_echo("qualification:extra:granted_date") . ": </strong>" . elgg_view('output/date', array('name' => 'granted_date', 'value' => ($qualification->granted_date != (0) ?  $qualification->granted_date : ''))) . "</br>";
$content .= "<strong>" . elgg_echo("qualification:extra:expired_date") . ": </strong>" . elgg_view('output/date', array('name' => 'expired_date', 'value' => ($qualification->expired_date != (0) ? $qualification->expired_date : ''))) . "</br>";
$content .= "<strong>" . elgg_echo("qualification:extra:organization") . ": </strong>" . elgg_view('output/date', array('name' => 'organization', 'value' => $qualification->organization)) . "</br></div>";

$content .= "<div style='float:right;'>" . $file_icon . "</div>";

$body = elgg_view_layout('one_column', array(
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);
