<?php
$workers = elgg_extract('workers', $vars);
$offset = elgg_extract('offset', $vars);
$employee_check_in_out_status = elgg_extract('employee_check_in_out_status', $vars);
$project = elgg_extract('project', $vars);
$all_count = elgg_extract('all_count', $vars);
$checked_in_count = elgg_extract('checked_in_count', $vars);
$checked_out_count = elgg_extract('checked_out_count', $vars);
$pending_count = elgg_extract('pending_count', $vars);
$base_url = elgg_extract('base_url', $vars);
?>
<div class="clear"></div>
<div class="cmp_list mgr_listall">
    <div class="search_box nest_wrap checkin_in_out_header"> 
    <h3 class="column_left">
    	<?php 
    	$all_class = "";
    	$in_class = "";
    	$out_class = "";
    	$pending_class = "";
    	if(get_input('in') != "") {
			$all_class = "";
			$in_class = " selected_cls";
			$out_class = "";
			$pending_class = "";
		} else if(get_input('out') != "") {
			$all_class = "";
			$in_class = "";
			$out_class = "selected_cls";
			$pending_class = "";
		} else if(get_input('pending') != "") {
			$all_class = "";
			$in_class = "";
			$out_class = "";
			$pending_class = "selected_cls";
		} else {
			$all_class = "selected_cls";
			$in_class = "";
			$out_class = "";
			$pending_class = "";
		}
    	?>
    	<a href="<?php echo $base_url;?>" class="all_count_lnk <?php echo $all_class;?>"><?php echo elgg_echo('entity:all')?><sup class="all_count_spn"><?php echo $all_count;?></sup></a>
    	<a href="<?php echo $base_url;?>?in=1" class="check_in_count_lnk <?php echo $in_class;?>"><?php echo elgg_echo('entity:in')?><sup class="check_in_count_spn"><?php echo $checked_in_count;?></sup></a>
    	<a href="<?php echo $base_url;?>?out=1" class="all_count_lnk <?php echo $out_class;?>"><?php echo elgg_echo('entity:out')?><sup class="check_out_count_spn"><?php echo $checked_out_count;?></sup></a>
    	<a href="<?php echo $base_url;?>?pending=1" class="all_count_lnk <?php echo $pending_class;?>"><?php echo elgg_echo('checkin:error:incomplete_induction')?><sup class="induction_pending_count_spn"><?php echo $pending_count;?></sup></a>    	
    </h3>
    <div class="column_right"><?php echo  elgg_view_form("project/check_in_out/filter", array('id'=>'frm_in_out_search'), $vars);?></div>
    </div>
</div>
