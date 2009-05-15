<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div class="content">
<img src="<?php echo CERTEMPLATE_URL; ?>/images/img_08.jpg" alt="" />
	<div class="contenttext">
<?php 
foreach($logs as $value):
$topFlg = $value['toplog'] == 'y' ? "<img src=\"{$em_tpldir}images/import.gif\" align=\"absmiddle\"  alt=\"置顶日志\" />" : '';
?>

		<div class="post" id="post-<?php echo $value['logid']; ?>">
			<div class="postheader">
				<div class="postdate">
					<div class="postday"><?php echo date('j', $value['date']); ?></div>
					<div class="postmonth"><?php echo date('Y', $value['date']); ?></div>
				</div> <!-- POST DATE -->
				
				<div class="posttitle">
					<h3><?php echo $topFlg; ?><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a></h3>
				</div> <!-- POST TITLE -->

				<div class="postmeta">
					<div class="postauthor">by <?php echo $name; ?></div> <!-- POST AUTHOR -->
					<div class="postcategory">
					<?php if($log_cache_sort[$value['logid']]): ?>
					分类：<a href="<?php echo BLOG_URL; ?>?sort=<?php echo $value['sortid']; ?>"><?php echo $log_cache_sort[$value['logid']]; ?></a>
					<?php endif;?>
					<?php 
					$tag  = !empty($log_cache_tags[$value['logid']]) ? '标签:'.$log_cache_tags[$value['logid']] : '';
					echo $tag;
					?>
					</div> <!-- POST CATEGORY -->
				</div> <!-- POST META -->
			</div> <!-- POST HEADER -->
			<div style=" clear:both;"></div>
			<div class="posttext">
				<?php echo $value['log_description']; ?>
					<p>
				<?php 
				$attachment = !empty($log_cache_atts[$value['logid']]) ? '<b>文件附件：</b>'.$log_cache_atts[$value['logid']] : '';
				echo $attachment;
				?>
				</p>
				<p>
					<?php 
					$tag  = !empty($log_cache_tags[$value['logid']]) ? '标签:'.$log_cache_tags[$value['logid']] : '';
					echo $tag;
					?>
				</p>
			</div>
			<div style="clear:both;"></div>
			<div class="postfooter" style="">
				<div class="postcomments"><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>#comment">评论：(<?php echo $value['comnum']; ?>)</a></div> <!-- POST COMMENTS -->
				<div class="posttags"><div class="posttags2"><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a> </div> <!-- POST TAGS 2 --></div> <!-- POST TAGS -->
				<div class="postnr"><div class="postnrtext"><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>" title="浏览：<?php echo $value['views']; ?> 次"><?php echo $value['views']; ?></a></div> <!-- POST NR TEXT --></div> <!-- POST NR -->
			</div> <!-- POST FOOTER -->
		</div> <!-- POST -->
		<?php endforeach; ?>
	<div class="postcategory"><?php echo $page_url;?></div>
	</div> <!-- CONTENT TEXT -->
<img src="<?php echo CERTEMPLATE_URL; ?>/images/img_09.jpg" style="vertical-align: bottom;" alt="" />
</div> <!-- CONTENT -->

<?php
include getViews('side'); 
include getViews('footer');
?>