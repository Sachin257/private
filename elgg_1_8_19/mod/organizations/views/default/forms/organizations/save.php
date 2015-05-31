<div>
    <label><?php echo elgg_echo("organizations:save:title"); ?></label>
    <?php echo elgg_view('input/text', array('name' => 'title', 'value' => $vars["entity"]->title)); ?>
</div>

<br/>

<div>
    <label><?php echo elgg_echo("organizations:extra:abn"); ?></label>
    <?php echo elgg_view('input/text', array('name' => 'abn', 'value' => $vars["entity"]->abn)); ?>
</div>

</br>

<div>
    <label><?php echo elgg_echo("organizations:save:description"); ?></label>
    <?php echo elgg_view('input/longtext', array('name' => 'description', 'value' => $vars["entity"]->description)); ?>
</div>

<br/>

<div>
    <label><?php echo elgg_echo("organizations:extra:address"); ?></label>
    <?php echo elgg_view('input/longtext', array('name' => 'address', 'value' => $vars["entity"]->address)); ?>
</div>

<br/>

<div>
    <label><?php echo elgg_echo("organizations:extra:tel"); ?></label>
    <?php echo elgg_view('input/text', array('name' => 'tel', 'value' => $vars["entity"]->tel)); ?>
</div>

<br/>

<div>
    <label><?php echo elgg_echo("organizations:extra:fax"); ?></label>
    <?php echo elgg_view('input/text', array('name' => 'fax', 'value' => $vars["entity"]->fax)); ?>
</div>

<br/>

<div>
    <label><?php echo elgg_echo("organizations:extra:email"); ?></label>
    <?php echo elgg_view('input/text', array('name' => 'email', 'value' => $vars["entity"]->email)); ?>
</div>

<br/>

<div>
    <label><?php echo elgg_echo("organizations:extra:website"); ?></label>
    <?php echo elgg_view('input/text', array('name' => 'website', 'value' => $vars["entity"]->website)); ?>
</div>

<br/>

<?php 
	if ($vars["entity"]->guid)
		echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars["entity"]->guid)); 
?>
<div>
    <?php echo elgg_view('input/submit', array('name' => 'save', 'value' => elgg_echo('organizations:save:save'))); ?>
</div>

<br/><br/>