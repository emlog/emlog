<?php 
/*
* 首页日志列表部分
*/
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div id="content">
<?php doAction('index_loglist_top'); ?>
	<div id="posts" class="">
	<?php foreach($logs as $key=>$value): ?>
		<div class="post z-<?php echo 100 - $key; ?> ro<?php echo $key*10; ?>">
			<div class="shaft"></div>
			<h2><?php topflg($value['top']); ?><a href="<?php echo $value['log_url']; ?>"><?php echo $value['log_title']; ?></a></h2>
			<p class="date">作者：<?php blog_author($value['author']); ?> 发布于：<?php echo gmdate('Y-n-j G:i l', $value['date']); ?> 
			<?php blog_sort($value['logid']); ?> 
			<?php editflg($value['logid'],$value['author']); ?>
			</p>
			<?php echo $value['log_description']; ?>
			<p class="tag"><?php blog_tag($value['logid']); ?></p>
			<p class="count">
			<a href="<?php echo $value['log_url']; ?>#comments">评论(<?php echo $value['comnum']; ?>)</a>
			<a href="<?php echo $value['log_url']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a>
			<a href="<?php echo $value['log_url']; ?>">浏览(<?php echo $value['views']; ?>)</a>
			</p>
			<div style="clear:both;"></div>
		</div>
	<?php endforeach; ?>
	</div>
	<div id="pagenavi">
		<?php //echo $page_url;?>
	</div>
</div>
<?php
 //include View::getView('side');
 //include View::getView('footer');
?>