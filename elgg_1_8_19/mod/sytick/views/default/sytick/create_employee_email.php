<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo $vars['site']?></title>
</head>
<body>
<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr bgcolor="#bd3505">
    <td width="54" height="60">&nbsp;</td>
    <td colspan="2"><img src="<?php echo get_image_path('email_logo.gif')?>" width="99" height="42" /></td>
  </tr>
  <tr>
    <td height="60">&nbsp;</td>
    <td width="577"><?php echo elgg_echo('employee:create:body:line1', array($vars['username']));?></td>
    <td width="119">&nbsp;</td>
  </tr>
  <tr>
    <td height="40">&nbsp;</td>
    <td><?php echo elgg_echo('employee:create:body:line2', array( $vars['sitename'], $vars['companyname'],  $vars['role']));?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="40">&nbsp;</td>
    <td><?php echo elgg_echo('employee:create:body:line3');?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="40">&nbsp;</td>
    <td><?php echo $vars['link']?></td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td height="40">&nbsp;</td>
    <td><?php echo elgg_echo('employee:create:body:line4');?></td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td height="20">&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td height="40">&nbsp;</td>
    <td>
    	Thanks, <br>
        The <?php echo $vars['sitename']?> team
    </td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td height="40">&nbsp;</td>
    <td>
        <?php echo $vars['siteurl']?>
    </td>
    <td>&nbsp;</td>
  </tr>
  </tr>
   <tr>
    <td height="20">&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
   <tr bgcolor="#f6f6f6">
     <td height="40" colspan="3" align="center">
     	<table width="90%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="58%" style="font-size:12px; color:#555;"><a href="<?php echo $vars['siteurl']?>?policy=terms">User Agreement</a> | <a href="<?php echo $vars['siteurl']?>?policy=privacy">Privacy Policy</a></td>
    <td width="42%" align="right" style="font-size:12px; color:#555;">2014 &copy; Stad TechnoInnovations Pvt. Ltd. - All rights reserved</td>
  </tr>
</table>

     </td>
   </tr>
</table>
</body>
</html>