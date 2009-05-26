<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="post" id="post-$logid">
<h2>
<?php topflg($top); ?><?php echo $log_title;?>
<?php if($log_cache_sort[$logid]): ?>
<span class="sort"><?php blog_sort($sortid, $logid); ?></span>
<?php endif;?>
</h2>
<div class="entry">
<?php echo $log_content;?>
<p><?php blog_att($logid); ?></p>
<p><?php blog_tag($logid); ?></p>
<p>Posted on <?php echo date('Y-n-j G:i l', $date); ?><br /></p>
<p><?php neighbor_log(); ?></p>

</div>
<?php blog_trackback(); ?>
<?php blog_comments(); ?>
<?php if ($allow_remark == 'y'){blog_comments_post();}?>
</div>
</div>
<?php
include getViews('side');
include getViews('footer');
?>