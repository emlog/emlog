<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="m">
<?php if(ROLE == ROLE_ADMIN): ?>
<form method="post" action="./index.php?action=t" enctype="multipart/form-data">
微语内容：<br />
<textarea cols="20" rows="3" name="t"></textarea><br />
选择要上传的图片:<br />
<input type="file" name="img" /><br />
<input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
<input type="submit" value="发布" />
</form>
<?php endif;?>
<?php 
foreach($tws as $value):
$img = empty($value['img']) ? "" : '<a title="查看图片" href="'.BLOG_URL.str_replace('thum-', '', $value['img']).'" target="_blank"><img style="border: 1px solid #EFEFEF;" src="'.BLOG_URL.$value['img'].'"/></a>';
$by = $value['author'] != 1 ? 'by:'.$user_cache[$value['author']]['name'] : '';
?>
<div class="twcont"><?php echo $value['content'];?><p><?php echo $img;?></p></div>
<div class="twinfo"><?php echo $by.' '.$value['date'];?>
<?php if(ROLE == ROLE_ADMIN): ?>
 <a href="./?action=delt&id=<?php echo $value['id'];?>&token=<?php echo LoginAuth::genToken();?>">删除</a>
<?php endif;?>
</div>
<?php endforeach; ?>
<div id="page"><?php echo $pageurl;?></div>
</div>