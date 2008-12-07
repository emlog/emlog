<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
$datetime = explode(".",$post_time);

?>
      <div id="nav">
        <ul>
          <li class="page_item current_page_item"><a href="./index.php" title="Home">Home</a></li>
        </ul>
      </div>
  <div id="content">
        <div class="post" id="post-$logid">
		  <div class="title">
          <h2><?php echo $log_title;?></h2>
          <div class="postdata"><?php echo $post_time;?></div>
		  </div>
          <div class="entry">
				<?php echo $log_content;?>
<a name="att"></a>
<p><?php echo $attachment;?></p>	
<p><?php echo $tag;?></p>
<p>
<?php if($prevLog):?>
	&laquo; <a href="./?action=showlog&gid=<?php echo $prevLog['gid']; ?>"><?php echo $prevLog['title'];?></a>
<?php endif;?>
<?php if($nextLog && $prevLog):?>
	|
<?php endif;?>
<?php if($nextLog):?>
	<a href="./?action=showlog&gid=<?php echo $nextLog['gid']; ?>"><?php echo $nextLog['title'];?></a>&raquo;
<?php endif;?>
</p>
</div>
<?php if($allow_tb == 'y'): ?>	
<p class="info">
<h2 id="comments">引用：</h2>
<?php echo $blogurl;?>tb.php?sc=<?php echo $tbscode;?>&amp;id=<?php echo $logid;?>
<a name="tb"></a></h2>
</p>
<?php endif; ?>	
<ol class="commentlist">
<?php
foreach($comments as $key=>$value):
$reply = $value['reply']?"<span style=\"color:#669900;\"><b>博主回复</b>：{$value['reply']}</span>":'';
?>
	
		<li class="alt" id="comment-2"><a name="<?php echo $value['cid'];?>"></a>
			<cite><?php echo $value['poster'];?></cite>
					<?php if($value['mail']):?>
						<a href="mailto:<?php echo $value['mail']; ?>" title="发邮件给<?php echo $value['poster']; ?>">Email</a>
					<?php endif;?>
					<?php if($value['url']):?>
						<a href="<?php echo $value['url']; ?>" title="访问<?php echo $value['poster']; ?>的主页" target="_blank">主页</a>
					<?php endif;?>
			 说：
						<br />
			<small class="commentmetadata"> <?php echo $value['date'];?> </small>
			<p><?php echo $value['content'];?></p>
			<p><div id="replycomm<?php echo $value['cid']; ?>"><?php echo $reply;?></div></p>
	<?php if(ISLOGIN === true): ?>	
		<a href="javascript:void(0);" onclick="showhidediv('replybox<?php echo $value['cid']; ?>','reply<?php echo $value['cid']; ?>')">回复</a>
		<div id='replybox<?php echo $value['cid']; ?>' style="display:none;">
		<textarea name="reply<?php echo $value['cid']; ?>" class="input" id="reply<?php echo $value['cid']; ?>" style="overflow-y: hidden;width:360px;height:50px;"><?php echo $value['reply']; ?></textarea>
		<br />
		<a href="javascript:void(0);" onclick="postinfo('./admin/comment.php?action=doreply&cid=<?php echo $value['cid']; ?>&flg=1','reply<?php echo $value['cid']; ?>','replycomm<?php echo $value['cid']; ?>');">提交</a>
		<a href="javascript:void(0);" onclick="showhidediv('replybox<?php echo $value['cid']; ?>')">取消</a>
		</div>
	<?php endif; ?>
		</li>	
<?php  endforeach; ?>	
	</ol>
	
	<ol class="commentlist">
<?php foreach($tb as $key=>$value): ?>
	
		<li class="alt" id="comment-2"><a name="<?php echo $value['cid'];?>"></a>
			<strong>Trackback by:</strong><cite><a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['blog_name'];?></a></cite>
						<br />

			<small class="commentmetadata"> <?php echo $value['date'];?> </small>

			<p><a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['title'];?></a><br/>
	<?php echo $value['excerpt'];?></p>

		</li>	
<?php endforeach; ?>	
	</ol>
<?php if($allow_remark == 'y'): ?>
<h3 id="respond">发布评论</h3>
<form method="post" name="commentform" action="index.php?action=addcom" id="commentform">
<p><input type="text" name="comname" id="comname" value="<?php echo $ckname;?>" size="22" tabindex="1" class="input2"/>
<label for="author">姓名</label>
</p>

<p><input type="text" name="commail" id="commail" value="<?php echo $ckmail;?>" size="22" tabindex="2" class="input2"/>
<label for="email">电子邮件地址 (选填)</label>
</p>

<p><input type="text" name="comurl" id="commail" value="<?php echo $ckurl;?>" size="22" tabindex="2" class="input2"/>
<label for="email">个人主页 (选填)</label>
</p>

<p><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>

<p><?php echo $cheackimg;?><input name="submit" type="submit" id="submit" tabindex="5" value="发布我的评论" onclick="return checkform()"  />
<input type="hidden" name="gid" value="<?php echo $logid;?>" />
<input type="checkbox" name="remember" value="1" checked="checked" />记住我
</p>
</form>
<?php endif; ?>
	</div>

</div>
<div id="footer">Powered by <a href="http://www.emlog.net" title="emlog <?php echo EMLOG_VERSION;?>">emlog</a>
 Theme by <a href="http://www.ndesign-studio.com/">Nick La</a> </div>
</div>
<?php
include getViews('side');
?>