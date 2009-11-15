<div id="navi">
<a href="./">日志</a> 
<a href="./?action=tw" id="active">碎语</a> 
<a href="./?action=com">评论</a> 
<?php if(ROLE == 'admin' || ROLE == 'writer'): ?>
<a href="./?action=logout">退出</a>
<?php else:?>
<a href="./?action=login">登录</a>
<?php endif;?>
</div>
<div id="m">
<?php if(ROLE == 'admin' || ROLE == 'writer'): ?>
<form method="post" action="./?action=t" >
<input name="t" value=""  /> <input type="submit" value="发碎语" />
</form>
<?php endif;?>
<?php foreach($tws as $value):?>
<div class="twcont"><?php echo $value['content'];?></a></div>
<div class="twinfo"><?php echo $value['date'];?>
<?php if(ROLE == 'admin'): ?>
 <a href="./?action=delt&id=<?php echo $value['id'];?>">删除</a>
<?php endif;?>
</div>
<?php endforeach; ?>
<div id="page"><?php echo $page_url;?></div>
</div>