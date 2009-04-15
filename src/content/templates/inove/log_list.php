<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value):
$topFlg = $value['toplog'] == 'y' ? "<img src=\"{$em_tpldir}images/import.gif\" align=\"absmiddle\"  alt=\"推荐日志\" />" : '';
?>
	<div class="post">
			<h2><?php echo $topFlg; ?><a href="./?action=showlog&gid=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a></h2>
			<div class="info">
				<span class="date"><?php echo date('Y-n-j G:i l', $value['date']); ?></span>
				<div class="act">
					<span class="comments"><a href="./?action=showlog&gid=<?php echo $value['logid']; ?>#comment">(<?php echo $value['comnum']; ?>) 条评论</a></span>
				</div>
			</div>
			<div class="content">
				<p><?php echo $value['log_description']; ?></p>
				<p>
		<?php 
		$attachment = !empty($log_cache_atts[$value['logid']]) ? '<b>文件附件：</b>'.$log_cache_atts[$value['logid']] : '';
		echo $attachment;
		?>
	</p>
				<p class="under">
				<span class="categories"><?php if($log_cache_sort[$value['logid']]): ?>
	<span class="sort">[<a href="./?sort=<?php echo $value['sortid']; ?>"><?php echo $log_cache_sort[$value['logid']]; ?></a>]</span>
	<?php endif;?> <a href="./?action=showlog&gid=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a> 
	<a href="./?action=showlog&gid=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a></span>					<span class="tags"><?php 
		$tag  = !empty($log_cache_tags[$value['logid']]) ? '标签:'.$log_cache_tags[$value['logid']] : '';
		echo $tag;
		?></span>				</p>
			</div>
		</div>

<div class="fixed"></div>
<?php endforeach; ?>
<div id="pagenavi">
<?php echo $page_url;?>
</div>
<div style="clear:both">&nbsp;</div>
<?php 
include getViews('side');
include getViews('footer'); 
?>