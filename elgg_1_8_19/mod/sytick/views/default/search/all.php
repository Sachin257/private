    <div>
    <?php $check = 0;
            if($vars['projects']) { 
                $check = $check + 1;?>
    <h4>PROJECTS </h4>
    <table class="elgg-list elgg-list-entity mgr_list">	
		<tbody>
		<tr>
                <th><?php echo elgg_echo('entity:name')?></th>
			<th><?php echo elgg_echo('entity:location')?></th>
			<th><?php echo elgg_echo('entity:creation_date')?></th>
			<th></th>
		</tr>
		<?php foreach($vars['projects'] as $_project)  {?>
		<tr id="elgg-object-<?php echo $_project->guid?>" class="elgg-item">
			<td class="company-title">
			<?php  echo elgg_view('output/url', array(
					'href' => "/project/view/$_project->project_name",
					'text' => $_project->title,
					'class' => '',
					'rel' => 'nofollow'
			)); ?>
			</td>
			<td class="company-title"><?php echo $_project->project_postal_address?> </td>
			<td class="company-abn"><?php echo date('d-m-Y',$_project->time_created)?></td>
			<td class="company-link">
			<?php
			if($_project->project_name != "" ) {
				$edit_url = "/project/edit/{$_project->project_name}";
			} else {
				$edit_url = "/project/edit/?guid={$_project->guid}";
			}			
			echo elgg_view('output/url', array(
					'href' => $edit_url,
					'text' => elgg_echo('entity:edit'),
					'class' => 'MR_20 elgg-button-edit-information float-alt',
					'rel' => 'nofollow'
			));
			$delete_url = "/action/project/delete/?guid={$_project->guid}";
			echo elgg_view('output/confirmlink', array(
					'href' => $delete_url,
					'text' => elgg_echo('entity:delete'),
					'class' => 'elgg-button-delete float-alt'
			));
			?>
			</td>
		</tr>
		<?php }
                ?>
                <tr class="search_project" style="display:none;"><td colspan="5" align="center">
                        <?php   $icon_src = get_image_path("loading_orange.gif"); ?>
                       <img src="<?php echo "$icon_src";?>" >     
                    </td></tr>
		</tbody>
	</table>
      <br>
    <?php }
    if($vars['users']) {
        $check = $check + 1;?>
    <h4>USERS</h4>
    <table class="elgg-list elgg-list-entity mgr_list">	
		<thead>
		<tr>
                    <th style="width: 16%;"><?php echo elgg_echo('entity:name')?></th>
			<th style="width: 27%;"><?php echo elgg_echo('email')?></th>
                        <th style="width: 27%;"><?php echo elgg_echo('entity:company')?></th>
			<th style="width: 15%;"><?php echo elgg_echo('entity:creation_date')?></th>
			<th style="width: 15%;"></th>
		</tr>
                </thead>
                <tbody>
		<?php foreach($vars['users'] as $_manager)  {
                    
                    $company_name = get_company_of_manager($_manager->guid);
                    if(!$company_name)
                    {
                        $company_name = get_company_of_employee($_manager->guid);
                    }
                    $company_name = $company_name->trading_name;
                    ?>
		<tr id="elgg-object-<?php echo $_manager->guid?>" class="elgg-item">
			<td class="company-title"><a href="/user/<?php echo $_manager->username?>"><?php echo $_manager->name?></a></td>
			<td class="company-title"><?php echo $_manager->email?></td>
                        <td class="company-title"><?php echo $company_name?></td>
			<td class="company-abn"><?php echo date('d-m-Y',$_manager->time_created)?></td>
			<td class="company-link"><a href="/manager/edit/<?php echo $_manager->username?>" class="MR_20 elgg-button-edit-information float-alt" rel="nofollow"><?php echo elgg_echo('entity:edit')?> </a></td>
		</tr>
		<?php } ?>
                <tr class="search_user" style="display:none;"><td colspan="5" align="center">
                        <?php   $icon_src = get_image_path("loading_orange.gif"); ?>
                       <img src="<?php echo "$icon_src";?>" >                                 
                    </td></tr>
		</tbody>
	</table>
        <br>             
    <?php }    
    
   if($vars['companies']) {
       $check = $check + 1;?>
    <h4>COMPANIES </h4>
    <table class="elgg-list elgg-list-entity mgr_list">	
		<tbody>
		<tr>
			<th><?php echo elgg_echo('company:name:table_head')?></th>
			<th><?php echo elgg_echo('company:trading_name:table_head')?></th>
			<th><?php echo elgg_echo('entity:creation_date')?></th>
			<th></th>
		</tr>
    <?php foreach( $vars["companies"] as $company)  {?>
		<tr id="elgg-object-<?php echo $company->guid?>" class="elgg-item">
			<td class="company-title">
			<?php   $company_link = strtolower($company->title); $company_link= str_replace(' ', '', $company_link);
                                  echo elgg_view('output/url', array(
					'href' => "/company/$company_link",
					'text' => $company->title,
					'class' => '',
					'rel' => 'nofollow'
			)); ?>
			</td>
                        <td><?php echo $company->description;?></td>
			<td class="company-abn"><?php echo date('d-m-Y',$company->time_created)?></td>
			<td class="company-link">
			<?php
				$edit_url = "/company/edit/$company_link";
						
			echo elgg_view('output/url', array(
					'href' => $edit_url,
					'text' => elgg_echo('entity:edit'),
					'class' => 'MR_20 elgg-button-edit-information float-alt',
					'rel' => 'nofollow'
			));
			$delete_url = "/action/company/delete/?guid={$company->guid}";
			echo elgg_view('output/confirmlink', array(
					'href' => $delete_url,
					'text' => elgg_echo('entity:delete'),
					'class' => 'elgg-button-delete float-alt'
			));
			?>
			</td>
		</tr>
		<?php } ?>
                <tr class="search_company" style="display:none;">
                    <td colspan="5" align="center">
                        <?php   $icon_src = get_image_path("loading_orange.gif"); ?>
                       <img src="<?php echo "$icon_src";?>" >                                 
                    </td>
                </tr>
		</tbody>
	</table>
        <br>
	<?php }
        if($vars['inductions']) {
            $check = $check + 1;
        ?>
         <h4>INDUCTIONS</h4>
         <table class="elgg-list elgg-list-entity mgr_list">
           <tbody>
		<tr>
			<th><?php echo elgg_echo('entity:name')?></th>
			<th><?php echo elgg_echo('enitiy:project')?></th>
			<th><?php echo elgg_echo('entity:creation_date')?></th>
			<th></th>
		</tr>
		<?php foreach($vars['inductions'] as $_induction)  {?>
		<tr id="elgg-object-<?php echo $_induction->guid?>" class="elgg-item">
			<td class="company-title">
			<?php  echo elgg_view('output/url', array(
					'href' => "/induction/view/$_induction->induction_name",
					'text' => $_induction->title,
					'class' => '',
					'rel' => 'nofollow'
			)); ?>
			</td>
			<td class="company-abn"><?php echo get_induction_assigned_project($_induction->guid, $type = "title")?></td>
			<td class="company-abn"><?php echo date('d-m-Y',$_induction->time_created)?></td>
			<td class="company-link">
			<?php		

			
			if($_questionnaire->induction_name != "" ) {
				$edit_url = "/induction/edit/{$_induction->induction_name}";
			} else {
				$edit_url = "/induction/edit/?guid={$_induction->guid}";
			}			
			echo elgg_view('output/url', array(
					'href' => $edit_url,
					'text' => elgg_echo('entity:edit'),
					'class' => 'MR_20 elgg-button-edit-information float-alt',
					'rel' => 'nofollow'
			));
			

			$delete_url = "/action/induction/delete/?guid={$_induction->guid}";
			echo elgg_view('output/confirmlink', array(
					'href' => $delete_url,
					'text' => elgg_echo('entity:delete'),
					'class' => 'elgg-button-delete float-alt'
			));
			if($_induction->induction_status == 1 ) {
				echo elgg_view('output/url', array(
						'href' => "#",
						'text' => elgg_echo('entity:attend'),
						'class' => 'MR_20 elgg-button-edit-information float-alt',
						'data:guid' =>  $_induction->guid,
						'class' => 'induction_attend',
						'data:induction_guid' => $_induction->guid,
						"id" => "induction_attend_{$_induction->guid}",
						'rel' => 'nofollow', 
				));
			} else {
				echo elgg_view('output/url', array(
						'href' => "#",
						'text' => elgg_echo('entity:activate'),
						'class' => 'MR_20 elgg-button-edit-information float-alt',
						'data:guid' =>  $_induction->guid,
						'class' => 'induction_activate',
						'data:induction_guid' => $_induction->guid,
						"id" => "induction_activate_{$_induction->guid}",
						'rel' => 'nofollow',
				));
			}
			?>
			</td>
		</tr>
		<?php } ?>
                <tr class="search_induction" style="display:none;"><td colspan="5" align="center">
                        <?php   $icon_src = get_image_path("loading_orange.gif"); ?>
                       <img src="<?php echo "$icon_src";?>" >                                 
                    </td></tr>
		</tbody>
	</table>
    
     <br>
        <?php }
        if($check == 0)
        {
           echo elgg_echo('results:none');
        }
?>
</div>