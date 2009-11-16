<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="navi">
<a href="./">日志</a> 
<a href="./?action=tw">碎语</a> 
<a href="./?action=com" id="active">评论</a> 
<?php if(ROLE == 'admin' || ROLE == 'writer'): ?>
<a href="./?action=logout">退出</a>
<?php else:?>
<a href="./?action=login">登录</a>
<?php endif;?>
</div>
<div id="m">
	<form method="post" action="./?action=dorep&id=<?php echo $id; ?>">
	<textarea name="reply"><?php echo $reply; ?></textarea><br />
	<input type="submit" value="回复评论" />
	</form>
</div>