<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
$att_img = getAttachment($att_img,350,300);
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
<p><?php echo $att_img;?></p>
<p><?php echo $attachment;?></p>	
<p><?php echo $tag;?></p>
<p><?php echo $neighborLog;?></P>
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
foreach($com as $key=>$value):
$value['reply'] = $value['reply']?"<span style=\"color:#669900;\"><b>博主回复</b>：{$value['reply']}</span>":'';
?>
	
		<li class="alt" id="comment-2"><a name="<?php echo $value['cid'];?>"></a>
			<cite><?php echo $value['poster'];?></cite> 说：
						<br />
			<small class="commentmetadata"> <?php echo $value['addtime'];?> </small>
			<p><?php echo $value['content'];?></p>
			<p><?php echo $value['reply'];?></p>
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
<div id="footer">&copy; 2008 Powered by <a href="http://www.emlog.net" target="_blank">emlog</a> Theme by <a href="http://www.ndesign-studio.com/">Nick La</a> </div>
</div>
<?php
include getViews('side');
?>