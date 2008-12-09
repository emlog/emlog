<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div id="content">
<?php
foreach($logs as $value):
$topFlg = $value['toplog'] == 'y' ? "<img src=\"{$em_tpldir}images/import.gif\" align=\"absmiddle\"  alt=\"推荐日志\" />" : '';
?>
<div class="entry single">
<h1>
<?php echo $topFlg; ?><a href="./?action=showlog&gid=<?php echo $value['logid'];?>"><?php echo $value['log_title'];?></a>
</h1>
<p class="info">
<em class="date">Posted on <?php echo $value['post_time'];?></em>
</p>
<?php echo $value['log_description'];?>
<p><?php echo $value['att_img'];?></p>
<p><?php echo $value['attachment'];?></p>
<p><?php echo $value['tag'];?></p>
<p class="info">
<em class="caty">
 	<a href="./?action=showlog&gid=<?php echo $value['logid'];?>#comment">评论(<?php echo $value['comnum'];?>)</a>
 	<a href="./?action=showlog&gid=<?php echo $value['logid'];?>#tb">引用(<?php echo $value['tbcount'];?>)</a> 
 	<a href="./?action=showlog&gid=<?php echo $value['logid'];?>">浏览(<?php echo $value['views'];?>)</a>
</em>
</p>
</div>
<?php endforeach; ?>
<p><?php echo $page_url;?></p>
</div>
<?php
include getViews('side');
include getViews('footer');
?>