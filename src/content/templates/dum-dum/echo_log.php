<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="content">
<img src="<?php echo CERTEMPLATE_URL; ?>/images/img_08.jpg" alt="" />
	<div class="contenttext">
		<div class="post" id="post-<?php echo $value['logid']; ?>">
			<div class="postheader">
				<div class="postdate">
					<div class="postday"><?php echo date('j', $date); ?></div>
					<div class="postmonth"><?php echo date('m月', $date); ?></div>
				</div> 
				
				<div class="posttitle">
					<h3><?php topflg($top); ?><?php echo $log_title; ?></h3>
				</div> 

				<div class="postmeta">
					<div class="postauthor">by <?php blog_author($author); ?></div> 
					<div class="postcategory"><?php blog_sort($sortid, $logid); ?>
					<?php blog_tag($logid); ?>
					<?php editflg($logid,$author); ?>
					</div> 
				</div> 
			</div> 
			<div style=" clear:both;"></div>
			<div class="posttext">
			<?php echo $log_content; ?>
			<p><?php blog_att($logid); ?></p>
			<?php doAction('log_related'); ?>
			</div> 
		</div> 
		<div><?php neighbor_log(); ?></div>
		<?php blog_trackback(); ?>
		<?php blog_comments(); ?>
		<?php if ($allow_remark == 'y'){blog_comments_post();}?>
		
		</div> 
		<img src="<?php echo CERTEMPLATE_URL; ?>/images/img_09.jpg" style="vertical-align: bottom;" alt="" />
		</div> 
<?php 
include getViews('side');
include getViews('footer'); 
?>