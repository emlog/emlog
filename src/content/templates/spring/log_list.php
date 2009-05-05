<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value):
$topFlg = $value['toplog'] == 'y' ? "<img src=\"{$em_tpldir}images/import.gif\" align=\"absmiddle\"  alt=\"推荐日志\" />" : '';
?>
<div class="post" id="post-<?php echo $value['logid'];?>">
<h2 class="posttitle">
<?php echo $topFlg; ?><a href="./?post=<?php echo $value['logid'];?>"><?php echo $value['log_title'];?></a>
</h2>

<p class="postmeta"> 
Posted on <?php echo date('Y-n-j G:i l', $value['date']); ?><br />
<a href="./?post=<?php echo $value['logid'];?>#comment">评论(<?php echo $value['comnum'];?>)</a>
<a href="./?post=<?php echo $value['logid'];?>#tb">引用(<?php echo $value['tbcount'];?>)</a> 
<a href="./?post=<?php echo $value['logid'];?>">浏览(<?php echo $value['views'];?>)</a>
<?php if($log_cache_sort[$value['logid']]): ?>
 <a href="./?sort=<?php echo $value['sortid']; ?>"><?php echo $log_cache_sort[$value['logid']]; ?></a>
<?php endif;?>
</p>
<div class="postentry">
<?php echo $value['log_description'];?>
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
</div>
<?php endforeach; ?>
<div class="browse"><?php echo $page_url;?></div>

</div>
<?php
include getViews('side');
include getViews('footer');
?>