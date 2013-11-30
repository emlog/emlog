<?php 
/*
* 首页日志列表部分
*/
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div id="content">
	<?php doAction('index_loglist_top'); ?>
	<?php foreach($logs as $value): ?>
	<div class="post" id="post-<?php echo $value['logid']; ?>">
		<h2><?php topflg($value['top']); ?><a href="<?php echo $value['log_url']; ?>"><?php echo $value['log_title']; ?></a></h2>
		<div class="post-meta">
			<a href="<?php echo $value['log_url']; ?>#commentlist"><?php echo $value['comnum']; ?>条评论</a> / <a href="<?php echo $value['log_url']; ?>">被围观<?php echo $value['views']; ?>次</a> / <?php blog_author($value['author']); ?><?php blog_sort($value['logid']); ?> / <?php echo gmdate('Y年n月j日', $value['date']); ?> <?php editflg($value['logid'],$value['author']); ?></div>
		<div class="description"><?php echo preg_replace("/<p class=\"readmore\"><a href=\"[^\"]+\">阅读全文&gt;&gt;<\/a><\/p>/i","",$value['log_description']); ?></div>
		<div class="more">
			<a href="<?php echo $value['log_url']; ?>">阅读全文</a>
		</div>
		<?php blog_tag($value['logid']); ?>
	</div>
	<?php endforeach; ?>
	<div id="pagenavi">
		<?php echo $page_url;?>
	</div>
</div><!--end content-->
<?php include View::getView('side'); include View::getView('footer'); ?>