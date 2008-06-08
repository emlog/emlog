<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>

	<div class="narrowcolumn">
	
<?php
foreach($logs as $value){
$value['att_img'] = getAttachment($value['att_img'],300,280);
?>
<div class="post" id="post-<?php echo $value['logid'];?>">
<h2>
<?php echo $value['toplog'];?><a href="./?action=showlog&gid=<?php echo $value['logid'];?>"><?php echo $value['log_title'];?></a>
</h2>
<div class="postdate"><?php echo $value['post_time'];?></div>
<div class="entry">
<?php echo $value['log_description'];?>
<p><?php echo $value['att_img'];?></p>
<p><?php echo $value['attachment'];?></p>
<p><?php echo $value['tag'];?></p>

<p class="postinfo">
 	<a href="./?action=showlog&gid=<?php echo $value['logid'];?>#comment">评论(<?php echo $value['comnum'];?>)</a>
 	<a href="./?action=showlog&gid=<?php echo $value['logid'];?>#tb">引用(<?php echo $value['tbcount'];?>)</a> 
 	<a href="./?action=showlog&gid=<?php echo $value['logid'];?>">浏览(<?php echo $value['views'];?>)</a>
</p>
</div>
</div>
<?php
}?>
<div class="browse"><?php echo $page_url;?></div>
<?php
?>
</div>
<?php
include getViews('obar');
include getViews('footer');
?>