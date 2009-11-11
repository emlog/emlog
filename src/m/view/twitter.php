<div id="navi"><a href="./">日志</a> <a href="./?action=tw" id="active">碎语</a> <a href="./?action=com">评论</a></div>
<div id="tw">
<?php foreach($tws as $value):?>
<div class="twcont"><?php echo $value['content'];?></a></div>
<div class="twinfo"><?php echo $value['date'];?></div>
<?php endforeach; ?>

<div id="page"><?php echo $page_url;?></div>
</div>