<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value):
	$datetime = explode("-",$value['post_time']);
	$year = $datetime['0'] . "/" .$datetime['1'];
	$day = substr($datetime['2'],0,2);
	$topFlg = $value['toplog'] == 'y' ? "<img src=\"{$em_tpldir}images/import.gif\" align=\"absmiddle\"  alt=\"推荐日志\" />" : '';
?>
<div class="post">
	<div class="postdate">
	  <p class="date"><?php echo $day;?>th</p>
	  <p class="year"><?php echo $year;?></p>
	</div>
	<div class="posttitle">
    <h2>
<?php echo $topFlg; ?><a href="./?action=showlog&gid=<?php echo $value['logid'];?>"><?php echo $value['log_title'];?></a>
	</h2>
    <p class="postmeta">
 	<a href="./?action=showlog&gid=<?php echo $value['logid'];?>#tb">引用(<?php echo $value['tbcount'];?>)</a> 
 	<a href="./?action=showlog&gid=<?php echo $value['logid'];?>">浏览人次(<?php echo $value['views'];?>)</a>
 	<?php if($log_cache_sort[$value['logid']]): ?>
	<span class="sort"><a href="./?sort=<?php echo $value['sortid']; ?>">[<?php echo $log_cache_sort[$value['logid']]; ?>]</a></span>
	<?php endif;?>
	<span class="comment"><a href="./?action=showlog&gid=<?php echo $value['logid'];?>#comment">评论:<?php echo $value['comnum'];?></a></span>
</p>
</div>
<div class="content">
	<p><?php echo $value['log_description'];?></p>
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
	<p><?php echo $value['tag'];?></p>
	<p class="postinfo">			
</div>
<p>
	
</p>				

</div>
<?php endforeach; ?>
<div class="nav">
<p><?php echo $page_url;?></p>
</div>
</div>
</div>
<?php
include getViews('footer');
?>