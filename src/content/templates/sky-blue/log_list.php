<?php 
/*
* 首页日志列表部分
*/
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div id="content">
<?php doAction('index_loglist_top'); ?>
    <?php foreach($logs as $value): ?>
    <div class="top_post"></div>
    <div class="post" id="post-<?php echo $value['logid']; ?>">
        <div class="byline">
            <div class="date"><p class="month"><?php echo gmdate('M', $value['date']); ?></p><p class="day"><?php echo gmdate('j', $value['date']); ?></p><p class="year"><?php echo gmdate('Y', $value['date']); ?></p></div>
            <h2 class="title"><a href="<?php echo $value['log_url']; ?>"><?php echo $value['log_title']; ?></a></h2>
        </div>
        <div class="entry clear"><?php echo $value['log_description']; ?></div>
        <div class="meta">
            <p class="tags clear"><?php blog_tag($value['logid']); ?></p>
            <p class="links taginfo"><?php blog_sort($value['sortid'], $value['logid']); ?></p>
    	</div>
    </div>
    <div class="bottom_post"></div>
	<?php endforeach; ?>
    <div class="top_post"></div>
    	<div class="post">
    		<div class="entry"><div class="pagenavi"><?php echo $page_url;?></div></div>
    	</div>
    <div class="bottom_post"></div>
    </div>
<!-- end Content -->
	<?php include View::getView('side'); ?>
</div>
<!-- end Page -->
<?php include View::getView('footer'); ?>