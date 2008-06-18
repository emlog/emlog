<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value):
$value['att_img'] = getAttachment($value['att_img'],200,120);
?>
<h2>
<?php echo $value['toplog'];?><a href="./?action=showlog&gid=<?php echo $value['logid'];?>"><?php echo $value['log_title'];?></a>
</h2>
<p class="postdata">Posted in <?php echo $value['post_time'];?></p>
<div id="content_post">
				<p><?php echo $value['log_description'];?></p>
				<p><?php echo $value['att_img'];?></p>
				<p><?php echo $value['attachment'];?></p>
				<p class="tags"><?php echo $value['tag'];?></p>
				<p class="postinfo" >				  
 	<a href="./?action=showlog&gid=<?php echo $value['logid'];?>#comment">评论(<?php echo $value['comnum'];?>)</a>
 	<a href="./?action=showlog&gid=<?php echo $value['logid'];?>#tb">引用(<?php echo $value['tbcount'];?>)</a> 
 	<a href="./?action=showlog&gid=<?php echo $value['logid'];?>">浏览(<?php echo $value['views'];?>)</a>
				</p>
</div>
<?php endforeach; ?>
<p><?php echo $page_url;?></p>
</div>
<?php
?>
<?php
include getViews('side');
include getViews('footer');
?>
