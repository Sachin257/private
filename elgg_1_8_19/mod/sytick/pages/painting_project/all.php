<?php

gatekeeper();
elgg_register_title_button();


$limit = get_input('limit', STAD_PAGINATION_LIMIT);
$offset = get_input('offset', 0);
$s = get_sanitised_input('s');
$m = get_sanitised_input('m');

$material_id_values = get_material_type_id_values();

if ($segments[1]) {
    $offset = $segments[1];
}

$add_link = elgg_view('output/url', array(
    'href' => "javascript:void(0)",
    "id" => "paintingProjectAdd",
    'text' => elgg_echo('painting_project:add'),
    'class' => 'elgg-button elgg-button-add float-alt'
        ));
$body = '<div class="title-button-container">' . $add_link . '</div>';
$title = elgg_echo('painting_project:head');
$body_title = elgg_view_title($title, array('class' => "companytitle"));
$search_arr = array(
    'types' => 'object',
    'subtypes' => 'painting_project',
    'limit' => ELGG_ENTITIES_NO_VALUE
);
if ($m != "") {
    $search_arr['metadata_name_value_pairs'][] = array(
        'name' => "material_id",
        'value' => $m,
        'operand' => '='
    );
}

$painting_project_entities = elgg_get_entities_from_metadata($search_arr);
$uniq_proj = array("" => "select");
foreach ($painting_project_entities as $painting_project_entitie) {
    $uniq_proj[$painting_project_entitie->guid] = $painting_project_entitie->title;
}
$uniq_proj = array_unique($uniq_proj);

if (count($painting_project_entities)) {
    foreach ($painting_project_entities as $_paint_entities) {
        $painting_project_entities_ids[] = $_paint_entities->guid;
    }
}

if (count($painting_project_entities_ids)) {
    if ($s != "") {
        $painting_project_entities_ids = get_paint_search($s, join($painting_project_entities_ids, ","));
    }
    if (count($painting_project_entities_ids)) {
        $options = array(
            'type' => 'object',
            'subtype' => 'painting_project',
            'guid' => $painting_project_entities_ids,
            'limit' => $limit,
            'offset' => $offset,
            'count' => TRUE,
        );
        $options['metadata_name_value_pairs'][] = array(
            'name' => "is_deleted",
            'value' => 0,
            'operand' => '='
        );

        $count = elgg_get_entities_from_metadata($options);

        $options = array(
            'type' => 'object',
            'subtype' => 'painting_project',
            'guid' => $painting_project_entities_ids,
            'limit' => $limit,
            'offset' => $offset,
        );

        $options['metadata_name_value_pairs'][] = array(
            'name' => "is_deleted",
            'value' => 0,
            'operand' => '='
        );
        $painting_project_entities = elgg_get_entities_from_metadata($options);

        $pagination = elgg_view('navigation/pagination', array(
            'base_url' => '/painting_project/all',
            'offset' => $offset,
            'count' => $count,
            'limit' => $limit,
        ));
    } else {
        $painting_project_entities = false;
        $pagination = "";
    }
} else {
    $painting_project_entities = false;
    $pagination = "";
}
$body .= elgg_view('painting_project/list', array("paint" => $painting_project_entities, "offset" => $offset, "uniqueproject" => $uniq_proj, "materials" => $material_id_values));
$body .= $pagination;

$body = elgg_view_layout('one_column', array('title' => $body_title, 'content' => $body));

echo elgg_view_page($title, $body);
