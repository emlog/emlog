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
	<h2><?php topflg($value['top'], $value['sortop'], isset($sortid)?$sortid:''); ?><a href="<?php echo $value['log_url']; ?>"><?php echo $value['log_title']; ?></a></h2>
	<p class="date"><?php echo gmdate('Y-m-d', $value['date']); ?> <?php blog_author($value['author']); ?> 
	<?php blog_sort($value['logid']); ?> 
	<?php editflg($value['logid'],$value['author']); ?>
	</p>
	<?php echo $value['log_description']; ?>
	<p class="tag"><?php blog_tag($value['logid']); ?></p>
	<p class="count">
	<a href="<?php echo $value['log_url']; ?>#comments"><? echo $lang['number_of_comments']; ?> (<?php echo $value['comnum']; ?>)</a>
	<a href="<?php echo $value['log_url']; ?>"><? echo $lang['views']; ?> (<?php echo $value['views']; ?>)</a>
	</p>
	<div style="clear:both;"></div>
<?php 
endforeach;
else:
?>
	<h2><? echo $lang['not_found']; ?></h2>
	<p><? echo $lang['search_no_results']; ?></p>
<?php endif;?>

<div id="pagenavi">
	<?php echo $page_url;?>
</div>

</div><!-- end #contentleft-->
<?php
 include View::getView('side');
 include View::getView('footer');
?>