<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="navi">
<a href="./">日志</a> 
<a href="./?action=tw">碎语</a> 
<a href="./?action=com">评论</a> 
<?php if(ROLE == 'admin' || ROLE == 'writer'): ?>
<a href="./?action=logout">退出</a>
<?php else:?>
<a href="./?action=login">登录</a>
<?php endif;?>
</div>
<div id="m">
<div><?php echo $msg;?></div>
<div><a href="<?php echo $url; ?>">返回</a></div>
</div>