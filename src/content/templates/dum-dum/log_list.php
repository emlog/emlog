<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="content">
<img src="<?php echo CERTEMPLATE_URL; ?>/images/img_08.jpg" alt="" />
<div class="contenttext">
<?php foreach($logs as $value):?>
		<div class="post" id="post-<?php echo $value['logid']; ?>">
			<div class="postheader">
				<div class="postdate">
					<div class="postday"><?php echo date('j', $value['date']); ?></div>
					<div class="postmonth"><?php echo date('m月', $value['date']); ?></div>
				</div>
				<div class="posttitle">
					<h3><?php topflg($value['top']); ?><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a></h3>
				</div>
				<div class="postmeta">
					<div class="postauthor">by <?php blog_author($value['author']); ?></div>
					<div class="postcategory">
					<?php blog_sort($value['sortid'], $value['logid']); ?>
					<?php blog_tag($value['logid']); ?>
					<?php editflg($value['logid'],$value['author']); ?>
					</div>
				</div>
			</div>
			<div style=" clear:both;"></div>
			<div class="posttext">
				<?php echo $value['log_description']; ?>
				<p><?php blog_att($value['logid']); ?></p>
			</div>
			<div style="clear:both;"></div>
			<div class="postfooter" style="">
				<div class="postcomments"><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>#comment">评论：(<?php echo $value['comnum']; ?>)</a></div> <!-- POST COMMENTS -->
				<div class="posttags"><div class="posttags2"><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a> </div> <!-- POST TAGS 2 --></div> <!-- POST TAGS -->
				<div class="postnr"><div class="postnrtext"><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>" title="浏览：<?php echo $value['views']; ?> 次"><?php echo $value['views']; ?></a></div> <!-- POST NR TEXT --></div> <!-- POST NR -->
			</div>
		</div>
		<?php endforeach; ?>
	<div class="postcategory"><?php echo $page_url;?></div>
	</div>
<img src="<?php echo CERTEMPLATE_URL; ?>/images/img_09.jpg" style="vertical-align: bottom;" alt="" />
</div>
<?php
include getViews('side'); 
include getViews('footer');
?>