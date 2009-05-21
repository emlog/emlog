<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value):
?>
	<div class="post">
		<h2><?php topflg($value['top']); ?><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a></h2>
			<div class="date"><?php echo date('Y-n-j G:i l', $value['date']); ?></div>
					<div class="entry">
						<p><?php echo $value['log_description']; ?></p>
						<p><?php blog_att($value['logid']); ?></p>
						<p><?php blog_tag($value['logid']); ?></p>
						<div class="commentbubble">
						<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>#comment"><?php echo $value['comnum']; ?></a>
						</div>
						
						<p class="postmetadata">
						Filed under&#58;<br />
						<?php blog_sort($value['sortid'], $value['logid']); ?>
						<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a> 
						<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a>
						</p>
					</div>
			</div>
<?php endforeach; ?>
<div class="navigation">
<?php echo $page_url;?>				
</div>
</div>
<?php 
include getViews('side');
include getViews('footer'); 
?>