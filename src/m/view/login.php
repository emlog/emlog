<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="navi">
<?php if(ISLOGIN === true): ?><a href="./?action=write">写日志</a> <?php endif;?>
<a href="./">日志</a> 
<a href="./?action=tw">碎语</a> 
<a href="./?action=com">评论</a> 
<?php if(ISLOGIN === true): ?>
<a href="./?action=logout">退出</a>
<?php else:?>
<a href="<?php echo BLOG_URL; ?>m/?action=login" id="active">登录</a>
<?php endif;?>
</div>
<div id="m">
	<form method="post" action="./?action=auth">
		用户名<br />
	    <input type="text" name="user" /><br />
	    密码<br />
	    <input type="password" name="pw" /><br />
	    <?php echo $ckcode; ?>
	    <br /><input type="submit" value=" 登 录" />
	</form>
</div>