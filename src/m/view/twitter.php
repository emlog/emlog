<div id="navi">
<a href="./">日志</a> 
<a href="./?action=tw" id="active">碎语</a> 
<a href="./?action=com">评论</a> 
<?php if(ROLE == 'admin' || ROLE == 'writer'): ?>
<a href="./?action=write">写日志</a> 
<a href="./?action=writet">写碎语</a> 
<a href="./?action=logout">退出</a>
<?php else:?>
<a href="./?action=login">登录</a>
<?php endif;?>
</div>
<div id="tw">
<?php foreach($tws as $value):?>
<div class="twcont"><?php echo $value['content'];?></a></div>
<div class="twinfo"><?php echo $value['date'];?></div>
<?php endforeach; ?>

<div id="page"><?php echo $page_url;?></div>
</div>