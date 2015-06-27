<?php
gatekeeper();
elgg_register_title_button();


$limit = get_input('limit', SYTICK_PAGINATION_LIMIT);
$offset = get_input('offset', 0);

if($segments[1])
{
  $offset =  $segments[1];
}

$body  = '';
$title = elgg_echo('material_alerts:head');
$body_title = elgg_view_title($title,array('class'=>"companytitle"));
$search_arr = array(
		'types' => 'object',
		'subtypes' => 'material_alerts',
		'limit' => ELGG_ENTITIES_NO_VALUE
);

$material_alerts_entities = elgg_get_entities_from_metadata($search_arr);

if(count($material_alerts_entities)){
	foreach($material_alerts_entities as $_material_alerts_entities){
		$material_alerts_entities_ids[] = $_material_alerts_entities->guid;
	}
}

if(count($material_alerts_entities_ids)){
	if(count($material_alerts_entities_ids)){
		$options = array(
				'type' => 'object',
				'subtype'=>'material_alerts',
				'guid' => $material_alerts_entities_ids,
				'limit' => $limit,
				'offset' => $offset,
				'count' => TRUE,
		);

		$count = elgg_get_entities_from_metadata($options);
		
		$options = array(
				'type' => 'object',
				'subtype'=>'material_alerts',
				'guid' => $material_alerts_entities_ids,
				'limit' => $limit,
				'offset' => $offset,
		);

		$material_alerts_entities = elgg_get_entities_from_metadata($options);
		
		$pagination = elgg_view('navigation/pagination',array(
				'base_url' => '/material_alerts/all',
				'offset' => $offset,
				'count' => $count,
				'limit' => $limit,
		));
	} else {
		$material_alerts_entities = false;
		$pagination = "";
	
	}
} else {
	$material_alerts_entities = false;
	$pagination = "";

}
$body .= elgg_view('material_alerts/list',array("material_alerts"=>$material_alerts_entities, "offset"=>$offset));

$body .= $pagination;

$body = elgg_view_layout('one_column', array('title' => $body_title,'content' => $body));

echo elgg_view_page($title, $body);