<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div id="content">

	<?php if (is_array($logs) && !empty($logs)) :?>

		<?php foreach($logs as $value):  ?>

			<div class="post" id="post-<?php echo $value['logid']; ?>">
				<h1><?php echo $value['toplog']; ?><a href="./?action=showlog&gid=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a></h1>

				<?php echo $value['log_description']; ?>
				<p><?php echo $value['att_img']; ?></p>
				<p><?php echo $value['attachment']; ?></p>
				<div class="post-info">
					<?php echo $value['post_time']; ?> 
					<?php echo $value['tag']; ?> | 
					<a href="./?action=showlog&gid=<?php echo $value['logid']; ?>#comment">评论(<?php echo $value['comnum']; ?>)</a>
					<a href="./?action=showlog&gid=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a> 
					<a href="./?action=showlog&gid=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a>
				</div>
			</div>
		<?php endforeach; ?>

		<div id="pages">
			<?php echo $page_url;?>
		</div>

	<?php else : ?>

		<h1>未找到</h1>
		<p class="center">对不起, 博客暂时还没有任何日志.</p>

	<?php endif; ?>
	
</div>
<?php include getViews('side'); ?>
<?php include getViews('foot'); ?>