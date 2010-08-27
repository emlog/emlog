<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="navi">
<a href="./"><? echo $lang['home']; ?></a> 
<a href="./?action=tw"><? echo $lang['twitters']; ?></a> 
<a href="./?action=com"><? echo $lang['comments']; ?></a> 
<?php if(ISLOGIN === true): ?>
<a href="./?action=write"><? echo $lang['post_add']; ?></a> 
<a href="./?action=logout"><? echo $lang['logout']; ?></a>
<?php else:?>
<a href="<?php echo BLOG_URL; ?>m/?action=login"><? echo $lang['login']; ?></a>
<?php endif;?>
</div>
<div id="m">
<div><?php echo $msg;?></div>
<div><a href="<?php echo $url; ?>"><? echo $lang['return']; ?></a></div>
</div>