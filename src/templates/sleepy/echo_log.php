<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
//$att_img = getAttachment($att_img,500,300);
print <<<EOT
-->

<div class="narrowcolumn">

		<div class="top-menu">
		<ul>
			<li><h1><a href="./"><strong>$blogname</strong></a></h1> <br />$blog_info</li>
		</ul>
	</div>

	<div id="banner">&#160;</div>

	<div class="post" id="post-$logid">

		<h2>$log_title</h2>
<div class="entry">

				$log_content
<a name="att"></a>
<p>$att_img</p>
<p>$attachment</p>	
<p>$tag</p>			
<p class="postinfo">Posted on $post_time</p>

<div class="comments-template">
<h2 id="comments">引用:<a name="tb"></a></h2>
<p>GBk: {$blogurl}trackback.php?id=$logid&amp;charset=gbk</p>  
<p>UTF-8: {$blogurl}trackback.php?id=$logid&amp;charset=utf-8</p>
</div>

			<div class="comments-template">
				
<!-- You can start editing here. -->

	<h3 id="comments">评论</h3>

<ol class="commentlist">


<!--
EOT;
foreach($com as $key=>$value){
print <<<EOT
-->
	<li class="alt" id="comment-2"><a name="$value[cid]"></a>
<div class="commentmetadata">
<strong>$value[poster]</strong>, on $value[addtime] Said&#58; 
</div>

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
	<li class="alt" id="comment-2">trackback by <strong><a href="$value[url]" target="_blank">$value[blog_name]</a></strong> on $value[date] <br />
	<a href="$value[url]" target="_blank">$value[title]</a><br/>
	$value[excerpt]
	</li>
<!--
EOT;
}print <<<EOT
-->

</ol>




		<h3 id="respond">发表评论</h3>


<form  method="post"  name="commentform" action="index.php?action=addcom" id="commentform">
	<p>
	  <input type="text" name="comname" id="email" value="$ckname" size="25" tabindex="1" class="input"/>
	   <label for="author"><small>姓名</small></label>
	<input type="hidden" name="gid" value="$logid" />
	</p>

	<p>
	  <input type="text" name="commail" id="email" value="$ckmail" size="25" tabindex="2" class="input"/>
	   <label for="email"><small>邮件地址(选填)</small></label>
	</p>

	<p>
	  <label for="comment"><small>评论内容</small></label>
	  <br />
	  <textarea name="comment" id="comment" cols="40" rows="10" tabindex="4" class="input"></textarea>
	</p>

	<p>
	 <input name="submit" type="submit" tabindex="5" value="发布我的评论" onclick="return checkform()" /> $cheackimg <input type="checkbox" name="remember" value="1" checked="checked" /><small>记住我</small></td>
	</p>
</form>


			</div>

		</div>
	</div>
</div>
EOT;
include getViews('side');
include getViews('footer');
?>