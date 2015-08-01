<?php 
$edit_url ="";
$logged_in_users_company = ($company) ? $company->guid :0;
$url = "javascript:void(0)";
	
	$edit_url = elgg_view('output/url', array(
			'href' => $url,
			'text' => elgg_echo('entity:add'),
                        "id" => "add_dailywork",
			'is_trusted' => true,
			'class' => 'edit',
	));

?>

<h2><span></span><?php  echo elgg_echo('enitiy:daily:work')?> <?php echo $edit_url;?>
    
</h2>
    <span class="dsh_arrow"></span>
    <ul class="list_wrap">
    	<?php 
    	if($vars["daily_log"]){
			$daily_log = $vars["daily_log"];
			foreach($daily_log as $_daily_log) {
				if($_daily_log->induction_status && ($_daily_log->is_deleted == 0 ) )
				?>
				<li>
				<strong>
				<?php   
					echo date('m/d/Y', $_daily_log->time_created);	
				?>
                                </strong>&nbsp;&nbsp;&nbsp;
				<?php 
                                    $paint = get_entity( $_daily_log->paint_used);
                                    echo $paint->title;
                                    
                                    echo "&nbsp;&nbsp;&nbsp;&nbsp;";
                                    
                                    echo $_daily_log->nopieces . "Nos:";
                                    
                                    echo "&nbsp;&nbsp;&nbsp;&nbsp;";
                                    
                                    echo $paint->colour;
                                    
                                    echo "&nbsp;&nbsp;&nbsp;&nbsp;";
                                    
                                    echo $_daily_log->employee;
                                    
                                    echo "&nbsp;&nbsp;&nbsp;&nbsp;";
                                    
                                    echo $_daily_log->shift;
                                
				if( date('d-m-Y',$_daily_log->time_created) == date('d-m-Y',date('U')) ){
				?>
					<sup><?php  echo "Todays"?></sup>
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
    
    