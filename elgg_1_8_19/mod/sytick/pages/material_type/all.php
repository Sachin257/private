<?php
admin_gatekeeper();
elgg_register_title_button();


$limit = get_input('limit', STAD_PAGINATION_LIMIT);
$offset = get_input('offset', 0);
$s = get_sanitised_input('s');

if($segments[1])
{
  $offset =  $segments[1];
}

$add_link = elgg_view('output/url', array(
		'href' => "material_type/add",
		'text' => elgg_echo('material_type:add'),
		'class' => 'elgg-button elgg-button-add float-alt'
));
$title = elgg_echo('material_type:extra:type') ;
$body_title = elgg_view_title($title,array('class'=>"companytitle"));
$search_arr = array(
		'types' => 'object',
		'subtypes' => 'material_type',
		'limit' => ELGG_ENTITIES_NO_VALUE
);
//if(!elgg_is_admin_logged_in())
//{
	$search_arr['metadata_name_value_pairs'][] = array(
			'name' => "is_deleted",
			'value' => 0,
			'operand' => '='
	);
//}


$material_type_entities = elgg_get_entities_from_metadata($search_arr);

//print '<pre>';print_r($material_type_entities );print '</pre>';exit;
if(count($material_type_entities)){
	foreach($material_type_entities as $_material_type_entities){
		$material_type_entities_ids[] = $_material_type_entities->guid;
	}
}
//print '<pre>';print_r($material_type_entities_ids );print '</pre>';exit;
$body  = '<div class="title-button-container">' . $add_link . '</div>';
if(count($material_type_entities_ids)){
	if($s != "")
	{
		$material_type_entities_ids = get_material_type_search($s, join($material_type_entities_ids,",") );
		//print '<pre>';print_r($project_ids );print '</pre>';exit;
	}
	if(count($material_type_entities_ids)){
		$options = array(
				'type' => 'object',
				'subtype'=>'material_type',
				'guid' => $material_type_entities_ids,
				'limit' => $limit,
				'offset' => $offset,
				'count' => TRUE,
		);
		if(! elgg_is_admin_logged_in())
		{
			$options['metadata_name_value_pairs'][] = array(
					'name' => "is_deleted",
					'value' => 0,
					'operand' => '='
			);
		}
		$count = elgg_get_entities_from_metadata($options);
                //print '<pre>';print_r($count );print '</pre>';exit;

		
		
		$options = array(
				'type' => 'object',
				'subtype'=>'material_type',
				'guid' => $material_type_entities_ids,
				'limit' => $limit,
				'offset' => $offset,
		);
		if(! elgg_is_admin_logged_in())
		{
			$options['metadata_name_value_pairs'][] = array(
					'name' => "is_deleted",
					'value' => 0,
					'operand' => '='
			);
		}
		$material_type_entities = elgg_get_entities_from_metadata($options);
		
		$pagination = elgg_view('navigation/pagination',array(
				'base_url' => '/material_type/all',
				'offset' => $offset,
				'count' => $count,
				'limit' => $limit,
		));
	} else {
		$material_type_entities = false;
		$pagination = "";
	
	}
} else {
	$material_type_entities = false;
	$pagination = "";

}






$title = elgg_echo('material_type:extra:type') ;

//$body_title = $title . '<div class="title-button-container">' . $add_link .'&nbsp;'. '</div>';

$body .= elgg_view('material_type/list',array("material_type"=>$material_type_entities, "offset"=>$offset));
               // print '<pre>';print_r($material_type_entities );print '</pre>';exit;
$body .= $pagination;

$body = elgg_view_layout('one_column', array('title' => $body_title,'content' => $body));

echo elgg_view_page($title, $body);