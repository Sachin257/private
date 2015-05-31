<?php 
	$user = get_loggedin_user();
	$user_id = get_loggedin_userid();	
	$user_groups = $user->getGroups();
	$user_owned_groups = array();
?>
<div>
    <label><?php echo elgg_echo("title"); ?></label>
    <?php echo elgg_view('input/text', array('name' => 'title', 'value' => $vars["entity"]->title)); ?>
</div>

<div>
    <label><?php echo elgg_echo("description"); ?></label>
    <?php echo elgg_view('input/longtext', array('name' => 'description', 'value' => $vars["entity"]->description)); ?>
</div>

<br/>

<div>
    <label><?php echo elgg_echo("site:extra:address"); ?></label>
    <?php echo elgg_view('input/longtext', array('name' => 'address', 'value' => $vars["entity"]->address)); ?>
</div>

<br/>

<div>
    <label><?php echo elgg_echo("site:extra:job_description"); ?></label>
    <?php echo elgg_view('input/longtext', array('name' => 'job_description', 'value' => $vars["entity"]->job_description)); ?>
</div>

<br/>

<div>
    <label><?php echo elgg_echo("site:extra:general_contacts"); ?></label>
    <?php echo elgg_view('input/text', array('name' => 'general_contacts', 'value' => $vars["entity"]->general_contacts)); ?>
</div>

<br/>

<div>
    <label><?php echo elgg_echo("site:extra:emergency_contacts"); ?></label>
    <?php echo elgg_view('input/text', array('name' => 'emergency_contacts', 'value' => $vars["entity"]->emergency_contacts)); ?>
</div>

<br/>

<div>
    <label><?php echo elgg_echo("site:extra:out_of_hours_contacts"); ?></label>
    <?php echo elgg_view('input/text', array('name' => 'out_of_hours_contacts', 'value' => $vars["entity"]->out_of_hours_contacts)); ?>
</div>

<br/>

<div>
    <label><?php echo elgg_echo("site:extra:map_url"); ?></label>
    <?php echo elgg_view('input/text', array('name' => 'map_url', 'value' => $vars["entity"]->map_url)); ?>
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