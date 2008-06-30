
<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
//$att_img = getAttachment($att_img,500,300);
?>
<h2><?php echo $log_title;?></h2>
<p class="postdata">Posted in $post_time</p>
<div id="content_post">	
		<p><?php echo $log_content;?></p>
		<a name="att"></a>
		<p><?php echo $att_img;?></p>
		<p><?php echo $att_img;?></p>	
		<p class="tags"><?php echo $tag;?></p>
		<p>
		<?php if($previousLog):?>
			&laquo; <a href="./?action=showlog&gid=<?php echo $previousLog['gid']; ?>"><?php echo $previousLog['title'];?></a>
		<?php endif;?>
		<?php if($nextLog && $previousLog):?>
			|
		<?php endif;?>
		<?php if($nextLog):?>
			 <a href="./?action=showlog&gid=<?php echo $nextLog['gid']; ?>"><?php echo $nextLog['title'];?></a>&raquo;
		<?php endif;?>
		</p>
		</div>
<?php if($allow_tb == 'y'): ?>	
	<div class="comments-template">
	<h2 id="comments">引用：<input type="text" style="width:350px" id="email" value="<?php echo $blogurl;?>tb.php?sc=<?php echo $tbscode;?>&amp;id=<?php echo $logid;?>"><a name="tb"></a></h2>
	</div>
<?php endif; ?>	


<div id="comments"><div class="content_c">

<h2 id="comments"><a name="comment"></a>评论</h2>

<p></p>

<ol class="commentlist">
<?php
foreach($com as $key=>$value):
$value['reply'] = $value['reply']?"<span style=\"color:green;\"><b>博主回复</b>：{$value['reply']}</span>":'';
?>
	<li class="alt" id="comment-<?php echo $value['cid'];?>"><a name="<?php echo $value['cid'];?>"></a>
			<?php echo $value['poster'];?> 
			<?php if($value['mail']):?>
				<a href="mailto:<?php echo $value['mail']; ?>" title="发邮件给<?php echo $value['poster']; ?>">Email</a>
			<?php endif;?>
			<?php if($value['url']):?>
				<a href="<?php echo $value['url']; ?>" title="访问<?php echo $value['poster']; ?>的主页" target="_blank">主页</a>
			<?php endif;?>
			Says:<br />
			<small class="commentmetadata"><?php echo $value['addtime'];?> </small>
			<p><?php echo $value['content'];?></p>
			<p><?php echo $value['reply'];?></p>
	</li>	
	
<?php endforeach; ?>
</ol>

<ol class="commentlist">
<?php foreach($tb as $key=>$value): ?>
	<li id="comment-<?php echo $value['cid'];?>">
	<cite>trackback by <strong><a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['blog_name'];?></a></strong> &#8212; <?php echo $value['date'];?></cite><br/>
	<a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['title'];?></a><br/>
	<?php echo $value['excerpt'];?>
	</li>
<?php endforeach; ?>
</ol>
<?php if($allow_remark == 'y'): ?>
<h2>发表评论</h2>
<p></p>

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
	  <input type="text" name="comurl" id="email" value="<?php echo $ckurl;?>" size="40" tabindex="2" />
	   <label for="email"><small>个人主页(选填)</small></label>
	</p>
	<p>
	  <textarea name="comment" id="comment" cols="55" rows="15" tabindex="4"></textarea>
	</p>

	<p>
	 <input name="submit" type="submit" tabindex="5" value="发布我的评论" onclick="return checkform()" /><?php echo $cheackimg;?> <input type="checkbox" name="remember" value="1" checked="checked" /><small>记住我</small></td>
	</p>
</form>
<?php endif; ?>
</div>
</div>
</div>
<?php
include getViews('side');
include getViews('footer');
?>