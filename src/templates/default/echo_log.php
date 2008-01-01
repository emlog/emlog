<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
//include getViews('side');
//$att_img = getAttachment($att_img,600,500);
print <<<EOT
-->
<div class="logcontent">
<p id="tit">$log_title</p>
<p class="line">$post_time $log_author</p>
<div class="log_con">
$log_content
<a name="att"></a>
<p>$att_img</p>
<p>$attachment</p>	
<p>$tag</p>
</div>
<div id="tb_list">
<p><b>引用:</b><a name="tb"></a></p>
<li class="tburl">GBk: {$blogurl}trackback.php?id=$logid&amp;charset=gbk</li>  
<li class="tburl">UTF-8: {$blogurl}trackback.php?id=$logid&amp;charset=utf-8</li>
</div>
<!--
EOT;
foreach($tb as $key=>$value){
print <<<EOT
-->
<div class="trackback">
	<li>来自: <a href="$value[url]" target="_blank">$value[blog_name]</a></li>
    <li>标题: <a href="$value[url]" target="_blank">$value[title]</a> </li>
    <li>摘要: $value[excerpt]</li>
	<li>引用时间: $value[date]</li>
</div>
<!--
EOT;
}print <<<EOT
-->	
<p><b>网友评论:</b><a name="comment"></a></p>
<div id="com_list">
<ol>
<!--
EOT;
foreach($com as $key=>$value){
print <<<EOT
-->
<li><a name="$value[cid]"></a>$value[poster] $value[addtime]<br />$value[content]</li>
<!--
EOT;
}print <<<EOT
-->	
</ol>
</div>

<br />
<form  method="post"  name="commentform" action="index.php?action=addcom">
<table width="620" border="0" cellspacing="5" cellpadding="0">
<tr>
<td class="f14">姓　 名：</td>
<td>
<input type="hidden" name="gid" value="$logid" />
<input type="text" name="comname" style="width:220px" maxlength="49" value="$ckname"></td>
</tr>
<tr>
<td class="f14">电子邮件:</td>
<td><input type="text" name="commail" style="width:360px" maxlength="128"  value="$ckmail"> (选填)</td>
</tr>
<tr>
<td valign="top" class="f14">内　 容：</td>
<td><textarea name="comment" style="width:520px;height:155px"></textarea>
</td>
</tr>

<tr>
<td valign="top"class="f14">&nbsp;</td>
<td valign="top" class="f14">$cheackimg<input name="Submit" type="submit" value="发表评论" onclick="return checkform()" />
<input type="checkbox" name="remember" value="1" checked="checked" />记住我</td>
</tr>
</table>
</form>
</div>
EOT;
include getViews('footer');
?>