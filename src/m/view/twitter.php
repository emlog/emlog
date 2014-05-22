<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="m">
<?php if(ROLE == ROLE_ADMIN): ?>
<form method="post" action="./index.php?action=t" enctype="multipart/form-data">
<? echo $lang['twitter_content']; ?>:<br />
<textarea cols="20" rows="3" name="t"></textarea><br />
<? echo $lang['image_select']; ?>:<br />
<input type="file" name="img" /><br />
<input type="submit" value="<? echo $lang['publish']; ?>" />
</form>
<?php endif;?>
<?php 
foreach($tws as $value):
$img = empty($value['img']) ? "" : '<a title="' . $lang['image_view'] . '" href="'.BLOG_URL.str_replace('thum-', '', $value['img']).'" target="_blank"><img style="border: 1px solid #EFEFEF;" src="'.BLOG_URL.$value['img'].'"/></a>';
$by = $value['author'] != 1 ? 'by:'.$user_cache[$value['author']]['name'] : '';
?>
<div class="twcont"><?php echo $value['content'];?><p><?php echo $img;?></p></div>
<div class="twinfo"><?php echo $by.' '.$value['date'];?>
<?php if(ISLOGIN === true && $value['author'] == UID || ROLE == ROLE_ADMIN): ?>
 <a href="./?action=delt&id=<?php echo $value['id'];?>"><? echo $lang['remove']; ?></a>
<?php endif;?>
</div>
<?php endforeach; ?>
<div id="page"><?php echo $pageurl;?></div>
</div>