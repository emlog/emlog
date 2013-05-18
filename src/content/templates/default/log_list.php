<?php 
/**
* Blog post list
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div id="content">
<div id="contentleft">
<?php doAction('index_loglist_top'); ?>

<?php 
if (!empty($logs)):
foreach($logs as $value): 
?>
	<h2><?php topflg($value['top']); ?><a href="<?php echo $value['log_url']; ?>"><?php echo $value['log_title']; ?></a></h2>
	<p class="date"><? echo $lang['author']; ?>: <?php blog_author($value['author']); ?>, <? echo $lang['posted_on']; ?>: <?php echo gmdate('Y-n-j G:i l', $value['date']); ?> 
	<?php blog_sort($value['logid']); ?> 
	<?php editflg($value['logid'],$value['author']); ?>
	</p>
	<?php echo $value['log_description']; ?>
	<p class="tag"><?php blog_tag($value['logid']); ?></p>
	<p class="count">
	<a href="<?php echo $value['log_url']; ?>#comments"><? echo $lang['number_of_comments']; ?> (<?php echo $value['comnum']; ?>)</a>
	<a href="<?php echo $value['log_url']; ?>#tb"><? echo $lang['number_of_trackbacks']; ?> (<?php echo $value['tbcount']; ?>)</a>
	<a href="<?php echo $value['log_url']; ?>"><? echo $lang['views']; ?> (<?php echo $value['views']; ?>)</a>
	</p>
	<div style="clear:both;"></div>
<?php 
endforeach;
else:
?>
	<h2>未找到</h2>
	<p>抱歉，没有符合您查询条件的结果。</p>
<?php endif;?>

<div id="pagenavi">
	<?php echo $page_url;?>
</div>

</div><!-- end #contentleft-->
<?php
 include View::getView('side');
 include View::getView('footer');
?>