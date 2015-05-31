<?php
/**
 * User site widget display view
 */

$num = $vars['entity']->num_display;

$options = array(
	'type' => 'object',
	'subtype' => 'site',
	'relationship' => 'contractor_of_site',
	'relationship_guid' => $vars['entity']->owner_guid,
	'limit' => $num,
	'full_view' => FALSE,
	'pagination' => FALSE,
);
$content = elgg_list_entities($options);

echo $content;

if ($content) {
	$site_url = "site/all";
	$more_link = elgg_view('output/url', array(
		'href' => $lesson_url,
		'text' => elgg_echo('site:moresites'),
		'is_trusted' => true,
	));
	echo "<span class=\"elgg-widget-more\">$more_link</span>";
} else {
	echo elgg_echo('site:nosites');
}
