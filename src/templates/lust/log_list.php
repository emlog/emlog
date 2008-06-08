<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
	<div class="maincolumn">
		<div class="clear"></div>
<?php
foreach($logs as $value){
$value['att_img'] = getAttachment($value['att_img'],200,120);
?>
		<div class="post" id="post-<?php echo $value['logid'];?>">
		<div class="wrapper">
			<div class="postmeta">
				<ul>
					<li>Posted on: <?php echo $value['post_time'];?></li>
					<li> 
 	<a href="./?action=showlog&gid=<?php echo $value['logid'];?>#comment">评论(<?php echo $value['comnum'];?>)</a>
 	<a href="./?action=showlog&gid=<?php echo $value['logid'];?>#tb">引用(<?php echo $value['tbcount'];?>)</a> 
 	<a href="./?action=showlog&gid=<?php echo $value['logid'];?>">浏览(<?php echo $value['views'];?>)</a>
					</li>
				</ul>
			</div>
<h2>
<?php echo $value['toplog'];?><a href="./?action=showlog&gid=<?php echo $value['logid'];?>"><?php echo $value['log_title'];?></a>
</h2>

			<div class="entry">
				<?php echo $value['log_description'];?>
<p><?php echo $value['att_img'];?></p>
<p><?php echo $value['attachment'];?></p>
<p><?php echo $value['tag'];?></p>
			</div>

		</div>
		</div>
<?php
}?>
<p><?php echo $page_url;?></p>
</div>
<?php
include getViews('side');
include getViews('footer');
?>