<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
include getViews('side');
foreach($logs as $value):
$topFlg = $value['toplog'] == 'y' ? "<img src=\"{$em_tpldir}images/import.gif\" align=\"absmiddle\"  alt=\"推荐日志\" />" : '';
?>
	<div class="logcontent">
	<div id="t">
	<?php echo $topFlg; ?><a href="./?action=showlog&gid=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a>
	</div>
	
	<p id="date"><?php echo $value['post_time']; ?></p>
	<div class="log_desc"><?php echo $value['log_description']; ?></div>
	<p><?php echo $value['attachment']; ?></p>
	<p><?php echo $value['tag']; ?></p>
	
	<div align="right">
	<a href="./?action=showlog&gid=<?php echo $value['logid']; ?>#comment">评论(<?php echo $value['comnum']; ?>)</a>
	<a href="./?action=showlog&gid=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a> 
	<a href="./?action=showlog&gid=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a>
	</div>
	</div>
<?php endforeach; ?>

<div id="pageurl"><?php echo $page_url;?></div>
<?php include getViews('footer'); ?>