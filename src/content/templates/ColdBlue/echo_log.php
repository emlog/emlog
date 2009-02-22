<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
	<div class="post" id="post-1">
			
			<div class="post-title">
				<h2><?php echo $log_title; ?></h2>
				<h3><?php echo $post_time; ?>  |   <?php if($log_cache_sort[$logid]): ?>
<span class="sort">[<a href="./?sort=<?php echo $sortid; ?>"><?php echo $log_cache_sort[$logid]; ?></a>]</span>
<?php endif;?></h3>
			</div>

			<div class="post-content">
				<?php echo $log_content; ?>
			</div>
			
			<p>
	<?php 
	$attachment = !empty($log_cache_atts[$logid]) ? '<b>文件附件</b>:'.$log_cache_atts[$logid] : '';
	echo $attachment;
	?>
</p>
<span>	<?php 
	$tag = !empty($log_cache_tags[$logid]) ? '标签:'.$log_cache_tags[$logid] : '';
	echo $tag;
	?></span>
	<div class="nextlog">
<?php if($prevLog):?>
	&laquo; <a href="./?action=showlog&gid=<?php echo $prevLog['gid']; ?>"><?php echo $prevLog['title'];?></a>
<?php endif;?>
<?php if($nextLog && $prevLog):?>
	|
<?php endif;?>
<?php if($nextLog):?>
	 <a href="./?action=showlog&gid=<?php echo $nextLog['gid']; ?>"><?php echo $nextLog['title'];?></a>&raquo;
<?php endif;?>
</div>
<?php if($allow_tb == 'y'):?>	
<div id="trackback1">
<p><b>引用地址：</b> <input type="text" style="width:350px" class="input" value="<?php echo $blogurl; ?>tb.php?sc=<?php echo $tbscode; ?>&amp;id=<?php echo $logid; ?>"><a name="tb"></a></p>
</div>
<?php endif; ?>

<?php 
foreach($tb as $key=>$value):
?>
<div class="trackback">
	<li><a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['title'];?></a> </li>
	<li>BLOG: <?php echo $value['blog_name'];?></li>
	<li><?php echo $value['date'];?></li>
</div>
<?php endforeach; ?>
<!-- You can start editing here. -->

	<ul class="post-comments clear">
		<?php if($comments): ?>
<h3>评论:<a name="comment"></a></h3>
<?php endif; ?>
		
<?php
foreach($comments as $key=>$value):
$reply = $value['reply']?"<span><b>博主回复</b>：{$value['reply']}</span>":'';
?>
	
		<li class="comment clear alt" id="comment-1">
			<cite class="comment-author"><a name="<?php echo $value['cid']; ?>"></a>
	<b><?php echo $value['poster']; ?> </b>		
	</cite>
			<div class="comment-content">
								<p><?php echo $value['content']; ?>
		<div id="replycomm<?php echo $value['cid']; ?>"><?php echo $reply; ?></div><br /><?php echo $value['date']; ?><?php if($value['mail']):?>
		<a  href="mailto:<?php echo $value['mail']; ?>" title="发邮件给<?php echo $value['poster']; ?>">Email</a>
	<?php endif;?>
	<?php if($value['url']):?>
		<a href="<?php echo $value['url']; ?>" title="访问<?php echo $value['poster']; ?>的主页" target="_blank">主页</a>
	<?php endif;?>
		<?php if(ISLOGIN === true): ?>
		<a href="javascript:void(0);" onclick="showhidediv('replybox<?php echo $value['cid']; ?>','reply<?php echo $value['cid']; ?>')">回复</a>
		<div id='replybox<?php echo $value['cid']; ?>' style="display:none;">
		<textarea name="reply<?php echo $value['cid']; ?>" class="input" id="reply<?php echo $value['cid']; ?>" style="overflow-y: hidden;width:360px;height:50px;"><?php echo $value['reply']; ?></textarea>
		<br />
		<a href="javascript:void(0);" onclick="postinfo('./admin/comment.php?action=doreply&cid=<?php echo $value['cid']; ?>&flg=1','reply<?php echo $value['cid']; ?>','replycomm<?php echo $value['cid']; ?>');">提交</a>
		<a href="javascript:void(0);" onclick="showhidediv('replybox<?php echo $value['cid']; ?>')">取消</a>
		</div>
	<?php endif; ?>
	</p>
			</div>
		</li>
<?php endforeach; ?>		
	</ul>

 

<?php if($allow_remark == 'y'): ?>
<h3>发表评论</h3>


<form method="post"  name="commentform" action="index.php?action=addcom" id="commentform">


<p>

<input type="hidden" name="gid" value="<?php echo $logid; ?>"  size="22" tabindex="1"/>
<input type="text" name="comname" maxlength="49" value="<?php echo $ckname; ?>"  size="22" tabindex="1">
<label for="author"><small>Name (required)</small></label></p>

<p>
<input type="text" name="commail"  maxlength="128"  value="<?php echo $ckmail; ?>" size="22" tabindex="2"> 

<label for="email"><small>Mail</small></label></p>

<p><input type="text" name="comurl" maxlength="128"  value="<?php echo $ckurl; ?>" size="22" tabindex="3">
<label for="url"><small>Website</small></label></p>

<p>
<textarea name="comment" id="comment" cols="60" rows="10" tabindex="4"></textarea>
</p>

<p>
<?php echo $cheackimg; ?><input name="Submit" type="submit" value="发表评论" onclick="return checkform()" />
</p>
</form>
<?php endif; ?>
		</div>	
	</div>
	<ul id="sidebar">
<?php
include getViews('side');
include getViews('footer'); ?>