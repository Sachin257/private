<h2><span></span><?php echo elgg_echo('entity:projects');?><a href="" class="edit">View All</a></h2>
    <span class="dsh_arrow"></span>
    <ul class="list_wrap" style="overflow: auto;">
        <?php $projects = $vars['projects'];
              if(count($projects)){
              foreach($projects as $project) {  ?>
              <li><?php echo $project['name'];?>&nbsp; - &nbsp;<?php echo $project['company'];?></li>
        
              <?php } }
              else{
                      echo '<li>'.elgg_echo('projects:none').'</li>';
              }
              //check
?>
    </ul>
    
