<div>
    <label><?php echo elgg_echo("site_user:add:full_name"); ?></label>
    <?php echo elgg_view('input/text', array('name' => 'name')); ?>
</div>

<div>
    <label><?php echo elgg_echo("site_user:add:username"); ?></label>
    <?php echo elgg_view('input/text', array('name' => 'username')); ?>
</div>

<br/>

<div>
    <label><?php echo elgg_echo("site_user:add:password1"); ?></label>
    <?php echo elgg_view('input/password', array('name' => 'password1')); ?>
</div>

<br/>

<div>
    <label><?php echo elgg_echo("site_user:add:password2"); ?></label>
    <?php echo elgg_view('input/password', array('name' => 'password2')); ?>
</div>

<br/>

<div>
    <label><?php echo elgg_echo("site_user:add:email"); ?></label>
    <?php echo elgg_view('input/text', array('name' => 'email')); ?>
</div>

<br/>

<?php
    if ($vars["site"]->guid) {
        echo elgg_view('input/hidden', array('name' => 'site_guid', 'value' => $vars["site"]->guid));          
    }
    if ($vars["organization"]->guid) {
        echo elgg_view('input/hidden', array('name' => 'organization_guid', 'value' => $vars["organization"]->guid));          
    } 
?>
<div>
    <?php echo elgg_view('input/submit', array('name' => 'save', 'value' => elgg_echo('save'))); ?>
</div>

<br/><br/>