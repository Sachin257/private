<?php
$inductions = elgg_extract('inductions', $vars);
//print "<pre>";print_r($inductions);exit;
?>
<div class="clear"></div>
<div class="cmp_list rounded_corners frm_box_shadow frm_box_border MB_five mgr_listall user_pg_sectioon">
    <div>
    <?php if($inductions && count($inductions)) { ?>
    <table class="elgg-list elgg-list-entity mgr_list">	
		<tbody>
		<tr>
			<th style="width: 35%"><?php echo elgg_echo('entity:induction')?></th>
			<th style="width: 22%"><?php echo elgg_echo('entity:project')?></th>
			<th style="width: 23%"><?php echo elgg_echo('entity:company')?></th>
			<th style="width: 20%"><?php echo elgg_echo('entity:status')?></th>
		</tr>
		<?php foreach($inductions as $induction)  { ?>
		<tr id="elgg-object-<?php echo $induction->guid?>" class="elgg-item">
                  <td><?php echo $induction->title;?></td>
                  <td><?php echo get_induction_assigned_project($induction->guid, "title")?></td>
                  <td><?php echo get_entity_name($induction->company_guid, "trading_name")?></td>
                  <td style="text-align:left;">
                  	<?php 
                  	if($induction->induction_status == 1 ) {
                  		$style_str = (get_all_induction_result($vars["entity"]->guid, $induction->guid,1) === false)? elgg_echo('entity:list_induction:attend:red') : elgg_echo('entity:list_induction:attend');						
                  		echo elgg_view('output/url', array(
                  				'href' => "#",
                  				'text' => $style_str,
                                                'title' => elgg_echo('entity:attend'),
                  				'class' => 'MR_20 elgg-button-edit-information float-alt',
                  				'data:guid' =>  $induction->guid,
                  				'class' => 'induction_attend',
                  				'data:induction_guid' => $induction->guid,
                  				"id" => "induction_attend_{$induction->guid}",
                  				'rel' => 'nofollow',
                  		));
                                echo "&nbsp&nbsp&nbsp&nbsp";
                                echo elgg_view('output/url', array(
                  				'href' => "#",
                  				'text' => elgg_echo('entity:list_induction:status'),
                                                'title' => elgg_echo('entity:result'),
                  				'class' => 'MR_20 elgg-button-edit-information float-alt',
                  				'data:guid' =>  $induction["guid"],
                  				'class' => 'induction_result',
                  				'data:induction_guid' => $induction["guid"],
                  				"id" => "induction_result_{$induction["guid"]}",
                  				'rel' => 'nofollow',
                  		));
                  	}
                  	?>
                  </td>
		</tr>
		<?php } ?>
		</tbody>
	</table>
	<?php } else { ?>
	<?php echo elgg_echo('questionnaire:induction:error')?>	
	<?php }?>
</div>

<div class="clear">
</div>
<?php //echo  elgg_view("questionnaire/question/blocks/question_attend_modal", $vars);?>
<?php echo  elgg_view("user/induction_results_modal", $vars);?>
