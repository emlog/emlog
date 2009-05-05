<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value):
$topFlg = $value['toplog'] == 'y' ? "<img src=\"{$em_tpldir}images/import.gif\" align=\"absmiddle\"  alt=\"推荐日志\" />" : '';
?>



<div class="post">
<h2 class="postTitle"><?php echo $topFlg; ?><a href="./?post=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a></h2>
<p class="postMeta">filed in <?php if($log_cache_sort[$value['logid']]): ?>
	<span class="sort">[<a href="./?sort=<?php echo $value['sortid']; ?>"><?php echo $log_cache_sort[$value['logid']]; ?></a>]</span>
	<?php endif;?> <?php echo date('Y-n-j G:i l', $value['date']); ?></p>
<div class="postContent"><?php echo $value['log_description']; ?>
</div>
<p class="tags"><?php 
		$attachment = !empty($log_cache_atts[$value['logid']]) ? '<b>文件附件：</b>'.$log_cache_atts[$value['logid']] : '';
		echo $attachment;
		?></p>
<p class="tags">	<?php 
		$tag  = !empty($log_cache_tags[$value['logid']]) ? '标签:'.$log_cache_tags[$value['logid']] : '';
		echo $tag;
		?></p>
<p class="comments"><a class="comment_a" href="./?post=<?php echo $value['logid']; ?>#comment">评论(<?php echo $value['comnum']; ?>)</a>
	<a href="./?post=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a> 
	<a href="./?post=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a></p>
</div> <!-- Closes Post -->


<?php endforeach; ?>

<div id="nextprevious">
<?php echo $page_url;?>
</div>

</div></div> <!-- Closes Content -->


<div class="sidebars">
<?php 
include getViews('side');
include getViews('footer'); 
?>