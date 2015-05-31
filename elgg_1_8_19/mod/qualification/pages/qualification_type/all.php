<?php
/**
 * Elgg qualification plugin
*/

elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('qualification:extra:type'));

elgg_register_title_button();

$content = elgg_list_entities_from_metadata(array(
  'types' => 'object',
  'subtypes' => 'qualification_type',
  'view_toggle_type' => true,
  'owner_guid' => elgg_get_logged_in_user_guid(),  
  'metadata_name_value_pairs' => array(
  		'name' => "category",
	    'value' => "general",
	    'operand' => '='
	),      
));

if (!$content) {
	$content = elgg_echo('qualification:none');
}

$title = elgg_echo('qualification:extra:type');

$body = elgg_view_layout('one_sidebar', array(
	'content' => $content,
	'title' => $title,
	'sidebar' => elgg_view('qualification_type/sidebar'),
));

echo elgg_view_page($title, $body);