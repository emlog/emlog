<?php 
/*
* 首页日志列表部分
*/
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div id="content">
<div id="contentleft">
<?php doAction('index_loglist_top'); ?>
<?php foreach($logs as $value): ?>
	<h2><?php topflg($value['top']); ?><a href="<?php echo $value['log_url']; ?>"><?php echo $value['log_title']; ?></a></h2>
	<p class="date">作者：<?php blog_author($value['author']); ?> 发布于：<?php echo gmdate('Y-n-j G:i l', $value['date']); ?>
	<?php blog_sort($value['sortid'], $value['logid']); ?>
	</p>
	<?php echo $value['log_description']; ?>
	<p class="att"><?php blog_att($value['logid']); ?></p>
	<p class="tag"><?php blog_tag($value['logid']); ?></p>
	<p class="count">
	<a href="<?php echo $value['log_url']; ?>#comment">评论(<?php echo $value['comnum']; ?>)</a>
	<a href="<?php echo $value['log_url']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a>
	<a href="<?php echo $value['log_url']; ?>">浏览(<?php echo $value['views']; ?>)</a>
	</p>
	<div style="clear:both;"></div>
<?php endforeach; ?>

<div id="pagenavi">
	<?php echo $page_url;?>
</div>

</div>
<!--end content-->
<?php
 include View::getView('side');
 include View::getView('footer');
?>