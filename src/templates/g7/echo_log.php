<!--
<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
//$att_img = getAttachment($att_img,500,300);
echo <<<EOT
-->
<div class="content">
		<div class="post" id="post-$logid">
			<h2>$log_title</h2></div>
		<div class="mypost">
				$log_content
		<a name="att"></a>
		<p>$att_img</p>
		<p>$attachment</p>	
		<p>$tag</p>
		<p>Posted on $post_time<br /></p>
		</div>
	<div class="comments-template">
	<h2 id="comments">引用:<a name="tb"></a></h2>
	<p>GBk: {$blogurl}trackback.php?id=$logid&amp;charset=gbk</p>  
	<p>UTF-8: {$blogurl}trackback.php?id=$logid&amp;charset=utf-8</p>
	</div>
</div>


<div id="comments"><div class="content_c">

<h2 id="comments"><a name="comment"></a>评论</h2>

<p></p>

<ol class="commentlist">
<!--
EOT;
foreach($com as $key=>$value){
echo <<<EOT
-->
	<li class="alt" id="comment-$value[cid]"><a name="$value[cid]"></a>
			$value[poster] Says:<br />
			<small class="commentmetadata">$value[addtime] </small>
			<p>$value[content]	</p>
	</li>	
	
<!--
EOT;
}echo <<<EOT
-->
</ol>

<ol class="commentlist">
<!--
EOT;
foreach($tb as $key=>$value){
echo <<<EOT
-->
	<li id="comment-$value[cid]">
	<cite>trackback by <strong><a href="$value[url]" target="_blank">$value[blog_name]</a></strong> &#8212; $value[date]</cite><br/>
	<a href="$value[url]" target="_blank">$value[title]</a><br/>
	$value[excerpt]
	</li>
<!--
EOT;
}echo <<<EOT
-->
</ol>

<h2>发表评论</h2>
<p></p>

<form  method="post"  name="commentform" action="index.php?action=addcom" id="commentform">
	<p>
	  <input type="text" name="comname" id="email" value="$ckname" size="40" tabindex="1" />
	   <label for="author"><small>姓名</small></label>
	<input type="hidden" name="gid" value="$logid" />
	</p>

	<p>
	  <input type="text" name="commail" id="email" value="$ckmail" size="40" tabindex="2" />
	   <label for="email"><small>邮件地址</small></label>
	</p>

	<p>
	  <textarea name="comment" id="comment" cols="55" rows="15" tabindex="4"></textarea>
	</p>

	<p>
	 <input name="submit" type="submit" tabindex="5" value="发布我的评论" onclick="return checkform()" /> $cheackimg <input type="checkbox" name="remember" value="1" checked="checked" /><small>记住我</small></td>
	</p>
</form>

</div></div>
</div>
EOT;
include getViews('side');
include getViews('footer');
?>