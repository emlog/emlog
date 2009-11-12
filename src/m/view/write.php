<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="navi">
<a href="./" id="active">日志</a> 
<a href="./?action=tw">碎语</a> 
<a href="./?action=com">评论</a> 
<?php if(ROLE == 'admin' || ROLE == 'writer'): ?>
<a href="./?action=write">写日志</a> 
<a href="./?action=writet">写碎语</a> 
<a href="./?action=logout">退出</a>
<?php else:?>
<a href="./?action=login">登录</a>
<?php endif;?>
</div>
<div id="log">
<?php foreach($logs as $value): ?>
<div class="logtitle"><a href="./?post=<?php echo $value['logid'];?>"><?php echo $value['log_title']; ?></a></div>
<div class="loginfo"><?php echo date('Y-n-j G:i', $value['date']); ?> (评论:<?php echo $value['comnum']; ?> 阅读:<?php echo $value['views']; ?>)</div>
<?php endforeach; ?>
<div id="page"><?php echo $page_url;?></div>
</div>