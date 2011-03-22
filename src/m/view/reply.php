<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="navi">
<a href="./">首页</a> 
<a href="./?action=tw">碎语</a> 
<a href="./?action=com" id="active">评论</a> 
<?php if(ISLOGIN === true): ?>
<a href="./?action=write">写日志</a> 
<a href="./?action=logout">退出</a>
<?php else:?>
<a href="<?php echo BLOG_URL; ?>m/?action=login">登录</a>
<?php endif;?>
</div>
<div id="m">
	<div class="comcont">回复<b><?php echo $poster; ?></b>：<?php echo $comment; ?></div>
	<form method="post" action="./?action=addcom&gid=<?php echo $gid; ?>&pid=<?php echo $cid; ?>">
	昵称<br /><input type="text" name="comname" value="" /><br />
	邮件地址 (选填)<br /><input type="text" name="commail" value="" /><br />
	个人主页 (选填)<br /><input type="text" name="comurl" value="" /><br />
	内容<br /><textarea name="comment" rows="10"></textarea><br />
	<?php echo $verifyCode; ?><br /><input type="submit" value="发表评论" />
	</form>
</div>