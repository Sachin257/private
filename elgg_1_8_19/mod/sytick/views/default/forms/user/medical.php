<?php
//print_r($vars["entity"]->medical_flg);
if($vars["entity"]->allergy_flg == 1) {
	$vars["allergy_vlaue"] = array("Yes" => 1);
}
else{
        $vars["allergy_vlaue"] = array("No" => 0);
}
?>
<div class="profile_box rounded_corners">
     <label id="allergy_lbl" class="<?php echo $allergy_lbl_class;?> "for="allergy_flg"><?php echo elgg_echo("profile:allergy:label"); ?></label> 
	<?php echo elgg_view('input/radio', array(
                                                "name" => "allergy_flg",
                                                'id' => 'allergy_flg',
						"options" => $vars["yes_no_values"],
                                                'value' => $vars["allergy_vlaue"],                                             
        )); ?>
      
     <div class="clear"></div>

<?php 
if($vars["entity"]->medical_flg == 1) {
	$vars["medical_flg"] = array("Yes" => 1);
}
else{
        $vars["medical_flg"] = array("No" => 0);
}
?>

    <label id="medical_lbl" class="<?php echo $medical_lbl_class;?>"  for="medical_flg"><?php echo elgg_echo("profile:medical:label"); ?></label>    
        <?php echo elgg_view('input/radio', array(
                                                "name" => "medical_flg",
                                                'id' => 'medical_flg',
						"options" => $vars["yes_no_values"],
                                                'value' => $vars["medical_flg"],                                             
        )); ?>
    <label id="description_lbl"  for="description" class="MT_three"><?php echo elgg_echo("profile:description:label"); ?></label>
    <?php //echo elgg_view('input/longtext', array('id' => 'description','name' => 'description', 'value' => $vars["entity"]->description)); ?>
    <textarea id = 'description' name = 'description'><?php echo $vars["entity"]->description;?></textarea>

<span class="error_msg clear description_err"></span>
</div>

<?php 
	if ($vars["entity"]->guid)
		echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $vars["entity"]->guid)); 
?>
<div class="MT_three" align="center">
    <?php echo elgg_view('input/submit', array('id' => 'btn_medical_save', 'name' => 'btn_save', 'class' => 'btn_submit', 'value' => elgg_echo('profile:save:title'))); ?>
</div>

<br/>

