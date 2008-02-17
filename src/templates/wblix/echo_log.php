<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
//$att_img = getAttachment($att_img,600,500);
echo <<<EOT
-->
<div id="content">
<div class="entry single">

<h1>$log_title</h1>

<p class="info">
<em class="date">Posted on $post_time</em>
</p>
				$log_content
<a name="att"></a>
<p>$att_img</p>
<p>$attachment</p>	
<p>$tag</p>
<p>$neighborLog</P>
</div>

<!--
EOT;
if($allow_tb == 'y'){
echo <<<EOT
-->	
<div class="comments-template">
<h2 id="comments">引用:<a name="tb"></a></h2>
<p>GBk: {$blogurl}trackback.php?id=$logid&amp;charset=gbk</p>  
<p>UTF-8: {$blogurl}trackback.php?id=$logid&amp;charset=utf-8</p>
</div>
<!--
EOT;
}echo <<<EOT
-->

<div class="comments-template">
<h2 id="comments"><a name="comment"></a>评论</h2>

<p></p>

<ol id="commentlist">
<!--
EOT;
foreach($com as $key=>$value){
echo <<<EOT
-->
	<li id="comment-$value[cid]"><a name="$value[cid]"></a>
	<cite>Comment by <strong>$value[poster]</strong> &#8212; $value[addtime]</cite>
	<br />
	$value[content]	</li>
<!--
EOT;
}echo <<<EOT
-->
</ol>

<ol id="commentlist">
<!--
EOT;
foreach($tb as $key=>$value){
echo <<<EOT
-->
	<li id="comment-$value[cid]">
	<cite>Trackback by <strong><a href="$value[url]" target="_blank">$value[blog_name]</a></strong> &#8212; $value[date]</cite><br/>
	<a href="$value[url]" target="_blank">$value[title]</a><br/>
	$value[excerpt]
	</li>
<!--
EOT;
}echo <<<EOT
-->
</ol>
<!--
EOT;
if($allow_remark == 'y'){
echo <<<EOT
-->
<h2>发表评论</h2>
<p></p>

<form method="post"  name="commentform" action="index.php?action=addcom" id="commentform">
<fieldset>

<input type="hidden" name="gid" value="$logid" />
<p>
  <label for="author">姓名</label> <input type="text" name="comname" id="author" value="$ckname" tabindex="1" />
</p>

<p><label for="email">电子邮件</label> <input type="text" name="commail" id="email" value="$ckmail" tabindex="2" />
  <em>(选填)</em>
</p>

<p><label for="email">个人主页</label> <input type="text" name="comurl" id="email" value="$ckurl" tabindex="2" />
  <em>(选填)</em>
</p>

<p>
  <label for="comment">内容</label> <textarea name="comment" id="comment" cols="45" rows="10" tabindex="4"></textarea></p>
<p><input type="hidden" name="comment_post_ID" value="7" />
<input type="submit" name="submit" value="发布我的评论" class="button" tabindex="5" onclick="return checkform()"/>
$cheackimg 
<input type="checkbox" name="remember" value="1" checked="checked" class="inp" /><small>记住我</small></p>

</fieldset>
</form>
<!--
EOT;
}echo <<<EOT
-->
</div>
<!--
EOT;
echo <<<EOT
-->
</div><!--end-->
EOT;
include getViews('side');
include getViews('footer');
?>