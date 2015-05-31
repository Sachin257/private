<?php //print'<pre>'; print_r($vars["current_menu"]); print '</pre>';?>
<?php $username=  $vars["entity"]->username?>
<div class="user-nav-left">
	<ul class="nav nav-pills nav-stacked elgg-menu elgg-menu-page elgg-menu-page-default">
		<li class="elgg-menu-item-1-personal <?php if($vars["current_menu"] == "edit") { ?>elgg-state-selected active<?php } ?>">
			<a href="/user/<?php echo $username?>/edit"><span>1</span> <?php echo elgg_echo('profile:edit:title');?></a>
		</li>
		<li class="elgg-menu-item-1-medical <?php if($vars["current_menu"] == "medical") { ?>elgg-state-selected active<?php } ?>">
			<a href="/user/<?php echo $username?>/medical"><span>2</span> <?php echo elgg_echo('profile:medical:title');?></a>
		</li>
		<li class="elgg-menu-item-1-emergency <?php if($vars["current_menu"] == "emergency") { ?>elgg-state-selected active<?php } ?>">
			<a href="/user/<?php echo $username?>/emergency"><span>3</span> <?php echo elgg_echo('profile:emergency:title');?></a>
		</li>
		<li class="elgg-menu-item-1-certification <?php if($vars["current_menu"] == "certification") { ?>elgg-state-selected active<?php } ?>">
			<a href="/user/<?php echo $username?>/certification"><span>4</span> <?php echo elgg_echo('profile:certification:title');?></a>
		</li>
		<li class="elgg-menu-item-1-induction <?php if($vars["current_menu"] == "induction") { ?>elgg-state-selected active<?php } ?>">
			<a href="/user/<?php echo $username?>/induction"><span>5</span> <?php echo elgg_echo('profile:induction:title');?></a>
		</li>
		<li class="elgg-menu-item-1-workhistory <?php if($vars["current_menu"] == "workhistory") { ?>elgg-state-selected active<?php } ?>">
			<a href="/user/<?php echo $username?>/workhistory"><span>6</span> <?php echo elgg_echo('profile:workhistory:title');?></a>
		</li>
	</ul>
</div>

