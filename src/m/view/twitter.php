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
<form method="post" action="./?action=t" >
<input name="t" value="" /> <input type="submit" value="发碎语" />
</form>
<?php endif;?>
<?php 
foreach($tws as $value):
$by = $value['author'] != 1 ? 'by:'.$user_cache[$value['author']]['name'] : '';
?>
<div class="twcont"><?php echo $value['content'];?></a></div>
<div class="twinfo"><?php echo $by.' '.$value['date'];?>
<?php if(ISLOGIN === true && $value['author'] == UID || ROLE == 'admin'): ?>
 <a href="./?action=delt&id=<?php echo $value['id'];?>">删除</a>
<?php endif;?>
</div>
<?php endforeach; ?>
<div id="page"><?php echo $pageurl;?></div>
</div>