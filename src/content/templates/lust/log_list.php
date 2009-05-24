<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div class="maincolumn">
<div class="clear"></div>
<?php
foreach($logs as $value):
?>
		<div class="post" id="post-<?php echo $value['logid'];?>">
		<div class="wrapper">
			<div class="postmeta">
				<ul>
					<li>Posted on: <?php echo date('Y-n-j G:i l', $value['date']); ?></li>
					<li> 
						<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid'];?>#comment">评论(<?php echo $value['comnum'];?>)</a>
						<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid'];?>#tb">引用(<?php echo $value['tbcount'];?>)</a> 
						<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid'];?>">浏览(<?php echo $value['views'];?>)</a>
					</li>
				</ul>
			</div>
<h2>
<?php echo $topFlg; ?><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid'];?>"><?php echo $value['log_title'];?></a>
<?php if($log_cache_sort[$value['logid']]): ?>
<span class="sort"><a href="<?php echo BLOG_URL; ?>?sort=<?php echo $value['sortid']; ?>">[<?php echo $log_cache_sort[$value['logid']]; ?>]</a></span>
<?php endif;?>
</h2>

<div class="entry">
<?php echo $value['log_description'];?>
<p><?php blog_att($value['logid']); ?></p>
<p><?php blog_tag($value['logid']); ?></p>
</div>
</div>
</div>
<?php endforeach; ?>
<p><?php echo $page_url;?></p>
</div>
<?php
include getViews('side');
include getViews('footer');
?>