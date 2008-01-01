<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
//$att_img = getAttachment($att_img,600,500);
print <<<EOT
-->
		<div class="narrowcolumn">
			<div class="post">
				<div class="postdate">$post_time</div>
				<h2>$log_title</h2>
				<div class="entry">
				$log_content
<a name="att"></a>
<p>$att_img</p>
<p>$attachment</p>	
<p>$tag</p>

				<p class="postinfo">
				</p>

				</div>
			</div>

<div class="comments-template">
<h2 id="comments">引用:<a name="tb"></a></h2>
<p>GBk: {$blogurl}trackback.php?id=$logid&amp;charset=gbk</p>  
<p>UTF-8: {$blogurl}trackback.php?id=$logid&amp;charset=utf-8</p>
</div>


<div class="comments-template">
<h2 id="comments"><a name="comment"></a>评论</h2>

<p></p>

<ol id="commentlist">
<!--
EOT;
foreach($com as $key=>$value){
print <<<EOT
-->
	<li id="comment-$value[cid]"><a name="$value[cid]"></a>
	<cite>Comment by <strong>$value[poster]</strong> &#8212; $value[addtime]</cite>
	<br />
	$value[content]	</li>
<!--
EOT;
}print <<<EOT
-->
</ol>

<ol id="commentlist">
<!--
EOT;
foreach($tb as $key=>$value){
print <<<EOT
-->
	<li id="comment-$value[cid]">
	<cite>Trackback by <strong><a href="$value[url]" target="_blank">$value[blog_name]</a></strong> &#8212; $value[date]</cite><br/>
	<a href="$value[url]" target="_blank">$value[title]</a><br/>
	$value[excerpt]
	</li>
<!--
EOT;
}print <<<EOT
-->
</ol>

<h2>发表评论</h2>
<p></p>

<form method="post"  name="commentform" action="index.php?action=addcom" id="commentform">
<input type="hidden" name="gid" value="$logid" />
<p><input type="text" name="comname" id="author" value="$ckname" size="40" tabindex="1" />
<label for="author"><small>姓名</small></label></p>

<p><input type="text" name="commail" id="email" value="$ckmail" size="40" tabindex="2" />
<label for="email"><small>Mail (选填)</small></label></p>

<p><textarea name="comment" id="comment" cols="60" rows="10" tabindex="4"></textarea></p>

<p><input name="submit" type="submit" id="submit" tabindex="5" value="发表我的评论" />
$cheackimg 
<input type="checkbox" name="remember" value="1" checked="checked" class="inp" /><small>记住我</small></p>


</form>

</div>
<!--
EOT;
print <<<EOT
-->
</div><!--end-->
EOT;
include getViews('side');
include getViews('footer');
?>