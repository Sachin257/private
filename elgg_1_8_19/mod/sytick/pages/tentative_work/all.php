<?php
gatekeeper();
elgg_register_title_button();


$limit = get_input('limit', STAD_PAGINATION_LIMIT);
$offset = get_input('offset', 0);
$start_date = get_sanitised_input('startDate');
$final_date = get_sanitised_input('finalDate');

if($segments[1])
{
    $offset =  $segments[1];
}

$add_link = elgg_view('output/url', array(
    'href' => "tentative_work/add",
    'text' => elgg_echo('tentative_work:add'),
    'class' => 'elgg-button elgg-button-add float-alt'
));
$body  = '<div class="title-button-container">' . $add_link . '</div>';
$title = elgg_echo('tentative_work:head');
$body_title = elgg_view_title($title,array('class'=>"companytitle"));
$search_arr = array(
    'types' => 'object',
    'subtypes' => 'tentative_work',
    'limit' => ELGG_ENTITIES_NO_VALUE
);

$tentative_work_entities = elgg_get_entities_from_metadata($search_arr);

//print '<pre>';print_r($tentative_work_entities );print '</pre>';exit;
if(count($tentative_work_entities)){
    foreach($tentative_work_entities as $_tentative_work_entities){
        if($start_date != "" && (strtotime($_tentative_work_entities->date) < strtotime($start_date))){
            continue;
        }
        if($final_date != "" && (strtotime($_tentative_work_entities->date) > strtotime($final_date))){
            continue;
        }
        $tentative_work_entities_ids[] = $_tentative_work_entities->guid;
    }
}
//print '<pre>';print_r($tentative_work_entities_ids );print '</pre>';exit;

if(count($tentative_work_entities_ids)){
    if(count($tentative_work_entities_ids)){
        $options = array(
            'type' => 'object',
            'subtype'=>'tentative_work',
            'guid' => $tentative_work_entities_ids,
            'limit' => $limit,
            'offset' => $offset,
            'count' => TRUE,
        );
        $count = elgg_get_entities_from_metadata($options);
//                print '<pre>';print_r($count );print '</pre>';exit;

        $options = array(
            'type' => 'object',
            'subtype'=>'tentative_work',
            'guid' => $tentative_work_entities_ids,
            'limit' => $limit,
            'offset' => $offset,
        );

        $tentative_work_entities = elgg_get_entities_from_metadata($options);

        $pagination = elgg_view('navigation/pagination',array(
            'base_url' => '/tentative_work/all',
            'offset' => $offset,
            'count' => $count,
            'limit' => $limit,
        ));
    } else {
        $tentative_work_entities = false;
        $pagination = "";

    }
} else {
    $tentative_work_entities = false;
    $pagination = "";

}

$body .= elgg_view('tentative_work/list',array("tentative_work"=>$tentative_work_entities, "offset"=>$offset, "start_date" => $start_date, "final_date" => $final_date));

$body .= $pagination;

$body = elgg_view_layout('one_column', array('title' => $body_title,'content' => $body));

echo elgg_view_page($title, $body);