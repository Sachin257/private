<div class="MT_two"></div>
<div class="elgg-avatar span6 dahsboard rounded_corners prs_details">    
 	 <?php echo elgg_view("painting_project/dashboard/general", $vars);?>
</div>

<div class="elgg-avatar  span6 dahsboard rounded_corners column_right_f alerts">    
	<?php echo elgg_view("painting_project/dashboard/material", $vars);?>
</div>
<div class="clear"></div>
<div class="MT_one"></div>
<div class="elgg-avatar  span6 dahsboard rounded_corners certification" style="overflow : hidden;">    
    <?php echo elgg_view("painting_project/dashboard/sites", $vars);?>
</div>
<?php if($vars["employee"]){?>
<div class="elgg-avatar  span6 dahsboard rounded_corners column_right_f sites" style="overflow : hidden;">
    <?php echo elgg_view("painting_project/dashboard/cost", $vars);?>
</div>
<?php } ?>
<div class="clear"></div>
<div class="MT_two"></div>
