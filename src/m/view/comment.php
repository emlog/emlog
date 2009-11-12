<div id="navi">
<a href="./">日志</a> 
<a href="./?action=tw">碎语</a> 
<a href="./?action=com" id="active">评论</a> 
<?php if(ROLE == 'admin' || ROLE == 'writer'): ?>
<a href="./?action=write">写日志</a> 
<a href="./?action=writet">写碎语</a> 
<a href="./?action=logout">退出</a>
<?php else:?>
<a href="./?action=login">登录</a>
<?php endif;?>
</div>
<div id="comment">
<?php foreach($com_cache as $value):?>
<div class="comcont"><a href="#"><?php echo $value['content']; ?></a></div>
<div class="cominfo"><?php echo $value['name']; ?></div>
<?php endforeach; ?>
</div>