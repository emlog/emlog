<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="navi">
<a href="./">日志</a> 
<a href="./?action=tw">碎语</a> 
<a href="./?action=com">评论</a> 
<?php if(ROLE == 'admin' || ROLE == 'writer'): ?>
<a href="./?action=logout">退出</a>
<?php else:?>
<a href="./?action=login" id="active">登录</a>
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