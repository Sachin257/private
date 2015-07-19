<?php

gatekeeper();
elgg_register_title_button();

global $order_from_types;

$limit = get_input('limit', STAD_PAGINATION_LIMIT);
$offset = get_input('offset', 0);
$s = get_sanitised_input('s');
$m = get_sanitised_input('m');
$o = get_sanitised_input('o');
$start_date = get_sanitised_input('startDate');
$final_date = get_sanitised_input('finalDate');


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
if ($o != "") {
    $search_arr['metadata_name_value_pairs'][] = array(
        'name' => "order_from",
        'value' => $o,
        'operand' => '='
    );
}

$painting_project_entities = elgg_get_entities_from_metadata($search_arr);
$s_guid = 0;
$uniq_proj = get_unique_paint_projects();
foreach ($uniq_proj as $guid =>  $proj){
    if($s == $proj){
        $s_guid = $guid;
    }
}
$total_cost = 0;
$total_pieces = 0;
if (count($painting_project_entities)) {
    foreach ($painting_project_entities as $_paint_entities) {
        if($start_date != "" && ($_paint_entities->time_created < strtotime($start_date))){
            continue;
        }
        if($final_date != "" && ($_paint_entities->time_created > strtotime($final_date))){
            continue;
        }
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

        $count = elgg_get_entities_from_metadata($options);

        $options = array(
            'type' => 'object',
            'subtype' => 'painting_project',
            'guid' => $painting_project_entities_ids,
            'limit' => $limit,
            'offset' => $offset,
        );
        $painting_project_entities = elgg_get_entities_from_metadata($options);

        foreach ($painting_project_entities as $_paint_entities){
            $material_id = $_paint_entities->material_id;
            $material = get_entity($material_id);
            $cost = ($_paint_entities->nopieces * $material->price * $material->perimeter * $_paint_entities->lengthperpiece);
            $total_cost = $total_cost + $cost;
            $total_pieces = $total_pieces + $_paint_entities->nopieces;
        }
        
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

$vars = array("paint" => $painting_project_entities,
              "offset" => $offset,
              "order_from" => $order_from_types ,
              "uniqueproject" => $uniq_proj,
              "o" => $o,
              "s" => $s_guid,
              "m" => $m,
              "start_date" => $start_date,
              "final_date" => $final_date,
              'cost' => $total_cost,
              'nopiece' => $total_pieces,
              "admin" => true,
              "materials" => $material_id_values);

$body .= elgg_view('painting_project/list', $vars);
$body .= $pagination;

$body = elgg_view_layout('one_column', array('title' => $body_title, 'content' => $body));

echo elgg_view_page($title, $body);
