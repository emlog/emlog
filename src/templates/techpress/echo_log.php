<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
//$att_img = getAttachment($att_img,600,500);
?>
		<div class="narrowcolumn">
			<div class="post">
				<h2><?php echo $log_title;?></h2>
				<div class="postdate"><?php echo $post_time;?></div>
				<div class="entry"><?php echo $log_content;?>
<a name="att"></a>
<p><?php echo $att_img;?></p>
<p><?php echo $attachment;?></p>	
<p><?php echo $tag;?></p>
<p><?php echo $neighborLog;?></P>
<p class="postinfo"></p>
</div>
</div>

<?php if($allow_tb == 'y'): ?>	
<div class="comments-template">
<h2 id="comments">引用:<a name="tb"></a></h2>
<input type="text" id="input" style="width:350px" value="<?php echo $blogurl;?>tb.php?sc=<?php echo $tbscode;?>&amp;id=<?php echo $logid;?>" /><a name="tb"></a>
</div>
<?php endif; ?>	

<div class="comments-template">
<h2 id="comments"><a name="comment"></a>评论</h2>

<p></p>

<ol id="commentlist">
<?php
foreach($com as $key=>$value):
$value['reply'] = $value['reply']?"<span style=\"color:green;\"><b>博主回复</b>：{$value['reply']}</span>":'';
?>
	<li id="comment-<?php echo $value['cid'];?>"><a name="<?php echo $value['cid'];?>"></a>
	<cite>Comment by <strong><?php echo $value['poster'];?></strong> &#8212; <?php echo $value['addtime'];?></cite>
	<br /><?php echo $value['content'];?><br /><?php echo $value['reply'];?></li>
<?php  endforeach; ?>
</ol>

<ol id="commentlist">
<?php foreach($tb as $key=>$value): ?>
	<li id="comment-<?php echo $value['cid'];?>">
	<cite>Trackback by <strong><a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['blog_name'];?></a></strong> &#8212; <?php echo $value['date'];?></cite><br/>
	<a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['title'];?></a><br/>
	<?php echo $value['excerpt'];?>
	</li>
<?php endforeach; ?>
</ol>
<?php if($allow_remark == 'y'): ?>
<h2>发表评论</h2>
<p></p>

<form method="post"  name="commentform" action="index.php?action=addcom" id="commentform">
<input type="hidden" name="gid" value="<?php echo $logid;?>" />
<p><input type="text" name="comname" id="author" value="<?php echo $ckname;?>" size="40" tabindex="1" />
<label for="author"><small>姓名</small></label></p>

<p><input type="text" name="commail" id="email" value="<?php echo $ckmail;?>" size="40" tabindex="2" />
<label for="email"><small>电子邮件 (选填)</small></label></p>

<p><input type="text" name="comurl" id="email" value="<?php echo $ckurl;?>" size="40" tabindex="2" />
<label for="email"><small>个人主页 (选填)</small></label></p>

<p><textarea name="comment" id="comment" cols="60" rows="10" tabindex="4"></textarea></p>

<p><input name="submit" type="submit" id="submit" tabindex="5" value="发表我的评论" />
<?php echo $cheackimg;?> 
<input type="checkbox" name="remember" value="1" checked="checked" class="inp" /><small>记住我</small></p>
</form>
<?php endif; ?>
</div>
<?php
?>
</div>
<?php
include getViews('side');
include getViews('footer');
?>