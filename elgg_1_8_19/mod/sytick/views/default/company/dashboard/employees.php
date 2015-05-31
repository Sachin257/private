<?php 
$emp_add_url ="";
if($vars["company_type"] == CONTRACTING_TYPE_COMPANY)
{
	$profile_type_arr = get_custom_profile_types(CONTRACTOR_PROFILE_TYPE);
	if(! elgg_is_admin_logged_in()){
		$emp_add_url = "/employee/add/{$profile_type_arr['guid']}";
	} else {
		$emp_add_url = "/employee/add";
	}
} else {
	$emp_add_url = "/employee/add";
}
if($vars["entity"]->guid)
{
	$emp_add_url .= "?cid=".$vars["entity"]->guid;
}
$profile_type_values = $vars["profile_type_values"]
?>
<h2><span></span><?php echo elgg_echo('entity:employee');?> <a href="<?php echo $emp_add_url;?>" class="edit"><?php echo elgg_echo('employee:title:add');?></a></h2>
    <span class="dsh_arrow"></span>
    <ul class="list_wrap">
    	<?php 
    	if($vars["employees"]){
			$employees = $vars["employees"];
			foreach($employees as $_employees) {
				?>
				<li>
				<strong>
				<?php  echo elgg_view('output/url', array(
						'href' => "/user/$_employees->username",
						'text' => $_employees->name,
						'class' => '',
						'rel' => 'nofollow'
				));
				?>
				<?php 
					echo ($_employees && $_employees->custom_profile_type) ? 
									" - ".$profile_type_values[$_employees->custom_profile_type] : "";
				?>
				</strong>
				<?php 
				if( date('d-m-Y',$_employees->time_created) == date('d-m-Y',date('U')) ){
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
        <li><strong><?php echo elgg_echo('employee:list:none')?></strong></li>
        <?php
		 }
        ?>       
    </ul>