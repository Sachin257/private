<h2><span></span><?php echo elgg_echo('entity:cost');?> </h2>
    <span class="dsh_arrow"></span>
    <?php
    $cost = $vars['material_type']->price * $vars['material_type']->perimeter * $vars['entity']->lengthperpiece;; 
    $total = $cost * $vars['entity']->nopieces;
    ?>
    <ul class="list_wrap">
        <li style="color: black">Price per piece: <?php echo $cost; ?></li>
        <li style="color: black">Total cost: <?php echo $total;?></li>
        <li></li>
        
    </ul>