	<div id="content">
	<ul>
<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
		<li>
		
		<h2 class="content_h2"><?php echo $log_title; ?></h2>
        <?php if($log_cache_sort[$logid]): ?>
        <div class="act">[<a href="./?sort=<?php echo $sortid; ?>"><?php echo $log_cache_sort[$logid]; ?></a>]</div>
<?php endif;?>
					<div class="clear"></div>
		<div class="post"><?php echo $log_content; ?></div>
		
		<div class="under">
		<div class="top"></div>
		<div class="under_p">
			<div><?php 
	$attachment = !empty($log_cache_atts[$logid]) ? '<b>文件附件</b>:'.$log_cache_atts[$logid] : '';
	echo $attachment;
	?></div>
			<div class="tag"><?php 
	$tag = !empty($log_cache_tags[$logid]) ? '标签:'.$log_cache_tags[$logid] : '';
	echo $tag;
	?></div>
			<div class="date"><?php echo $post_time; ?></div>
			<div>&nbsp;</div>
		</div>
        
		<div class="bottom"></div>
		</div>
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
<div id="trackback_address">
<p>引用地址: <input type="text" style="width:350px" class="input" value="<?php echo $blogurl; ?>tb.php?sc=<?php echo $tbscode; ?>&amp;id=<?php echo $logid; ?>"><a name="tb"></a></p>
</div>
<?php endif; ?>

<?php 
foreach($tb as $key=>$value):
?>
	<ul id="trackback">
	<li><a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['title'];?></a></li><li>BLOG: <?php echo $value['blog_name'];?></li><li><?php echo $value['date'];?></li>
    </ul>
<?php endforeach; ?>
<?php if($comments): ?>
<p class="comment"><b>评论：</b><a name="comment"></a></p>
<?php endif; ?>
<?php
foreach($comments as $key=>$value):
$reply = $value['reply']?"<span>博主回复：{$value['reply']}</span>":'';
?>
<div id="com_line">
	<a name="<?php echo $value['cid']; ?>"></a>
	<b><?php echo $value['poster']; ?> </b>
	<?php if($value['mail']):?>
		<a href="mailto:<?php echo $value['mail']; ?>" title="发邮件给<?php echo $value['poster']; ?>">Email</a>
	<?php endif;?>
	<?php if($value['url']):?>
		<a href="<?php echo $value['url']; ?>" title="访问<?php echo $value['poster']; ?>的主页" target="_blank">主页</a>
	<?php endif;?>
		<?php echo $value['date']; ?>
        <div class="com_date">
		<?php echo $value['content']; ?>
        </div>
		<div id="replycomm<?php echo $value['cid']; ?>"><?php echo $reply; ?></div>
	<?php if(ISLOGIN === true): ?>
		<a href="javascript:void(0);" onclick="showhidediv('replybox<?php echo $value['cid']; ?>','reply<?php echo $value['cid']; ?>')">回复</a>
		<div id='replybox<?php echo $value['cid']; ?>' style="display:none;">
		<textarea name="reply<?php echo $value['cid']; ?>" class="input" id="reply<?php echo $value['cid']; ?>" style="overflow-y: hidden;width:360px;height:50px;"><?php echo $value['reply']; ?></textarea>
		<br />
		<a href="javascript:void(0);" onclick="postinfo('./admin/comment.php?action=doreply&cid=<?php echo $value['cid']; ?>&flg=1','reply<?php echo $value['cid']; ?>','replycomm<?php echo $value['cid']; ?>');">提交</a>
		<a href="javascript:void(0);" onclick="showhidediv('replybox<?php echo $value['cid']; ?>')">取消</a>
		</div>
	<?php endif; ?>
</div>
<?php endforeach; ?>
<?php if($allow_remark == 'y'): ?>
<p class="comment"><b>发表评论：</b><a name="comment"></a></p>
<div class="comment_post">
<form method="post"  name="commentform" action="index.php?action=addcom" id="commentform">


<p>

<input type="hidden" name="gid" value="<?php echo $logid; ?>"  size="22" tabindex="1"/>
<input type="text" name="comname" maxlength="49" value="<?php echo $ckname; ?>"  size="22" tabindex="1">
<label for="author"><small>昵称</small></label></p>

<p>
<input type="text" name="commail"  maxlength="128"  value="<?php echo $ckmail; ?>" size="22" tabindex="2"> 

<label for="email"><small>邮件地址 (选填)</small></label></p>

<p><input type="text" name="comurl" maxlength="128"  value="<?php echo $ckurl; ?>" size="22" tabindex="3">
<label for="url"><small>个人主页 (选填)</small></label></p>

<p>
<textarea name="comment" id="comment"  rows="10" tabindex="4"></textarea>
</p>

<p>
<div class="comment_yz"><?php echo $cheackimg; ?><input name="Submit" type="submit" id="comment_submit" value="发表评论" onclick="return checkform()" /></div>
</p>
</form>
</div>
<?php endif; ?>
		</li>
	</ul>
	</div>
	<!--end content-->

<?php 
include getViews('side');
include getViews('footer'); ?>