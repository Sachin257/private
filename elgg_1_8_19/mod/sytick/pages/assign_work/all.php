<?php
gatekeeper();
elgg_register_title_button();

$limit = get_input('limit', STAD_PAGINATION_LIMIT);
$offset = get_input('offset', 0);

global $order_from_types;

if($segments[1])
{
    $offset =  $segments[1];
}

$add_link = elgg_view('output/url', array(
    'href' => "assign_work/add",
    'text' => elgg_echo('assign_work:add'),
    'class' => 'elgg-button elgg-button-add float-alt'
));
$body  = '<div class="title-button-container">' . $add_link . '</div>';
$title = elgg_echo('assign_work:head');
$body_title = elgg_view_title($title,array('class'=>"companytitle"));
$search_arr = array(
    'types' => 'object',
    'subtypes' => 'assign_work',
    'limit' => ELGG_ENTITIES_NO_VALUE
);

$assign_work_entities = elgg_get_entities_from_metadata($search_arr);
if(count($assign_work_entities)){
    foreach($assign_work_entities as $_assign_work_entities){
        $assign_work_entities_ids[] = $_assign_work_entities->guid;
    }
}

if(count($assign_work_entities_ids)){
    if(count($assign_work_entities_ids)){
        $options = array(
            'type' => 'object',
            'subtype'=>'assign_work',
            'guid' => $assign_work_entities_ids,
            'limit' => $limit,
            'offset' => $offset,
            'count' => TRUE,
        );
        $count = elgg_get_entities_from_metadata($options);

        $options = array(
            'type' => 'object',
            'subtype'=>'assign_work',
            'guid' => $assign_work_entities_ids,
            'limit' => $limit,
            'offset' => $offset,
        );
        $assign_work_entities = elgg_get_entities_from_metadata($options);

        $pagination = elgg_view('navigation/pagination',array(
            'base_url' => '/assign_work/all',
            'offset' => $offset,
            'count' => $count,
            'limit' => $limit,
        ));
    } else {
        $assign_work_entities = false;
        $pagination = "";

    }
} else {
    $assign_work_entities = false;
    $pagination = "";

}

$body .= elgg_view('assign_work/list',array("assign_work" => $assign_work_entities, "offset"=>$offset, "order_from" => $order_from_types));
$body .= $pagination;

$body = elgg_view_layout('one_column', array('title' => $body_title,'content' => $body));

echo elgg_view_page($title, $body);