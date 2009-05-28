<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="content">
<div class="entry single">

<h1>
<?php topflg($top); ?><?php echo $log_title;?>
<span class="sort"><?php blog_sort($sortid, $logid); ?></span>
</h1>

<p class="info">
<em class="date">post by <?php blog_author($author); ?> /  <?php echo date('Y-n-j G:i l', $date); ?></em>
</p>
<div class="post"><?php echo $log_content;?></div>
<p><?php blog_att($logid); ?></p>
<p><?php blog_tag($logid); ?></p>
<?php doAction('log_related'); ?>
<p><?php neighbor_log(); ?></p>
</div>
	<?php blog_trackback(); ?>
<div class="comments-template">
	<?php blog_comments(); ?>
	<?php if ($allow_remark == 'y'){blog_comments_post();}?>
</div>
</div>
<?php
include getViews('side');
include getViews('footer');
?>