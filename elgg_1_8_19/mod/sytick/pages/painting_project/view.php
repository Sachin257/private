<?php
// need to restrict for company managers and admin
gatekeeper();
if(isset($segments[1])){
	$project = get_entity($segments[1]);
} 
if (! $project ) {
	register_error(elgg_echo('project:error:not_found'));
	forward( REFERER);
}

$vars = array();
$vars["entity"] = $project;
$vars["material_type"] = get_entity($project->material_id);

$vars["daily_log"] = get_daily_log_by_project_guid($project->guid);
//print "<pre>";print_r($vars) ;print "</pre>"; exit;

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
//print "<pre>";print_r($vars) ;print "</pre>"; exit;

$paint_arr = array(""=> "Select");
foreach ($paint_entities as $paint_entitie)
{
        $paint_arr[$paint_entitie->guid]= $paint_entitie->title . " - " .$paint_entitie->paint_id . " - " . $paint_entitie->colour;
}
$vars["paints"] = $paint_arr;
$title = elgg_echo('project:dashboard:title');

$content = elgg_view("painting_project/dashboard", $vars);
$content .= elgg_view_form("painting_project/daily_log", array('id'=>"ftm_add_workers"), $vars);
//print "<pre>";print_r($content) ;print "</pre>"; exit;
// layout the page
$body = elgg_view_layout('one_column', array('content' => $content));

// draw the page
echo elgg_view_page($title, $body);