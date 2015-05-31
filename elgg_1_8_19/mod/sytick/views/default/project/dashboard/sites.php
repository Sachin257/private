<h2><span></span><?php  echo elgg_echo('enitiy:inductions')?>
    <a href="/induction/add" class="edit"><?php  echo elgg_echo('sites:title:add')?></a>
</h2>
    <span class="dsh_arrow"></span>
    <ul class="list_wrap">
    	<?php 
    	if($vars["inductions"]){
			$inductions = $vars["inductions"];
			foreach($inductions as $_sites) {
				if($_sites->induction_status && ($_sites->is_deleted == 0 ) )
				?>
				<li>
				<strong>
				<?php   echo elgg_view('output/url', array(
						'href' => "/induction/view/$_sites->induction_name",
						'text' => $_sites->title,
						'class' => '',
						'rel' => 'nofollow'
				));
				?>
				</strong>
				<?php 
				if( date('d-m-Y',$_sites->time_created) == date('d-m-Y',date('U')) ){
				?>
					<sup><?php  echo elgg_echo('enitiy:new')?></sup>
                </li>
				<?php 
				}
				 ?>
				
				<?php 
			}
		} else {
    	?>
        <li><strong><?php echo elgg_echo('induction:error:not_found')?></strong></li>
        <?php
		 }
        ?>
    </ul>
    
    