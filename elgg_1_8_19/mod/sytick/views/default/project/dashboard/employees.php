<?php 
$add_link = elgg_view('output/url', array(
		'href' => "#",
		'data:guid' => $vars["entity"]->guid,
		"id" => "prj_wrkrs_add",
		'text' => elgg_echo('entity:add:user'),
		'class' => 'edit'
));
//print "<pre>";print_r($vars['current_employees']) ;print "</pre>"; exit;
?>
<h2><span></span><?php echo elgg_echo('entity:add:user');?> <?php echo $add_link;?></h2>
    <span class="dsh_arrow"></span>
    <ul class="list_wrap">
        
        <?php
        foreach ($vars['current_employees'] as $guid => $employee)
        { //print "<pre>";print_r($employee['name']) ;print "</pre>"; exit;
            ?>
            
        
        <li><?php $employee_name = $employee['name']; $employee_username = $employee['username']; 
                  echo elgg_view('output/url', array(
						'href' => "/user/$employee_username",
						'text' => $employee_name,
						'class' => '',
						'rel' => 'nofollow'
				));
				?>&nbsp;&nbsp;&nbsp;
            <?php $company_name = $employee['company'];
                  $company = strtolower($employee['company']);
                  $company = str_replace(' ', '', $company);
                  echo elgg_view('output/url', array(
						'href' => "/company/$company",
						'text' => $company_name,
						'class' => '',
						'rel' => 'nofollow'
				));
            ?>&nbsp;&nbsp;&nbsp;
            <?php echo $employee['profile_type'];?></li>
      <?php  }
        ?>
        
    </ul>