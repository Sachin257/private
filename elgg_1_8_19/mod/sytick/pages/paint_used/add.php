<?php

// make sure only logged in users can see this page
gatekeeper();
// set the title
// for distributed plugins, be sure to use elgg_echo() for internationalization
$title = elgg_echo('paint_used:add');

// start building the main column of the page
$search_arr = array(
    'types' => 'object',
    'subtypes' => 'paint',
    'limit' => ELGG_ENTITIES_NO_VALUE
);

$paint_entities = elgg_get_entities_from_metadata($search_arr);
$vars = array();
$name_arr = array("" => "Select");
foreach ($paint_entities as $paint_entity){
    $name_arr[$paint_entity->guid] = $paint_entity->title . " - " .$paint_entity->paint_id;
}
$vars["paints"] = $name_arr;
$content = elgg_view_title($title);
$content .= elgg_view_form("paint_used/save", array(), $vars);
$sidebar = "";

// layout the page
$body = elgg_view_layout('one_column', array(
    'content' => $content
        ));

// draw the page
echo elgg_view_page($title, $body);
?>