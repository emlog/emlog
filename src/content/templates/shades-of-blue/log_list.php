<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="content">
	<div id="contentleft">
		<div class="postarea">
			<?php foreach($logs as $value): ?>
			<div class="post">
            <h1><?php topflg($value['top']); ?><a href="./?post=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a></h1>
                <div class="postauthor">
            		<p>Posted by <?php blog_author($value['author']); ?> on <?php echo date('F j, Y', $value['date']); ?> &middot; 
    				<a href="./?post=<?php echo $value['logid']; ?>#comment">评论(<?php echo $value['comnum']; ?>)</a>
					<a href="./?post=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a> 
					<a href="./?post=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a>&nbsp;
					<?php editflg($value['logid'],$value['author']); ?></p>
                </div>
            <?php echo $value['log_description']; ?>
            <?php blog_att($value['logid']); ?>
            <div style="clear:both;"></div>
			<?php blog_sort_and_tag($value['sortid'], $value['logid']); ?>
            </div>
			<?php endforeach; ?>
            <div id="pagenavi"><?php echo $page_url;?></div>
        </div>
	</div>
	<?php include getViews('sidebar');?>
</div>
<!-- The main column ends  -->
<?php include getViews('footer');?>