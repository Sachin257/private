<?php
/**
 * Elgg qualification plugin
*/

elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('qualification'));

elgg_register_title_button();

if(is_contractor()) 
{
// Create link for adding a new qualification.
	$add_link = elgg_view('output/url', array(
		'href' => "qualification/add",
		'text' => elgg_echo('qualification:add'),
		'class' => 'elgg-button elgg-button-add float-alt'
	));
}
if(elgg_is_admin_logged_in())
{
	$type_link = elgg_view('output/url', array(
			'href' => "qualification_type/all",
			'text' => elgg_echo('qualification:extra:type'),
			'class' => 'elgg-button elgg-button-add float-alt'
	));
}

$title = elgg_echo('qualification:mine') . '<div class="title-button-container">' . $add_link .'&nbsp;'. $type_link. '</div>'; 
$content .= elgg_list_entities(array(
    'type' => 'object',
    'subtype' => 'qualification',
    'full_view' => true,
    'view_toggle_type' => true,
    'owner_guid' => elgg_get_logged_in_user_guid()
));

if (!$content) {
	$content = elgg_echo('qualification:none');
}

$body = elgg_view_layout('one_column', array(
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);
