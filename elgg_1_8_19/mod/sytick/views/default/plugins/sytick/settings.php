<?php 
//elgg_get_plugin_setting('abn_webservice_guid', 'sytick');
?>
<table>
	<tr>
		<td>
			<?php echo elgg_echo("sytick:admin:settings:abn_webservice_guid"); ?>&nbsp : &nbsp 
		</td>
		<td>
			<?php echo elgg_view("input/text", array("name" => "params[abn_webservice_guid]", "value" => $vars['entity']->abn_webservice_guid, "size" => 36, "maxlength" => 40)); ?>
		</td>
	</tr>	
</table>		