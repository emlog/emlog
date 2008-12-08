<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value):
?>
		<div class="post" id="post-<?php echo $value['logid'];?>">
<h2 class="posttitle">
<?php echo $value['toplog'];?><a href="./?action=showlog&gid=<?php echo $value['logid'];?>"><?php echo $value['log_title'];?></a>
</h2>

<p class="postmeta"> 
Posted on <?php echo $value['post_time'];?><br />
 	<a href="./?action=showlog&gid=<?php echo $value['logid'];?>#comment">评论(<?php echo $value['comnum'];?>)</a>
 	<a href="./?action=showlog&gid=<?php echo $value['logid'];?>#tb">引用(<?php echo $value['tbcount'];?>)</a> 
 	<a href="./?action=showlog&gid=<?php echo $value['logid'];?>">浏览(<?php echo $value['views'];?>)</a>

</p>
<div class="postentry">
<?php echo $value['log_description'];?>
<p><?php echo $value['att_img'];?></p>
<p><?php echo $value['attachment'];?></p>
<p><?php echo $value['tag'];?></p>
</div>
</div>
<?php endforeach; ?>
<div class="browse"><?php echo $page_url;?></div>

</div>
<?php
include getViews('side');
include getViews('footer');
?>