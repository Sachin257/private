<?php
$entity = $params['entity'];
//print '<pre>';print_r($vars['entity']);print '</pre>';die();
?>
<td class="company-title"><a href='<?php echo $vars['view_info_link']?>'><?php echo $vars['entity']->title?></a></td>
<td class="company-trade-name"><?php echo $vars['entity']->trading_name?></td>
<td class="company-abn"><?php echo date('d-m-Y',$vars['entity']->time_created)?></td>
<td class="company-link"><?php echo $vars['edit_info_link']?> <?php echo $vars['delete_link']?></td>
<?php 
if(elgg_is_admin_logged_in()) {
?>
<td class="company-deleted">
<?php 
if($vars['entity']->is_deleted) {
    echo elgg_echo('entity:deleted');
}
?>
</td>
<?php 
    }
?>