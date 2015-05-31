<h2><span></span><?php echo elgg_echo('enitiy:dashboard:projects')?> <?php if($vars["company_type"] != CONTRACTING_TYPE_COMPANY) {?><a href="/project/add/<?php echo $vars["entity"]->guid;?>" class="edit"><?php echo elgg_echo('project:title:add')?></a><?php } ?></h2>
    <span class="dsh_arrow"></span>
    <ul class="list_wrap">
    	<?php 
    	if($vars["projects"]){
			$projects = $vars["projects"];
			foreach($projects as $_project) {
				?>
				<li>
				<strong>
				<?php  echo elgg_view('output/url', array(
						'href' => "/project/view/$_project->project_name",
						'text' => $_project->title,
						'class' => '',
						'rel' => 'nofollow'
				));
				?>
				</strong>
				<?php 
				if( date('d-m-Y',$_project->time_created) == date('d-m-Y',date('U')) ){
					?>
					<sup><?php echo elgg_echo('enitiy:new')?></sup></li>
					<?php 
				}
				 ?>
				</li>
				<?php 
			}
		} else {
    	?>
        <li><strong><?php echo elgg_echo('project:list:none')?></strong></li>
        <?php
		 }
        ?>
    </ul>
    
    