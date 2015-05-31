<?php 
//print "<pre>";print_r($vars['companies']);print "<pre>";
$companies = $vars['companies'];
$company_type = $vars['company_type'];
$company_type_title = "";
?>
<div class="span4">
	<div class="company_head">
		<h3>
                    <?php if($company_type ==  CONSTRUCTION_TYPE_COMPANY) { ?>
                    <?php echo elgg_echo('company:title:construction')?>
                    <?php $company_type_title =  elgg_echo('company:title:construction');?>
		<span>
		<?php 
		echo elgg_view('output/url', array(
                    'href' => "company/add/".CONSTRUCTION_TYPE_COMPANY,
                    'text' => elgg_echo('certificate:add'),
                    'class' => 'elgg-button elgg-button-add float-alt'
                    ));
		?>
		</span> 
		<?php } elseif($company_type ==  CONTRACTING_TYPE_COMPANY) {?>
		<?php echo elgg_echo('company:title:contracting')?>
		<?php $company_type_title =   elgg_echo('company:title:contracting');?>
		<span>
		<?php 
		echo elgg_view('output/url', array(
                    'href' => "company/add/".CONTRACTING_TYPE_COMPANY,
                    'text' => elgg_echo('certificate:add'),
                    'class' => 'elgg-button elgg-button-add float-alt'
                ));
		?>
		</span> 
		<?php } ?>		
		</h3>
            <div class="top_border"></div>
	</div>
	<div class="company_body dahsboard rounded_corners prs_details">
		<ul class="list_wrap">
		<?php 
                    if(count($companies)) {
                    foreach($companies as $key=>$_companies) { 
		?>
		<li>
			<?php echo $_companies['trading_name']?>  
                    <?php 
				echo elgg_view('output/url', array(
						'href' => "/company/{$_companies['name']}",
						'text' => elgg_echo('entity:view'),
						'class' => 'MR_20 elgg-button-edit-information float-alt column_right'
				));
			?>
			<?php 
				echo elgg_view('output/url', array(
						'href' => "/company/edit/{$_companies['name']}",
						'text' => elgg_echo('dashboard:edit'),
						'class' => 'MR_20 elgg-button-edit-information float-alt column_right '
				));
			?>
			&nbsp;
			
		</li>
                
		<?php } ?>
		<?php  } else {?>
                <li><?php echo elgg_echo('company:list:none',array($company_type_title))?></li>
		<?php } ?>
    </ul>
            <div class="clear"></div>
            <div class="lnk_more MT_three" align="right"><a href="">More</a></div>
	</div>
</div>