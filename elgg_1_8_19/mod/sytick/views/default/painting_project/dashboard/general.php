<?php 
$edit_url ="";
$url = "#";
	$url = '/painting_project/edit/'.$vars['entity']->guid;
	$edit_url = elgg_view('output/url', array(
			'href' => $url,
			'text' => elgg_echo('dashboard:edit'),
			'is_trusted' => true,
			'class' => 'edit',
	));

?>
<h2><span></span><?php echo $vars['entity']->title;?> <?php echo $edit_url;?></h2>
    <span class="dsh_arrow"></span>
    <label class="cntname MT_three"><?php echo $vars['entity']->trading_name;?></label>
    <label style="color: black;">No: of Pieces:<?php echo $vars['entity']->nopieces;?></label>
    <label style="color: black;">No: of Pieces left:<?php echo $vars['entity']->nopiecesleft;?></label>
    <label style="color: black;">Length per piece:<?php echo $vars['entity']->lengthperpiece;?></label>
    
