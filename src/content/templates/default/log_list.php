<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="content">
<ul>
<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value):
$topFlg = $value['toplog'] == 'y' ? "<img src=\"{$em_tpldir}images/import.gif\" align=\"absmiddle\"  alt=\"推荐日志\" />" : '';
?>
	<li>
	<h2 class="content_h2">
	<?php echo $topFlg; ?><a href="./?action=showlog&gid=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a>
	</h2>
	<?php blog_sort($value['logid']); ?>

	<div class="clear"></div>
	<div class="post"><?php echo $value['log_description']; ?></div>
	<?php blog_att($value['logid']); ?>
	<div class="under">
	<div class="top"></div>
	<div class="under_p">
	<?php blog_tag($value['logid']); ?>
	<div class="date"><?php echo date('Y-n-j G:i l', $value['date']); ?></div>
	<div>
	<a href="./?action=showlog&gid=<?php echo $value['logid']; ?>#comment">评论(<?php echo $value['comnum']; ?>)</a>
	<a href="./?action=showlog&gid=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a> 
	<a href="./?action=showlog&gid=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a>
	</div>
	</div>
	<div class="bottom"></div>
	</div>
	</li>
<?php endforeach; ?>
</ul>
<div id="pagenavi">
	<?php echo $page_url;?>
</div>
</div>
<!--end content-->
<?php
 include getViews('sidebar');
 include getViews('footer'); 
?>