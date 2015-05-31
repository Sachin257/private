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
		'href' => "paint/add",
		'text' => elgg_echo('paint:add'),
		'class' => 'elgg-button elgg-button-add float-alt'
));
$body  = '<div class="title-button-container">' . $add_link . '</div>';
$title = elgg_echo('paint:head');
$body_title = elgg_view_title($title,array('class'=>"companytitle"));
$search_arr = array(
		'types' => 'object',
		'subtypes' => 'paint',
		'limit' => ELGG_ENTITIES_NO_VALUE
);

	$search_arr['metadata_name_value_pairs'][] = array(
			'name' => "is_deleted",
			'value' => 0,
			'operand' => '='
	);



$paint_entities = elgg_get_entities_from_metadata($search_arr);

//print '<pre>';print_r($paint_entities );print '</pre>';exit;
if(count($paint_entities)){
	foreach($paint_entities as $_paint_entities){
		$paint_entities_ids[] = $_paint_entities->guid;
	}
}
//print '<pre>';print_r($paint_entities_ids );print '</pre>';exit;

if(count($paint_entities_ids)){
	if($s != "")
	{
		$paint_entities_ids = get_paint_search($s, join($paint_entities_ids,",") );
		//print '<pre>';print_r($project_ids );print '</pre>';exit;
	}
	if(count($paint_entities_ids)){
		$options = array(
				'type' => 'object',
				'subtype'=>'paint',
				'guid' => $paint_entities_ids,
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
//                print '<pre>';print_r($count );print '</pre>';exit;
		
		$options = array(
				'type' => 'object',
				'subtype'=>'paint',
				'guid' => $paint_entities_ids,
				'limit' => $limit,
				'offset' => $offset,
		);

			$options['metadata_name_value_pairs'][] = array(
					'name' => "is_deleted",
					'value' => 0,
					'operand' => '='
			);
		$paint_entities = elgg_get_entities_from_metadata($options);
		
		$pagination = elgg_view('navigation/pagination',array(
				'base_url' => '/paint/all',
				'offset' => $offset,
				'count' => $count,
				'limit' => $limit,
		));
	} else {
		$paint_entities = false;
		$pagination = "";
	
	}
} else {
	$paint_entities = false;
	$pagination = "";

}

//$body_title = $title . '<div class="title-button-container">' . $add_link .'&nbsp;'. '</div>';

$body .= elgg_view('paint/list',array("paint"=>$paint_entities, "offset"=>$offset));
               // print '<pre>';print_r($paint_entities );print '</pre>';exit;
$body .= $pagination;

$body = elgg_view_layout('one_column', array('title' => $body_title,'content' => $body));

echo elgg_view_page($title, $body);