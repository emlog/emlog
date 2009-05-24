<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div id="nav">
<ul>
<li class="page_item current_page_item"><a href="<?php echo BLOG_URL; ?>" title="Home">Home</a></li>
</ul>
</div>
<div id="content">
<?php foreach($logs as $value):?>
<div class="post">
<div class="date"><span><?php echo date('Y', $value['date']); ?></span>
<?php echo date('j', $value['date']); ?></div>
<div class="title">
<h2>
<?php topflg($value['top']); ?><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a>
<span class="sort"><?php blog_sort($value['sortid'], $value['logid']); ?></span>
</h2>
<div class="postdata">
post by <?php blog_author($value['author']); ?> / <?php echo date('Y-n-j G:i l', $value['date']); ?>
<span class="comments"><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid'];?>#comment" title="<?php echo $value['log_title'];?> 的评论"><?php echo $value['comnum'];?> Comments &#187;</a></span></div>
</div>
<div class="entry">
<?php echo $value['log_description'];?>
<p><?php blog_att($value['logid']); ?></p>
<p><?php blog_tag($value['logid']); ?></p>

<p class="info">
<em class="caty">
 	<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid'];?>#comment">评论(<?php echo $value['comnum'];?>)</a>
 	<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid'];?>#tb">引用(<?php echo $value['tbcount'];?>)</a> 
 	<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid'];?>">浏览(<?php echo $value['views'];?>)</a>
</em>
</p>
</div>

</div>
<?php endforeach; ?>
<p><?php echo $page_url;?></p>

</div>
<div id="footer">Powered by <a href="http://www.emlog.net" title="emlog <?php echo EMLOG_VERSION;?>">emlog</a> Theme by <a href="http://www.ndesign-studio.com/">Nick La</a> 
	<a href="http://www.miibeian.gov.cn" target="_blank"><?php echo $icp; ?></a></div>
</div>
<?php
include getViews('side');
?>