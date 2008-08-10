<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value):
//$value['att_img'] = getAttachment($value['att_img'],200,120);
?>
<div class="content">
            <div class="post" id="post-<?php echo $value['logid'];?>">
<h2>
<?php echo $value['toplog'];?><a href="./?action=showlog&gid=<?php echo $value['logid'];?>"><?php echo $value['log_title'];?></a>
</h2>
			</div>

				<div class="date">
					<span class="postdate">Posted on <?php echo $value['post_time'];?></span>
				</div>
<div class="mypost">

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
<?php endforeach; ?>
<div id="pagenavi"><div class="wp-pagenavi">
<span class="mypost"><?php echo $page_url;?></span>
</div>
</div>

</div>
<?php
include getViews('side');
include getViews('footer');
?>