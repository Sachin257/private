<?php
/**
 * User qualification widget display view
 */

$num = $vars['entity']->num_display;

$options = array(
	'type' => 'object',
	'subtype' => 'qualification',
	'container_guid' => $vars['entity']->owner_guid,
	'limit' => $num,
	'full_view' => FALSE,
	'pagination' => FALSE,
);
$content = elgg_list_entities($options);

echo $content;

if ($content) {
	$lesson_url = "qualification/all";
	$more_link = elgg_view('output/url', array(
		'href' => $lesson_url,
		'text' => elgg_echo('qualification:morequalifications'),
		'is_trusted' => true,
	));
	echo "<span class=\"elgg-widget-more\">$more_link</span>";
} else {
	echo elgg_echo('qualification:noqualifications');
}
