<h2><span></span>Material Specifics</h2>
    <span class="dsh_arrow"></span>
    <ul class="list_wrap">
        <li style="color: black;"><strong>Material Type: <?php echo $vars['material_type']->title;  ?></strong></li>
        <li style="color: black;">Perimeter: <?php echo $vars['material_type']->perimeter;  ?></li>
        <?php if($vars["employee"]){?>
        <li style="color: black;">Price per sq ft: <?php echo $vars['material_type']->price;  ?></li>
        <?php } ?>
        <li style="color: black;"><?php echo $vars['material_type']->description;  ?></li>
    </ul>

