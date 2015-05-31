<?php

gatekeeper();
elgg_register_title_button();

global $inventory_types;
$s = get_sanitised_input('s');

if ($segments[1]) {
    $offset = $segments[1];
}

$add_link = elgg_view('output/url', array(
    'href' => "inventory/add",
    'text' => elgg_echo('item:add'),
    'class' => 'elgg-button elgg-button-add float-alt'
        ));
$body = '<div class="title-button-container">' . $add_link . '</div>';
$title = elgg_echo('inventory:head');
$body_title = elgg_view_title($title, array('class' => "companytitle"));

$inventory_entities = array();
foreach ($inventory_types as $key => $inventory_type) {
    if ($key != "") {
        $entities = array();
        $search_arr = array(
            'types' => 'object',
            'subtypes' => "$inventory_type",
            'limit' => ELGG_ENTITIES_NO_VALUE
        );
        $entities = elgg_get_entities_from_metadata($search_arr);
        if ($entities != FALSE) {
            $inventory_entities = array_merge($inventory_entities, $entities);
        }
    }
}
if (count($inventory_entities)) {
    foreach ($inventory_entities as $_inventory_entities) {
        $inventory_entities_ids[] = $_inventory_entities->guid;
    }
}

if (count($inventory_entities_ids)) {
    if ($s != "") {
        $inventory_entities_ids = get_inventory_search($s, join($inventory_entities_ids, ","));
        //print '<pre>';print_r($project_ids );print '</pre>';exit;
    }
    if (count($inventory_entities_ids)) {
        $inventory_entities = array();
        foreach ($inventory_entities_ids as $inventory_entities_id)
        {
            $inventory_entities[] = get_entity($inventory_entities_id);
        }
    } else {
        $inventory_entities = false;
    }
} else {
    $inventory_entities = false;
}
$body .= elgg_view('inventory/list', array("inventory" => $inventory_entities, "inventory_types" => $inventory_types ));

$body = elgg_view_layout('one_column', array('title' => $body_title, 'content' => $body));

echo elgg_view_page($title, $body);
