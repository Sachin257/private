<?php 
	$user = get_loggedin_user();
	$user_id = get_loggedin_userid();	
	$user_groups = $user->getGroups();
	$user_owned_groups = array();

    $qualification_types = elgg_get_entities_from_metadata(array(
      'types' => 'object',
      'subtypes' => 'qualification_type',
      'metadata_name_value_pairs' => array(
            'name' => "category",
            'value' => "general",
            'operand' => '='
        ),      
   ));

    foreach ($qualification_types as $qualification_type){      
        // An array of all qualification types.
        $qualification_type_values[$qualification_type->guid] = $qualification_type->title;
    }    
?>
<div>
    <label><?php echo elgg_echo("qualification:extra:type"); ?></label>
    <?php 
        echo elgg_view("input/dropdown", array(
            "name" => "qualification_type_guid",          
            "value" => $vars["entity"]->title,
            "options_values" => $qualification_type_values
        ));
    ?>
</div>

</br>
 
<?php 
	if ($vars["entity"]->guid) {
		echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars["entity"]->guid));          
    }
    if ($vars["organization"]->guid) {
        echo elgg_view('input/hidden', array('name' => 'organization_guid', 'value' => $vars["organization"]->guid));          
    }    
?>
<div>
    <?php echo elgg_view('input/submit', array('name' => 'save', 'value' => elgg_echo('save'))); ?>
</div>

<br/><br/>