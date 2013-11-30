<?php 
/*
* 首页日志列表部分
*/
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<!-- Article begin -->
<div class="article">
	<?php foreach($logs as $value): ?>
	<div class="post">
		<h2><a href="<?php echo $value['log_url']; ?>" title="<?php echo $value['log_title']; ?>"><?php echo $value['log_title']; ?></a></h2>
		<div class="pmeta">
			<?php echo gmdate('Y-m-d', $value['date']); ?> / <?php blog_author($value['author']); ?> / <?php blog_sort($value['sortid'], $value['logid']); ?> 浏览：<?php echo $value['views']; ?>
			<span class="pcomments"><a href="<?php echo $value['log_url']; ?>#comments"><?php echo $value['comnum']; ?>个评论</a></span>
		</div>
		<?php echo preg_replace('|<p><a href=".*?">阅读全文&gt;&gt;</a>|is','',$value['log_description']); ?>
		<div class="clear"></div>
		<div class="pmeta">
			<?php blog_tag($value['logid'],1); ?>
			<a href="<?php echo $value['log_url']; ?>" title="<?php echo $value['log_title']; ?>" class="readmore">阅读全文</a>
		</div>
	</div>
	<?php endforeach; ?>
    <div class="clear"></div>
    <!-- Navigation begin -->
    <div class="wpagenavi">
		<?php echo $page_url;?>
    </div>
    <!-- Navigation end -->
</div>
<!-- Article end -->
<!-- Sidebar begin -->
	<?php include View::getView('side'); ?>
<!-- Sidebar end -->
<?php include View::getView('footer'); ?>