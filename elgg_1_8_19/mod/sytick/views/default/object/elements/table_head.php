<?php
$table_head = elgg_extract('table_head', $vars);
//print_r($table_head);die();
if(count($table_head)) {
	?>
	<tr>
	<?php 
	foreach($table_head as $_table_head){
	?>
	<th <?php echo $_table_head['id']?>  <?php echo $_table_head['style']?> <?php echo $_table_head['class']?> ><?php echo $_table_head['text']?></th>
	<?php
	 }
	?>
	</tr>
	<?php 
}