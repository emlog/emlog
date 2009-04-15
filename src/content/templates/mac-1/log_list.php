<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div id="nav">
<ul>
<li class="page_item current_page_item"><a href="./index.php" title="Home">Home</a></li>
</ul>
</div>
<div id="content">
<?php
foreach($logs as $value):
$topFlg = $value['toplog'] == 'y' ? "<img src=\"{$em_tpldir}images/import.gif\" align=\"absmiddle\"  alt=\"推荐日志\" />" : '';
?>
<div class="post" id="post-<?php echo $value['logid'];?>">
<div class="date"><span><?php echo date('Y', $value['date']); ?></span>
<?php echo date('j', $value['date']); ?></div>
<div class="title">
<h2>
<?php echo $topFlg; ?><a href="./?action=showlog&gid=<?php echo $value['logid'];?>"><?php echo $value['log_title'];?></a>
<?php if($log_cache_sort[$value['logid']]): ?>
<span class="sort"><a href="./?sort=<?php echo $value['sortid']; ?>">[<?php echo $log_cache_sort[$value['logid']]; ?>]</a></span>
<?php endif;?>
</h2>
<div class="postdata">
<span class="comments"><a href="./?action=showlog&gid=<?php echo $value['logid'];?>#comment" title="<?php echo $value['log_title'];?> 的评论"><?php echo $value['comnum'];?> Comments &#187;</a></span></div>

</div>
<div class="entry">
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

<p class="info">
<em class="caty">
 	<a href="./?action=showlog&gid=<?php echo $value['logid'];?>#comment">评论(<?php echo $value['comnum'];?>)</a>
 	<a href="./?action=showlog&gid=<?php echo $value['logid'];?>#tb">引用(<?php echo $value['tbcount'];?>)</a> 
 	<a href="./?action=showlog&gid=<?php echo $value['logid'];?>">浏览(<?php echo $value['views'];?>)</a>
</em>
</p>
          </div>

	</div>
<?php endforeach; ?>
<p><?php echo $page_url;?></p>

</div>
<div id="footer">Powered by <a href="http://www.emlog.net" title="emlog <?php echo EMLOG_VERSION;?>">emlog</a> Theme by <a href="http://www.ndesign-studio.com/">Nick La</a> 
	<a href="http://www.miibeian.gov.cn" target="_blank"><?php echo $icp; ?></a></div>
</div>
<?php
include getViews('side');
?>