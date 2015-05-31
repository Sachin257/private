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

<br/>

<div>
    <label><?php echo elgg_echo("description"); ?></label>
    <?php echo elgg_view('input/longtext', array('name' => 'description', 'value' => $vars["entity"]->description)); ?>
</div>

<?php 
	if ($vars["entity"]->guid)
		echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars["entity"]->guid)); 
?>
<div>
    <?php echo elgg_view('input/submit', array('name' => 'save', 'value' => elgg_echo('save'))); ?>
</div>

<br/><br/>