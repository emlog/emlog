<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
$att_img = getAttachment($att_img,350,300);
$datetime = explode("-",$post_time);
$year = $datetime[0]."/".$datetime[1];
$day = substr($datetime[2],0,2);
echo <<<EOT
-->
<div class="post">
	<div class="postdate">
	  <p class="date">{$day}th</p>
	  <p class="year">$year</p>
	</div>
	<div class="posttitle">
	<h2>$log_title</h2>
    <p class="postmeta"></p>
    </div>

	<div class="content">
		<p>$log_content</p>
		<a name="att"></a>
		<p>$att_img</p>
		<p>$attachment</p>	
		<p class="tags">$tag</p>
		<p>$neighborLog</P>			
	</div>				
<!--
EOT;
if($allow_tb == 'y'){
echo <<<EOT
-->	
	<div id="comments">
	<h3 id="respond">引用地址：{$blogurl}tb.php?sc={$tbscode}&amp;id={$logid}<a name="tb"></a></h3>
	</div>
<!--
EOT;
}echo <<<EOT
-->	
<div id="comments">
<h3 id="respond"><a name="comment"></a>评论</h3>
<p></p>

<ol class="commentlist">
<!--
EOT;
foreach($com as $key=>$value){
$value['reply'] = $value['reply']?"<span style=\"color:green;\"><b>博主回复</b>：{$value['reply']}</span>":'';
echo <<<EOT
-->
	<li class="alt" id="comment-$value[cid]"><a name="$value[cid]"></a>
			$value[poster] Says:<br />
			<small class="commentmetadata">$value[addtime] </small>
			<p>$value[content]</p>
			<p>$value[reply]</p>
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
	<cite>引用来自：<strong><a href="$value[url]" target="_blank">$value[blog_name]</a></strong> &#8212; $value[date]</cite>		<br/>
	<cite>标题：<a href="$value[url]" target="_blank">$value[title]</a></cite><br />
	<cite>摘要：$value[excerpt]</cite>
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
<h3 id="respond">发表评论</h3>
<p></p>
<form  method="post"  name="commentform" action="index.php?action=addcom" id="commentform">
	<p>
	  <input type="text" name="comname" id="email" value="$ckname" size="40" tabindex="1" />
	   <label for="author"><small>姓名</small></label>
	<input type="hidden" name="gid" value="$logid" />
	</p>

	<p>
	  <input type="text" name="commail" id="email" value="$ckmail" size="40" tabindex="2" />
	   <label for="email"><small>邮件地址(选填)</small></label>
	</p>
	<p>
	  <input type="text" name="comurl" id="email" value="$ckurl" size="40" tabindex="2" />
	   <label for="email"><small>个人主页(选填)</small></label>
	</p>
	<p>
	  <textarea name="comment" id="comment" cols="55" rows="15" tabindex="4"></textarea>
	</p>

	<p>
	 <input name="submit" id="submit" type="submit" tabindex="5" value="发布我的评论" onclick="return checkform()" /> $cheackimg <input type="checkbox" name="remember" value="1" checked="checked" /><small>记住我</small></td>
	</p>
</form>
</div>
<!--
EOT;
}echo <<<EOT
-->
</div>
</div>
</div>
</div>
EOT;
include getViews('footer');
?>