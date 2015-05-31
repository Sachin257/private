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

	foreach ($user_groups as $group){
		if ($group->owner_guid == $user_id){
			// General list of all group entities the user owns.
			array_push($user_owned_groups, $group);
			
			// An array that will be used to populate the option list of the access select box.
			$options_values[$group->guid] = $group->name;
		}
	}	
?>
<div>
    <label><?php echo elgg_echo("qualification:extra:type"); ?></label>
	<?php 
		echo elgg_view("input/dropdown", array(
			"name" => "title",			
			"value" => $vars["entity"]->title,
			"options_values" => $qualification_type_values,
			"value" => intval($vars["default_qualification_type_guid"])
		));
	?>
	<?php 
	if(elgg_is_admin_logged_in()) {
		echo elgg_view('output/url', array(
								'href' => "/qualification_type/add",
								'text' => "Add Type",
								'id'   => "lnk_qualification_add"
						));
	}
	?>
</div>
<?php 
if(elgg_is_admin_logged_in()) {
?>
<div class="dv_qual_type">
<br />
	<label><?php echo elgg_echo("qualification:extra:type"); ?></label>
	<?php echo elgg_view('input/text', array('id' => 'qualification_type')); ?>
	<?php echo elgg_view('input/button', array('id' => 'btn_qual_type_send', 'value' => elgg_echo('save'))); ?>
</div>
<?php  } ?>

<br/>

<div>
    <label><?php echo elgg_echo("description"); ?></label>
    <?php echo elgg_view('input/longtext', array('name' => 'description', 'value' => $vars["entity"]->description)); ?>
</div>

<br/>

<div>
    <label><?php echo elgg_echo("qualification:extra:number"); ?></label>
    <?php echo elgg_view('input/text', array('name' => 'number', 'value' => $vars["entity"]->number)); ?>
</div>

<div>
    <label><?php echo elgg_echo("qualification:extra:granted_date"); ?></label>
    <?php echo elgg_view('input/date', array('name' => 'granted_date', 'value' => $vars["entity"]->granted_date != (0) ? $vars["entity"]->granted_date : '')); ?>
</div>

<div>
    <label><?php echo elgg_echo("qualification:extra:expired_date"); ?></label>
    <?php echo elgg_view('input/date', array('name' => 'expired_date', 'value' => $vars["entity"]->expired_date != (0) ? $vars["entity"]->expired_date : '')); ?>
</div>

<div>
    <label><?php echo elgg_echo("qualification:extra:organization"); ?></label>
    <?php echo elgg_view('input/text', array('name' => 'organization', 'value' => $vars["entity"]->organization)); ?>
</div>

<div>
    <label><?php echo elgg_echo("qualification:extra:document"); ?></label>
    <?php echo elgg_view('input/file', array('name' => 'file')); ?>
</div>
</br>

<?php 
	if ($vars["entity"]->guid)
		echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars["entity"]->guid)); 
?>
<div>
    <?php echo elgg_view('input/submit', array('name' => 'save', 'value' => elgg_echo('save'))); ?>
</div>