<?php

admin_gatekeeper();
elgg_register_title_button();

$limit = get_input('limit', STAD_PAGINATION_LIMIT);
$offset = get_input('offset', 0);
$s = get_sanitised_input('s');

if ($segments[1]) {
    $offset = $segments[1];
}

$add_link = elgg_view('output/url', array(
    'href' => "employee/add",
    'text' => elgg_echo('employee:add'),
    'class' => 'elgg-button elgg-button-add float-alt'
        ));
$body = '<div class="title-button-container">' . $add_link . '</div>';
$title = elgg_echo('employee:head');
$body_title = elgg_view_title($title, array('class' => "companytitle"));
$search_arr = array(
    'types' => 'object',
    'subtypes' => 'employee',
    'limit' => ELGG_ENTITIES_NO_VALUE
);

$employee_entities = elgg_get_entities_from_metadata($search_arr);

if (count($employee_entities)) {
    foreach ($employee_entities as $_employee_entities) {
        $employee_entities_ids[] = $_employee_entities->guid;
    }
}

if (count($employee_entities_ids)) {
    if ($s != "") {
        $employee_entities_ids = get_employee_search($s, join($employee_entities_ids, ","));
    }
    if (count($employee_entities_ids)) {
        $options = array(
            'type' => 'object',
            'subtype' => 'employee',
            'guid' => $employee_entities_ids,
            'limit' => $limit,
            'offset' => $offset,
            'count' => TRUE,
        );

        $count = elgg_get_entities_from_metadata($options);

        $options = array(
            'type' => 'object',
            'subtype' => 'employee',
            'guid' => $employee_entities_ids,
            'limit' => $limit,
            'offset' => $offset,
        );

        $employee_entities = elgg_get_entities_from_metadata($options);

        $pagination = elgg_view('navigation/pagination', array(
            'base_url' => '/employee/all',
            'offset' => $offset,
            'count' => $count,
            'limit' => $limit,
        ));
    } else {
        $employee_entities = false;
        $pagination = "";
    }
} else {
    $employee_entities = false;
    $pagination = "";
}

$body .= elgg_view('employee/list', array("employees" => $employee_entities, "offset" => $offset));

$body .= $pagination;

$body = elgg_view_layout('one_column', array('title' => $body_title, 'content' => $body));

echo elgg_view_page($title, $body);
