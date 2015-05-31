<?php
 global $CONFIG;

$labelex = elgg_echo('image:agree');

?>

<div class="reg_captcha MB_two">
    <img id="siimage" src="mod/gutwacaptcha/securimage_show.php?sid=<?php echo md5(uniqid()) ?>" alt="CAPTCHA Image" class="column_left">
    <input type="text" id="sirisana_input" name="sirisana_input" autocomplete="off" size="12" maxlength="8" placeholder="Enter the illegible text" class="column_right" />
 </div>
 <span class="error_msg clear sirisana_input_err"></span>
<div class="clear"></div>
<p class="foot"><?php echo elgg_echo("access:footer:join:text"); ?> <strong><a href="#" class="terms"><?php echo elgg_echo("access:footer:useragree"); ?></a></strong> and   
    <strong><a href="#" class="privacy"><?php echo elgg_echo("access:footer:privacy"); ?></a></strong>.</p>

    <?php 
    /*
    ?>
    <object type="application/x-shockwave-flash" data="mod/gutwacaptcha/securimage_play.swf?bgcol=#ffffff&amp;icon_file=mod/gutwacaptcha/images/audio_icon.png&amp;audio_file=mod/gutwacaptcha/securimage_play.php" height="32" width="32">
    <param name="movie" value="mod/gutwacaptcha/securimage_play.swf?bgcol=#ffffff&amp;icon_file=mod/gutwacaptcha/images/audio_icon.png&amp;audio_file=mod/gutwacaptcha/securimage_play.php" />
    </object>
    &nbsp; 
    <a tabindex="-1" style="border-style: none;" href="#" title="Refresh Image" onclick="document.getElementById('siimage').src = 'mod/gutwacaptcha/securimage_show.php?sid=' + Math.random(); this.blur(); return false"><img src="mod/gutwacaptcha/images/refresh.png" alt="Reload Image" onclick="this.blur()" align="bottom" border="0"></a><br />

    <label><?php echo "$labelex"; ?></label>
    <?php 
    */
    ?>

