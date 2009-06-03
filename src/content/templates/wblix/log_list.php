<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="content">
<?php foreach($logs as $value):?>
<div class="entry single">
<h1>
<?php topflg($value['top']); ?><a href="./?post=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a> 
<span class="sort"><?php blog_sort($value['sortid'], $value['logid']); ?></span>
</h1>
<p class="info">
<em class="date">
<?php echo date('Y-n-j G:i l', $value['date']); ?> / post by <?php blog_author($value['author']); ?> 
<?php editflg($value['logid'],$value['author']); ?>
</em>
</p>
<div class="post"><?php echo $value['log_description'];?></div>
<p><?php blog_att($value['logid']); ?></p>
<p><?php blog_tag($value['logid']); ?></p>
<p class="info">
<em class="caty">
 	<a href="./?post=<?php echo $value['logid'];?>#comment">评论(<?php echo $value['comnum'];?>)</a>
 	<a href="./?post=<?php echo $value['logid'];?>#tb">引用(<?php echo $value['tbcount'];?>)</a> 
 	<a href="./?post=<?php echo $value['logid'];?>">浏览(<?php echo $value['views'];?>)</a>
</em>
</p>
</div>
<?php endforeach; ?>
<p><?php echo $page_url;?></p>
</div>
<?php
include getViews('side');
include getViews('footer');
?>