<div id="navi"><a href="./">日志</a> <a href="./?action=tw">碎语</a> <a href="./?action=com" id="active">评论</a></div>
<div id="comment">
<?php foreach($com_cache as $value):?>
<div class="comcont"><a href="#"><?php echo $value['content']; ?></a></div>
<div class="cominfo"><?php echo $value['name']; ?></div>
<?php endforeach; ?>
</div>