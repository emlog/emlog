<?php 
/*
* 首页日志列表部分
*/
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div id="content">
<?php doAction('index_loglist_top'); ?>
	<div id="posts" class="">
		<div class="prev post-nav"></div>
		<?php foreach($logs as $key=>$value): ?>
		<div class="post br10 tile<?php echo getColorSet($value['date']); ?>" data-id="<?php echo $value['logid']; ?>">
			<h2><a href="<?php echo $value['log_url']; ?>"><?php echo $value['log_title']; ?></a></h2>
			<p class="date">
				发布于：<?php echo gmdate('Y-n-j G:i l', $value['date']); ?> 
				<?php blog_sort($value['logid']); ?> 
			</p>
			<p class="count">
			<a href="<?php echo $value['log_url']; ?>#comments">评论(<?php echo $value['comnum']; ?>)</a>
			<a href="<?php echo $value['log_url']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a>
			<a href="<?php echo $value['log_url']; ?>">浏览(<?php echo $value['views']; ?>)</a>
			</p>
			<div style="clear:both;"></div>
		</div>
		<?php endforeach; ?>
		<div class="next post-nav"></div>
	</div>
	<div id="pagenavi">
		<?php //echo $page_url;?>
	</div>
</div>
<?php
 //include View::getView('side');
 //include View::getView('footer');
?>
