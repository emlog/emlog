<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value):
$topFlg = $value['toplog'] == 'y' ? "<img src=\"{$em_tpldir}images/import.gif\" align=\"absmiddle\"  alt=\"推荐日志\" />" : '';
?>
	<div class="post">
		<h2><?php echo $topFlg; ?><a href="./?post=<?php echo $value['logid']; ?>"><b><?php echo $value['log_title']; ?></b></a></h2>
			<div class="date"><?php echo date('Y-n-j G:i l', $value['date']); ?></div>
					<div class="entry">
						<p><?php echo $value['log_description']; ?></p>
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
						<div class="commentbubble">
						<a href="./?post=<?php echo $value['logid']; ?>#comment"><?php echo $value['comnum']; ?></a>
						</div>
						
						<p class="postmetadata">
						Filed under&#58;<br />
						<?php if($log_cache_sort[$value['logid']]): ?>
						<span class="sort">[<a href="./?sort=<?php echo $value['sortid']; ?>"><?php echo $log_cache_sort[$value['logid']]; ?></a>]</span>
						<?php endif;?>
						<a href="./?post=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a> 
						<a href="./?post=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a>
						</p>
					</div>
			</div>
<?php endforeach; ?>
<div class="navigation">
<?php echo $page_url;?>				
</div>
</div>
<?php 
include getViews('side');
include getViews('footer'); 
?>