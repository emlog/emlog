<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>

<div id="content">
	<div class="left"><div class="lpadding">
		<?php include getViews('side'); ?>
	</div></div>
	<div class="right">
		<?php foreach($logs as $value):?>
		<div class="title">
			<h1>
			<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>" target="_self"><?php echo $value['log_title']; ?></a>
			</h1>
			<h4>
			<?php echo date('Y-n-j G:i l', $value['date']); ?>
			<?php if($log_cache_sort[$value['logid']]): ?>
			<span class="sort"><a href="<?php echo BLOG_URL; ?>?sort=<?php echo $value['sortid']; ?>"><?php echo $log_cache_sort[$value['logid']]; ?></a></span>
			<?php endif;?>
			</h4>
		</div>
		<div class="logdes">
		<?php echo $value['log_description']; ?>
		<p><?php blog_att($value['logid']); ?></p>
		<p><?php blog_tag($value['logid']); ?></p>
		</div>
		<div class="clear"></div>
		<div class="permalink">
		<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>#comment">评论(<?php echo $value['comnum']; ?>)</a>|
		<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a>|
		<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a>
		</div>
		<div class="div1"></div>
		<?php endforeach; ?>
		<div id="pageurl"><?php echo $page_url;?></div>
	</div>
	
	<div class="clear"></div>
</div>
<?php include getViews('footer'); ?>
