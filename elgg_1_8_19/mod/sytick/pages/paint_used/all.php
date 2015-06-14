<?php
gatekeeper();
elgg_register_title_button();


$limit = get_input('limit', SYTICK_PAGINATION_LIMIT);
$offset = get_input('offset', 0);
$s = get_sanitised_input('s');

if($segments[1])
{
  $offset =  $segments[1];
}

$add_link = elgg_view('output/url', array(
		'href' => "paint_used/add",
		'text' => elgg_echo('paint_used:add'),
		'class' => 'elgg-button elgg-button-add float-alt'
));
$body  = '<div class="title-button-container">' . $add_link . '</div>';
$title = elgg_echo('paint_used:head');
$body_title = elgg_view_title($title,array('class'=>"companytitle"));
$search_arr = array(
		'types' => 'object',
		'subtypes' => 'paint_used',
		'limit' => ELGG_ENTITIES_NO_VALUE
);

$paint_used_entities = elgg_get_entities_from_metadata($search_arr);

if(count($paint_used_entities)){
	foreach($paint_used_entities as $_paint_entities){
		$paint_used_entities_ids[] = $_paint_entities->guid;
	}
}

if(count($paint_used_entities_ids)){
	if($s != "")
	{
		$paint_used_entities_ids = get_paint_search($s, join($paint_used_entities_ids,",") );
	}
	if(count($paint_used_entities_ids)){
		$options = array(
				'type' => 'object',
				'subtype'=>'paint_used',
				'guid' => $paint_used_entities_ids,
				'limit' => $limit,
				'offset' => $offset,
				'count' => TRUE,
		);

		$count = elgg_get_entities_from_metadata($options);
		
		$options = array(
				'type' => 'object',
				'subtype'=>'paint_used',
				'guid' => $paint_used_entities_ids,
				'limit' => $limit,
				'offset' => $offset,
		);
		$paint_used_entities = elgg_get_entities_from_metadata($options);
		
		$pagination = elgg_view('navigation/pagination',array(
				'base_url' => '/paint_used/all',
				'offset' => $offset,
				'count' => $count,
				'limit' => $limit,
		));
	} else {
		$paint_used_entities = false;
		$pagination = "";
	
	}
} else {
	$paint_used_entities = false;
	$pagination = "";

}


$body .= elgg_view('paint_used/list',array("paint"=>$paint_used_entities, "offset"=>$offset));

$body .= $pagination;

$body = elgg_view_layout('one_column', array('title' => $body_title,'content' => $body));

echo elgg_view_page($title, $body);