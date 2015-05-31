<ul>
    <?php $check = 0;
    if($vars['result_project'])
        { $check = $check + 1;
        ?>
           
    <li class="src_lst_cats">PROJECT</li>
         
         <li><?php $entity = get_entity($vars['result_project'][0]);
              echo $entity->title;?></li>
         
         <?php if($vars['result_project'][1])
        {?>
         <li><?php $entity = get_entity($vars['result_project'][1]);
              echo $entity->title;?></li>
         <?php }?>
    <?php }?>
         
        <?php if($vars['result_users'])
        { $check = $check + 1;
            ?>
         <li class="src_lst_cats">USERS</li>
         
         <li><?php $entity = get_entity($vars['result_users'][0]);
              echo $entity->username;?></li>
         
          <?php if($vars['result_users'][1])
        {?>
         <li><?php $entity = get_entity($vars['result_users'][1]);
              echo $entity->username;?></li>
         <?php }?>
     <?php }?>
         
        <?php if($vars['result_company'])
        { $check = $check + 1;
            ?>
         <li class="src_lst_cats">COMPANIES</li>
         
         <li><?php $entity = get_entity($vars['result_company'][0]);
              echo $entity->title;?></li>
         
         <?php if($vars['result_company'][1])
        {?>
         <li><?php $entity = get_entity($vars['result_company'][1]);
              echo $entity->title;?></li>
         <?php }?>
    <?php }?>
         
        <?php if($vars['result_induction'])
        { $check = $check + 1;
            ?>
         <li class="src_lst_cats">INDUCTIONS</li>
         
         <li><?php $entity = get_entity($vars['result_induction'][0]);
              echo $entity->title;?></li>
         
         <?php if($vars['result_induction'][1])
         {?>
         <li><?php $entity = get_entity($vars['result_induction'][1]);
              echo $entity->title;?></li>
         <?php }?>
    <?php }
    
    if($check == 0)
    {?>
        <li><?php echo elgg_echo('results:none');?></li>
   <?php }
    
    ?>
</ul>