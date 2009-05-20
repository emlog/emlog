<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<?php foreach($logs as $value): ?>
<div class="post">
<h2 class="postTitle"><?php topflg($value['top']); ?><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a></h2>
<p class="postMeta">filed in <?php blog_sort($value['sortid'], $value['logid']); ?>
<span class="sort">post by <?php blog_author($value['author']); ?> / <?php echo date('Y-n-j G:i l', $value['date']); ?></span> <?php editflg($logid,$author); ?></p>
<div class="postContent"><?php echo $value['log_description']; ?></div>
<p class="tags"><?php blog_att($value['logid']); ?></p>
<p class="tags"><?php blog_tag($value['logid']); ?></p>
<p class="comments"><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>#comment">评论(<?php echo $value['comnum']; ?>)</a>
	<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a> 
	<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a>
</p>
</div>
<?php endforeach; ?>
<div id="nextprevious">
<?php echo $page_url;?>
</div>
</div></div>
<div class="sidebars">
<?php
include getViews('side');
include getViews('footer'); 
?>