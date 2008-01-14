<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
$att_img = getAttachment($att_img,350,300);
$datetime = explode(".",$post_time);
$year = $datetime[0];
$day = $datetime[1];
print <<<EOT
-->
      <div id="nav">
        <ul>
          <li class="page_item current_page_item"><a href="./index.php" title="Home">Home</a></li>
        </ul>
      </div>
  <div id="content">
        <div class="post" id="post-$logid">
		  <div class="title">
          <h2>$log_title</h2>
          <div class="postdata">$post_time</div>
		  </div>
          <div class="entry">
				$log_content
<a name="att"></a>
<p>$att_img</p>
<p>$attachment</p>	
<p>$tag</p>

          </div><!--/entry -->
		  <p class="info">
<h2 id="comments">引用:<a name="tb"></a></h2>
<p>GBk: {$blogurl}trackback.php?id=$logid&amp;charset=gbk</p>  
<p>UTF-8: {$blogurl}trackback.php?id=$logid&amp;charset=utf-8</p>
</p>


	<ol class="commentlist">
<!--
EOT;
foreach($com as $key=>$value){
print <<<EOT
-->
	
		<li class="alt" id="comment-2"><a name="$value[cid]"></a>
			<cite>$value[poster]</cite> 说：
						<br />

			<small class="commentmetadata"> $value[addtime] </small>

			<p>$value[content]</p>

		</li>	
<!--
EOT;
}print <<<EOT
-->	
	</ol>
	
	<ol class="commentlist">
<!--
EOT;
foreach($tb as $key=>$value){
print <<<EOT
-->
	
		<li class="alt" id="comment-2"><a name="$value[cid]"></a>
			<strong>Trackback by:</strong><cite><a href="$value[url]" target="_blank">$value[blog_name]</a></cite>
						<br />

			<small class="commentmetadata"> $value[date] </small>

			<p><a href="$value[url]" target="_blank">$value[title]</a><br/>
	$value[excerpt]</p>

		</li>	
<!--
EOT;
}print <<<EOT
-->	
	</ol>

<h3 id="respond">发布评论</h3>

<form method="post" name="commentform" action="index.php?action=addcom" id="commentform">
<p><input type="text" name="comname" id="comname" value="" size="22" tabindex="1" class="input2"/>
<label for="author"><strong>姓名</strong></label>
</p>

<p><input type="text" name="commail" id="commail" value="" size="22" tabindex="2" class="input2"/>
<label for="email"><strong>电子邮件地址</strong> (选填)</label></p>

<p><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>

<p>$cheackimg <input name="submit" type="submit" id="submit" tabindex="5" value="发布我的评论" onclick="return checkform()"  />
<input type="hidden" name="gid" value="$logid" />
<input type="checkbox" name="remember" value="1" checked="checked" />记住我
</p>

</form>

	</div><!--/post -->

</div><!--/content -->
<div id="footer">&copy; 2007 <a href="http://www.emlog.net" target="_blank">emlog</a> Theme by <a href="http://www.ndesign-studio.com/">Nick La</a> </div>
</div>
EOT;
include getViews('side');
?>