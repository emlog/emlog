<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="navi">
<a href="./">首页</a> 
<a href="./?action=tw" id="active">碎语</a> 
<a href="./?action=com">评论</a> 
<?php if(ISLOGIN === true): ?>
<a href="./?action=write">写日志</a> 
<a href="./?action=logout">退出</a>
<?php else:?>
<a href="<?php echo BLOG_URL; ?>m/?action=login">登录</a>
<?php endif;?>
</div>
<div id="m">
<?php if(ISLOGIN === true): ?>
<form method="post" action="./index.php?action=t" enctype="multipart/form-data">
碎语内容：<br />
<textarea cols="20" rows="3" name="t"></textarea><br />
选择要上传的图片:<br />
<input type="file" name="img" /><br />
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
<?php if(ISLOGIN === true && $value['author'] == UID || ROLE == 'admin'): ?>
 <a href="./?action=delt&id=<?php echo $value['id'];?>">删除</a>
<?php endif;?>
</div>
<?php endforeach; ?>
<div id="page"><?php echo $pageurl;?></div>
</div>