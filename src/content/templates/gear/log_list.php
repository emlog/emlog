			<div class="content span-24">
				<div class="posts span-17 last">
					<div class="paddings">
						<ul class="items">
<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value):
?>
<li>
<h2>
	<?php topflg($value['top']); ?><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a>
</h2>
<div class="info">
<span class="date">post by <?php blog_author($value['author']); ?> / <?php echo date('Y-n-j G:i l', $value['date']); ?></span>
<span class="sort"><?php blog_sort($value['sortid'], $value['logid']); ?></span>
<?php editflg($value['logid'],$value['author']); ?>
</div>
	<div class="paddings-p"><?php echo $value['log_description']; ?></div>
	<p><?php blog_att($value['logid']); ?></p>
	<div class="clear"></div>
	<div class="info">
    <p><?php blog_tag($value['logid']); ?></p>
	<span class="comment">
	<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>#comment">评论(<?php echo $value['comnum']; ?>)</a>
	<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a> 
	<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a>
	</span>
</div>								
</li>	
<div class="clear"></div>    
<?php endforeach; ?>
<li>
<div class="navigation">
<?php echo $page_url;?>
<div class="clear"></div>
</div>
</li>
</ul>
</div>
</div>

<div class="sidebar span-7 last">
<div class="paddings">
                
<?php
include getViews('side');
include getViews('footer'); ?>