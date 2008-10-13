<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
//$att_img = getAttachment($att_img,600,500);
?>

<div id="content">
	<div class="left"><div class="lpadding">
		<?php include getViews('side'); ?>
	</div></div>
	<div class="right">
		<div class="title">
			<h1><?php echo $log_title; ?></a></h1>
			<h4><?php echo $tag; ?> by <?php echo $log_author; ?> on <?php echo $post_time; ?></h4>
		</div>
		<div class="logdes"><?php echo $log_content; ?>
		<p><?php echo $att_img; ?></p>
		<p><?php echo $attachment; ?></p>
		</div>
		<div class="clear"></div>
		<div class="nextlog">
		<?php if($previousLog):?>
		&laquo; <a href="./?action=showlog&gid=<?php echo $previousLog['gid']; ?>"><?php echo $previousLog['title'];?></a>
		<?php endif;?>
		<?php if($nextLog && $previousLog):?>
		|
		<?php endif;?>
		<?php if($nextLog):?>
	 	<a href="./?action=showlog&gid=<?php echo $nextLog['gid']; ?>"><?php echo $nextLog['title'];?></a>&raquo;
		<?php endif;?>
		</div>
		<div class="permalink">
		<?php if($allow_tb == 'y'):?>	
		<div>
		<p><b>引用地址：</b> <input type="text" style="width:350px;border:0" class="input" value="<?php echo $blogurl; ?>tb.php?sc=<?php echo $tbscode; ?>&amp;id=<?php echo $logid; ?>"><a name="tb"></a></p>
		</div>
		<?php endif; ?>
		<?php foreach($tb as $key=>$value):?>
		<div>
		<li>来自: <a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['blog_name'];?></a></li>
    	<li>标题: <a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['title'];?></a> </li>
    	<li>摘要:<?php echo $value['excerpt'];?></li>
		<li>引用时间:<?php echo $value['date'];?></li>
		</div>
		<?php endforeach; ?>
		<?php if($com): ?>
		<h2 id="comments">评论:</h2><a name="comment"></a>
		<?php endif; ?>
		<div id="commentlist">
		<?php
			foreach($com as $key=>$value):
			$reply = $value['reply']?"<span style=\"color:#248CE5\"><b>博主回复</b>：{$value['reply']}</span>":'';
		?>
		<div id="com_line">
		<a name="<?php echo $value['cid']; ?>"></a>
		<b><?php echo "<span style=\"color:#248CE5\">".$value['poster']."</span>"; ?> </b>
		<?php if($value['mail']):?>
		<a href="mailto:<?php echo $value['mail']; ?>" title="发邮件给<?php echo $value['poster']; ?>">Email</a>
		<?php endif;?>
		<?php if($value['url']):?>
		<a href="<?php echo $value['url']; ?>" title="访问<?php echo $value['poster']; ?>的主页" target="_blank">主页</a>
		<?php endif;?>
		<?php echo $value['addtime']; ?>
		<br /><?php echo $value['content']; ?>
		<div id="replycomm<?php echo $value['cid']; ?>"><?php echo $reply; ?></div>
		<?php if(ISLOGIN === true): ?>	
		<a href="javascript:void(0);" onclick="showhidediv('replybox<?php echo $value['cid']; ?>','reply<?php echo $value['cid']; ?>')">回复</a>
		<div id='replybox<?php echo $value['cid']; ?>' style="display:none;">
		<textarea name="reply<?php echo $value['cid']; ?>" class="input" id="reply<?php echo $value['cid']; ?>" style="overflow-y: hidden;width:360px;height:50px;"><?php echo $value['reply']; ?></textarea>
		<br />
		<a href="javascript:void(0);" onclick="postinfo('./adm/comment.php?action=doreply&cid=<?php echo $value['cid']; ?>&flg=1','reply<?php echo $value['cid']; ?>','replycomm<?php echo $value['cid']; ?>');">提交</a>
		<a href="javascript:void(0);" onclick="showhidediv('replybox<?php echo $value['cid']; ?>')">取消</a>
		</div>
		<?php endif; ?>
		</div>
		<?php endforeach; ?>
		</div>
		<?php if($allow_remark == 'y'): ?>
		<h2 id="postcomment">Leave a comment</h2>
		<form action="index.php?action=addcom" method="post" id="commentform">
		<p><input type="hidden" name="gid" value="<?php echo $logid; ?>" /></p>
		<p><input type="text" name="comname" id="author" value="<?php echo $ckname; ?>" size="32" tabindex="1" />
		<label for="author"><small>Name (required)</small></label></p>
		<p><input type="text" name="commail" id="email" value="<?php echo $ckmail; ?>" size="52" tabindex="2" />
		<label for="email"><small>Mail (will not be published) (required)</small></label></p>
		<p><input type="text" name="comurl" id="url" value="<?php echo $ckurl; ?>" size="52" tabindex="3" />
		<label for="url"><small>Website</small></label></p>
		<p><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>
		<p><?php echo $cheackimg; ?><input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" />
		<input type="checkbox" name="remember" value="1" checked="checked" />Remember me
		</p>
		</form>
		<?php endif; ?>
		</div>
		<div class="div1"></div>
	</div>
	
	<div class="clear"></div>
</div>
<?php include getViews('footer'); ?>
