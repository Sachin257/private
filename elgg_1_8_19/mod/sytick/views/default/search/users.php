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