<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="navi">
<a href="./"><? echo $lang['home']; ?></a> 
<a href="./?action=tw" id="active"><? echo $lang['twitters']; ?></a> 
<a href="./?action=com"><? echo $lang['comments']; ?></a> 
<?php if(ISLOGIN === true): ?>
<a href="./?action=write"><? echo $lang['post_add']; ?></a> 
<a href="./?action=logout"><? echo $lang['logout']; ?></a>
<?php else:?>
<a href="<?php echo BLOG_URL; ?>m/?action=login"><? echo $lang['login']; ?></a>
<?php endif;?>
</div>
<div id="m">
<?php if(ISLOGIN === true): ?>
<form method="post" action="./index.php?action=t" >
<input name="t" value="" /> <input type="submit" value="<? echo $lang['twitter_send']; ?>" />
</form>
<?php endif;?>
<?php 
foreach($tws as $value):
$by = $value['author'] != 1 ? 'by:'.$user_cache[$value['author']]['name'] : '';
?>
<div class="twcont"><?php echo $value['content'];?></a></div>
<div class="twinfo"><?php echo $by.' '.$value['date'];?>
<?php if(ISLOGIN === true && $value['author'] == UID || ROLE == 'admin'): ?>
 <a href="./?action=delt&id=<?php echo $value['id'];?>"><? echo $lang['remove']; ?></a>
<?php endif;?>
</div>
<?php endforeach; ?>
<div id="page"><?php echo $pageurl;?></div>
</div>