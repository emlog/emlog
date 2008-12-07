<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="maincolumn">
		<div class="clear"></div>

		
		<div class="post" id="post-7"><div class="wrapper">

			<div class="postmeta">
				<ul>
					<li>Posted on: <?php echo $post_time;?></li>
				</ul>
			</div>

			<h2><?php echo $log_title;?></h2>

			<div class="entry">
				<p><?php echo $log_content;?></p>
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

		</div></div>
<?php if($allow_tb == 'y'): ?>	
<div class="entry">
<h2 id="comments">引用:<a name="tb"></a></h2>
<input type="text" id="input" style="width:350px" value="<?php echo $blogurl;?>tb.php?sc=<?php echo $tbscode;?>&amp;id=<?php echo $logid;?>" /><a name="tb"></a>
</div>
<?php endif; ?>	
		
		<div class="clear"></div>
<div class="comments_template"><div class="wrapper">

<ol class="commentlist">
<?php
foreach($comments as $key=>$value):
$reply = $value['reply']?"<span style=\"color:green;\"><b>博主回复</b>：{$value['reply']}</span>":'';
?>
	<li id="comment-<?php echo $value['cid'];?>">
			<div class="commentmeta">
			<ul>
				<li>
					<a name="<?php echo $value['cid'];?>"></a>评论：<strong><?php echo $value['poster'];?></strong>
					<?php if($value['mail']):?>
						<a href="mailto:<?php echo $value['mail']; ?>" title="发邮件给<?php echo $value['poster']; ?>">Email</a>
					<?php endif;?>
					<?php if($value['url']):?>
						<a href="<?php echo $value['url']; ?>" title="访问<?php echo $value['poster']; ?>的主页" target="_blank">主页</a>
					<?php endif;?>
				</li>
				<li><a href="#comment-2" title=""><?php echo $value['date'];?></a></li>
			</ul>
			</div>
			<div class="commenentry">
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
			</div>

		</li>
<?php endforeach; ?>
	
	</ol>
<ol class="commentlist">
<?php foreach($tb as $key=>$value): ?>
	<li id="comment-<?php echo $value['cid'];?>">
			<div class="commentmeta">
			<ul>
				<li>引用：<strong><a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['blog_name'];?></a></strong></li>
				<li><?php echo $value['date'];?></li>
			</ul>
			</div>

			<div class="commenentry">
				
				<p>	<a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['title'];?></a><br/>
	<?php echo $value['excerpt'];?></p>
			</div>

		</li>
<?php endforeach; ?>
	
	</ol>
<a name="comment"></a>
<div class="comments_form">
<?php if($allow_remark == 'y'): ?>
<h3 id="respond">发表你的评论</h3>
<form  method="post"  name="commentform" action="index.php?action=addcom" id="commentform">
	<p>
	  <input type="text" name="comname" id="email" value="<?php echo $ckname;?>" size="40" tabindex="1" />
	   <label for="author"><small>姓名</small></label>
	<input type="hidden" name="gid" value="<?php echo $logid;?>" />
	</p>

	<p>
	  <input type="text" name="commail" id="email" value="<?php echo $ckmail;?>" size="40" tabindex="2" />
	   <label for="email"><small>邮件地址(选填)</small></label>
	</p>
	<p>
	  <input type="text" name="commurl" id="email" value="<?php echo $ckurl;?>" size="40" tabindex="2" />
	   <label for="email"><small>个人主页(选填)</small></label>
	</p>
	<p>
	  <label for="comment"><small>评论内容</small></label>
	  <br />
	  <textarea name="comment" id="comment" cols="60" rows="10" tabindex="4"></textarea>
	</p>

	<p>
	 <input name="submit" type="submit" tabindex="5" value="发布我的评论" onclick="return checkform()" /><?php echo $cheackimg;?> <input type="checkbox" name="remember" value="1" checked="checked" /><small>记住我</small></td>
	</p>
</form>
<?php endif; ?>
</div>
</div></div>
<div class="clear"></div>	
</div>
<?php
include getViews('side');
include getViews('footer');
?>