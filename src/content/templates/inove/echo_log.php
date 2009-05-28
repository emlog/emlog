<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div class="post" id="post-1">
		<h2><?php topflg($top); ?><?php echo $log_title;?></h2>
		<div class="info">
			<span class="date">post by <?php blog_author($author); ?> / <?php echo date('Y-n-j G:i l', $date); ?> 
			<?php blog_sort($sortid, $logid); ?></span>
			<div class="act">
					<span class="addcomment"><a href="#respond">发表评论</a></span>
					<div class="fixed"></div>
			</div>
			<div class="fixed"></div>
		</div>
		<div class="content">
<?php echo $log_content; ?>
<p><?php blog_att($logid); ?></p>
<p class="under">
<span class="tags"><?php blog_tag($logid); ?></span>			
</p>
<?php doAction('log_related'); ?>
</div>
</div>

<div id="comments">

<div id="cmtswitcher"><?php neighbor_log(); ?>
<div class="fixed"></div>
	<?php blog_trackback(); ?>
	<?php blog_comments(); ?>
	<?php if ($allow_remark == 'y'){blog_comments_post();}?>
</div>
<?php 
include getViews('side');
include getViews('footer');
 ?>